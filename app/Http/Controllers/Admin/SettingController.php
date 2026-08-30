<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Helpers\ImageHelper;
use App\Models\SiteSetting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    /**
     * Image-type setting keys that accept file uploads.
     */
    protected array $imageKeys = ['hero_image', 'about_image', 'hero_cv', 'hero_cv_en', 'hero_cv_id'];

    /**
     * Display the settings form grouped by the group field.
     */
    public function index()
    {
        $settings = SiteSetting::pluck('value', 'key');

        return view('admin.settings.index', compact('settings'));
    }

    /**
     * Update all settings from the form submission.
     */
    public function update(Request $request)
    {
        // Keys that are boolean checkboxes (not sent when unchecked)
        $booleanKeys = ['available_for_work'];
        
        // Allowed keys to update to prevent mass assignment issues
        $allowedKeys = [
            'hero_title', 'hero_subtitle', 'hero_description', 'hero_image', 'hero_cv', 'hero_cv_en', 'hero_cv_id',
            'about_title', 'about_description', 'about_image',
            'contact_email', 'contact_address',
            'site_name', 'github_username', 'footer_text', 'available_for_work'
        ];

        foreach ($allowedKeys as $key) {
            $setting = SiteSetting::firstOrNew(['key' => $key]);
            
            // Set default group based on key prefix
            if (str_starts_with($key, 'hero')) $setting->group = 'hero';
            elseif (str_starts_with($key, 'about')) $setting->group = 'about';
            elseif (str_starts_with($key, 'contact')) $setting->group = 'contact';
            else $setting->group = 'general';
            
            // Set type
            if (in_array($key, $this->imageKeys)) $setting->type = 'image';
            else $setting->type = 'text';

            // Handle file uploads for image-type settings
            if (in_array($key, $this->imageKeys)) {
                if ($request->hasFile($key)) {
                    // Delete old file if it exists
                    $oldValue = $setting->value;
                    if ($oldValue) {
                        \App\Helpers\ImageHelper::delete($oldValue);
                    }

                    // Convert to WebP and resize automatically (or bypass for PDF)
                    $relativePath = ImageHelper::processAndSave(
                        $request->file($key),
                        'uploads',
                        1200,
                        82
                    );

                    $setting->value = $relativePath;
                    $setting->save();
                }
            } elseif (in_array($key, $booleanKeys)) {
                // Checkboxes: send '1' when checked, '0' when unchecked (not sent)
                $setting->value = $request->has($key) ? '1' : '0';
                $setting->save();
            } else {
                // Handle regular text/textarea settings
                if ($request->has($key)) {
                    $setting->value = $request->input($key);
                    $setting->save();
                }
            }
        }

        return redirect()
            ->route('admin.settings.index')
            ->with('success', 'Settings updated successfully.');
    }
}
