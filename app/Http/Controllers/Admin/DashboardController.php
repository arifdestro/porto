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
        $today = \Carbon\Carbon::today();
        
        $stats = [
            'portfolios' => Portfolio::count(),
            'skills' => Skill::count(),
            'experiences' => Experience::count(),
            'social_links' => SocialLink::count(),
            'posts' => \App\Models\Post::count(),
            'visitors_today' => \App\Models\Visitor::whereDate('created_at', $today)->count(),
            'visitors_total' => \App\Models\Visitor::count(),
            'pageviews_total' => \App\Models\Post::sum('views'),
        ];
        
        $recentVisitors = \App\Models\Visitor::latest()->limit(5)->get();
        $popularPosts = \App\Models\Post::orderBy('views', 'desc')->limit(5)->get();

        return view('admin.dashboard', compact('stats', 'recentVisitors', 'popularPosts'));
    }
}
