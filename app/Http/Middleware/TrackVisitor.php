<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Visitor;
use Carbon\Carbon;

class TrackVisitor
{
    public function handle(Request $request, Closure $next): Response
    {
        $ip = $request->ip();
        $page = $request->path();
        
        // Check if this IP visited this page today
        $visitedToday = Visitor::where('ip_address', $ip)
            ->where('page_visited', $page)
            ->whereDate('created_at', Carbon::today())
            ->exists();
            
        if (!$visitedToday) {
            Visitor::create([
                'ip_address' => $ip,
                'user_agent' => $request->userAgent(),
                'page_visited' => $page
            ]);
        }
        
        return $next($request);
    }
}
