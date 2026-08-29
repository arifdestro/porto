<?php

namespace App\Http\Controllers;

use App\Models\SiteSetting;
use App\Models\Portfolio;
use App\Models\Skill;
use App\Models\Experience;
use App\Models\SocialLink;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use App\Mail\ContactMessage;

class HomeController extends Controller
{
    /**
     * Display the portfolio landing page.
     */
    public function index()
    {
        $settings = Cache::rememberForever('site_settings', function () {
            return SiteSetting::pluck('value', 'key');
        });

        $portfolios = Cache::rememberForever('portfolios_active', function () {
            return Portfolio::active()->ordered()->get();
        });

        $skills = Cache::rememberForever('skills_active', function () {
            return Skill::active()->ordered()->get();
        });

        $experiences = Cache::rememberForever('experiences_active', function () {
            return Experience::active()->ordered()->get();
        });

        $socialLinks = Cache::rememberForever('social_links_active', function () {
            return SocialLink::active()->ordered()->get();
        });

        return view('landing.index', compact('settings', 'portfolios', 'skills', 'experiences', 'socialLinks'));
    }

    /**
     * Handle the contact form submission.
     */
    public function sendContact(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
            'cf-turnstile-response' => 'required'
        ], [
            'cf-turnstile-response.required' => 'Silakan centang kotak "Verify you are human".'
        ]);

        // Verify Turnstile
        $response = Http::asForm()->post('https://challenges.cloudflare.com/turnstile/v0/siteverify', [
            'secret' => env('TURNSTILE_SECRET_KEY'),
            'response' => $request->input('cf-turnstile-response'),
            'remoteip' => $request->ip()
        ]);

        if (!$response->json('success')) {
            return back()->withInput()->with('error', 'Validasi Turnstile gagal. Silakan coba lagi.');
        }

        // Anti-Injection / XSS Protection
        $validated['name'] = strip_tags($validated['name']);
        $validated['email'] = strip_tags($validated['email']);
        $validated['subject'] = strip_tags($validated['subject']);
        $validated['message'] = htmlspecialchars(strip_tags($validated['message']));

        $settings = SiteSetting::pluck('value', 'key');
        $recipientEmail = $settings['contact_email'] ?? 'hello@example.com';

        try {
            Mail::to($recipientEmail)->send(new ContactMessage($validated));
            return back()->with('success', 'Your message has been sent successfully! I will get back to you soon.');
        } catch (\Exception $e) {
            return back()->with('error', 'Sorry, there was an error sending your message. Please try again later.');
        }
    }
}
