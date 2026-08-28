<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Portfolio;
use App\Models\Skill;
use App\Models\Experience;
use App\Models\SocialLink;

class DashboardController extends Controller
{
    /**
     * Display the admin dashboard with content statistics.
     */
    public function index()
    {
        $stats = [
            'portfolios' => Portfolio::count(),
            'skills' => Skill::count(),
            'experiences' => Experience::count(),
            'social_links' => SocialLink::count(),
        ];

        return view('admin.dashboard', compact('stats'));
    }
}
