<?php

namespace App\Helpers;

use Illuminate\Http\UploadedFile;

class ImageHelper
{
    /**
     * Process an uploaded image: resize to max width and convert to WebP.
     * Uses PHP built-in GD extension (no extra package required).
     *
     * @param UploadedFile $file     The uploaded file
     * @param string       $destDir  Destination folder relative to public_path()
     * @param int          $maxWidth Maximum width in pixels
     * @param int          $quality  WebP quality 1-100
     * @return string                Relative path saved (e.g. 'uploads/portfolios/abc.webp')
     */
    public static function processAndSave(
        UploadedFile $file,
        string $destDir,
        int $maxWidth = 1200,
        int $quality = 80
    ): string {
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
                // Resize proportionally if wider than maxWidth
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
