<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    /**
     * Image-type setting keys that accept file uploads.
     */
    protected array $imageKeys = ['hero_image', 'about_image', 'hero_cv'];

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
        $settings = SiteSetting::all();

        foreach ($settings as $setting) {
            $key = $setting->key;

            // Handle file uploads for image-type settings
            if (in_array($key, $this->imageKeys)) {
                if ($request->hasFile($key)) {
                    // Delete old file if it exists
                    $oldValue = $setting->value;
                    if ($oldValue && file_exists(public_path($oldValue))) {
                        unlink(public_path($oldValue));
                    }

                    $file = $request->file($key);
                    $filename = time() . '_' . $file->getClientOriginalName();
                    $file->move(public_path('uploads'), $filename);

                    $setting->update(['value' => 'uploads/' . $filename]);
                }
            } else {
                // Handle regular text/textarea settings
                if ($request->has($key)) {
                    $setting->update(['value' => $request->input($key)]);
                }
            }
        }

        return redirect()
            ->route('admin.settings.index')
            ->with('success', 'Settings updated successfully.');
    }
}
