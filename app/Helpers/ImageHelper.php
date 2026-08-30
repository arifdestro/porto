<?php

namespace App\Helpers;

use Illuminate\Http\UploadedFile;

class ImageHelper
{
    /**
     * Delete an image safely (catches Vercel read-only filesystem errors).
     *
     * @param string|null $path Path or URL to the image
     */
    public static function delete(?string $path): void
    {
        if (!$path) return;

        // If it's a cloudinary URL, don't try to delete locally
        if (str_starts_with($path, 'http')) {
            // (Optional) add Cloudinary delete logic here if needed
            return;
        }

        $fullPath = public_path($path);
        if (file_exists($fullPath)) {
            try {
                unlink($fullPath);
            } catch (\Exception $e) {
                // Ignore read-only file system errors on Vercel
                // Log::info('Skipped deleting file due to read-only FS: ' . $path);
            }
        }
    }

    /**
     * Process an uploaded image: resize, convert, and save (Local or Cloudinary).
     */
    public static function processAndSave(
        UploadedFile $file,
        string $destDir,
        int $maxWidth = 1200,
        int $quality = 80
    ): string {
        
        // 1. Check if Cloudinary is configured
        $cloudinaryUrl = env('CLOUDINARY_URL');
        if (!empty($cloudinaryUrl)) {
            try {
                $urlParts = parse_url($cloudinaryUrl);
                $apiKey = $urlParts['user'];
                $apiSecret = $urlParts['pass'];
                $cloudName = $urlParts['host'];

                $timestamp = time();
                $folder = 'porto/' . $destDir;

                $params = [
                    'folder' => $folder,
                    'timestamp' => $timestamp
                ];
                ksort($params);
                
                $sigStr = '';
                foreach ($params as $k => $v) {
                    $sigStr .= $k . '=' . $v . '&';
                }
                $sigStr = rtrim($sigStr, '&');
                $signature = sha1($sigStr . $apiSecret);

                $ch = curl_init("https://api.cloudinary.com/v1_1/{$cloudName}/auto/upload");
                $postFields = [
                    'api_key' => $apiKey,
                    'timestamp' => $timestamp,
                    'folder' => $folder,
                    'signature' => $signature,
                    'file' => new \CURLFile($file->getRealPath(), $file->getMimeType(), $file->getClientOriginalName())
                ];

                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $postFields);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                $response = curl_exec($ch);
                curl_close($ch);

                $json = json_decode($response, true);
                
                if (isset($json['secure_url'])) {
                    $url = $json['secure_url'];
                    
                    // Inject transformation for images (not for raw/pdf)
                    if ($json['resource_type'] === 'image' && strpos($url, '/image/upload/') !== false) {
                        $ext = strtolower(pathinfo(parse_url($url, PHP_URL_PATH), PATHINFO_EXTENSION));
                        if ($ext !== 'pdf') {
                            $transform = "c_limit,w_{$maxWidth},q_{$quality},f_webp";
                            $url = str_replace('/image/upload/', '/image/upload/' . $transform . '/', $url);
                        } else {
                            // Force download for PDFs
                            $url = str_replace('/image/upload/', '/image/upload/fl_attachment/', $url);
                        }
                    }
                    
                    return $url;
                } else {
                    \Illuminate\Support\Facades\Log::error('Cloudinary upload error: ' . $response);
                }
            } catch (\Exception $e) {
                \Illuminate\Support\Facades\Log::error('Cloudinary exception: ' . $e->getMessage());
                // Fall back to local upload if Cloudinary fails
            }
        }

        // 2. Local fallback (GD-based processing)
        $destPath = public_path($destDir);

        if (!is_dir($destPath)) {
            mkdir($destPath, 0755, true);
        }

        $filename = time() . '_' . pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME) . '.webp';
        $fullPath = $destPath . DIRECTORY_SEPARATOR . $filename;

        // Attempt GD-based processing
        if (function_exists('imagewebp')) {
            $mime = $file->getMimeType();
            $source = null;

            if ($mime === 'image/jpeg' || $mime === 'image/jpg') {
                $source = @imagecreatefromjpeg($file->getRealPath());
            } elseif ($mime === 'image/png') {
                $source = @imagecreatefrompng($file->getRealPath());
            } elseif ($mime === 'image/webp') {
                $source = @imagecreatefromwebp($file->getRealPath());
            } elseif ($mime === 'image/gif') {
                $source = @imagecreatefromgif($file->getRealPath());
            }

            if ($source) {
                $origW = imagesx($source);
                $origH = imagesy($source);

                if ($origW > $maxWidth) {
                    $newW = $maxWidth;
                    $newH = (int) round($origH * ($maxWidth / $origW));
                    $resized = imagecreatetruecolor($newW, $newH);
                    imagealphablending($resized, false);
                    imagesavealpha($resized, true);
                    imagecopyresampled($resized, $source, 0, 0, 0, 0, $newW, $newH, $origW, $origH);
                    imagedestroy($source);
                    $source = $resized;
                }

                imagewebp($source, $fullPath, $quality);
                imagedestroy($source);

                return $destDir . '/' . $filename;
            }
        }

        // Fallback: GD not available, store as original format
        $fallbackFilename = time() . '_' . $file->getClientOriginalName();
        $file->move($destPath, $fallbackFilename);
        return $destDir . '/' . $fallbackFilename;
    }
}
