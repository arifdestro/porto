<?php

namespace Database\Seeders;

use App\Models\SiteSetting;
use Illuminate\Database\Seeder;

class SiteSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $settings = [
            // Hero section
            [
                'key' => 'hero_title',
                'value' => 'Hello, I\'m John Doe',
                'type' => 'text',
                'group' => 'hero',
            ],
            [
                'key' => 'hero_subtitle',
                'value' => 'Full Stack Developer & UI/UX Designer',
                'type' => 'text',
                'group' => 'hero',
            ],
            [
                'key' => 'hero_description',
                'value' => 'I create beautiful and functional web experiences',
                'type' => 'textarea',
                'group' => 'hero',
            ],
            [
                'key' => 'hero_image',
                'value' => '',
                'type' => 'image',
                'group' => 'hero',
            ],
            [
                'key' => 'hero_cv',
                'value' => '',
                'type' => 'image',
                'group' => 'hero',
            ],

            // About section
            [
                'key' => 'about_title',
                'value' => 'About Me',
                'type' => 'text',
                'group' => 'about',
            ],
            [
                'key' => 'about_description',
                'value' => 'I am a passionate developer with 5+ years of experience in web development. I specialize in creating modern, responsive, and user-friendly websites and applications.',
                'type' => 'textarea',
                'group' => 'about',
            ],
            [
                'key' => 'about_image',
                'value' => '',
                'type' => 'image',
                'group' => 'about',
            ],

            // Contact section
            [
                'key' => 'contact_email',
                'value' => 'hello@example.com',
                'type' => 'text',
                'group' => 'contact',
            ],
            [
                'key' => 'contact_phone',
                'value' => '+62 812 3456 7890',
                'type' => 'text',
                'group' => 'contact',
            ],
            [
                'key' => 'contact_address',
                'value' => 'Jakarta, Indonesia',
                'type' => 'text',
                'group' => 'contact',
            ],

            // General
            [
                'key' => 'site_name',
                'value' => 'Porto',
                'type' => 'text',
                'group' => 'general',
            ],
            [
                'key' => 'footer_text',
                'value' => '© 2024 Porto. All rights reserved.',
                'type' => 'text',
                'group' => 'general',
            ],
        ];

        foreach ($settings as $setting) {
            SiteSetting::updateOrCreate(
                ['key' => $setting['key']],
                $setting
            );
        }
    }
}
