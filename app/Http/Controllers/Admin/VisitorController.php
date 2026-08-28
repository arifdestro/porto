<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Visitor;
use Illuminate\Http\Request;
use Carbon\Carbon;

class VisitorController extends Controller
{
    public function index()
    {
        // Data for the table
        $visitors = Visitor::latest()->paginate(50);

        // Data for the chart (last 7 days)
        $chartData = [];
        $chartLabels = [];
        
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i)->format('Y-m-d');
            $count = Visitor::whereDate('created_at', $date)->count();
            
            $chartLabels[] = Carbon::now()->subDays($i)->format('d M');
            $chartData[] = $count;
        }

        return view('admin.visitors.index', compact('visitors', 'chartLabels', 'chartData'));
    }
}
