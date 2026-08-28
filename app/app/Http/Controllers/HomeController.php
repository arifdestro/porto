<?php

namespace App\Http\Controllers;

use App\Models\SiteSetting;
use App\Models\Portfolio;
use App\Models\Skill;
use App\Models\Experience;
use App\Models\SocialLink;

class HomeController extends Controller
{
    /**
     * Display the portfolio landing page.
     */
    public function index()
    {
        $settings = SiteSetting::pluck('value', 'key');
        $portfolios = Portfolio::active()->ordered()->get();
        $skills = Skill::active()->ordered()->get();
        $experiences = Experience::active()->ordered()->get();
        $socialLinks = SocialLink::active()->ordered()->get();

        return view('landing.index', compact('settings', 'portfolios', 'skills', 'experiences', 'socialLinks'));
    }
}
