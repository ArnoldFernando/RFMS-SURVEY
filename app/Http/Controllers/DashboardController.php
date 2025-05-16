<?php

namespace App\Http\Controllers;

use App\Models\File;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function dashboard(Request $request)
    {
        $month = $request->get('month') ?? now()->format('m');
        $year = $request->get('year') ?? now()->format('Y');

        $startOfMonth = Carbon::createFromDate($year, $month)->startOfMonth();
        $endOfMonth = Carbon::createFromDate($year, $month)->endOfMonth();

        $weeklyData = File::selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->where('status', 'action_completed')
            ->whereBetween('created_at', [$startOfMonth, $endOfMonth])
            ->groupBy('date')
            ->orderBy('date')
            ->get();


        $action_completed_weekly = [];

        // Last 7 days
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::today()->subDays($i);
            $count = File::where('status', 'action_completed')
                ->whereDate('updated_at', $date)
                ->count();

            $action_completed_weekly[] = [
                'date' => $date->format('M d'),
                'count' => $count,
            ];
        }

        return view('dashboard', [
            'for_action' => File::where('status', 'for_action')->count(),
            'action_completed' => File::where('status', 'action_completed')->count(),
            'archived' => File::where('status', 'archived')->count(),
            'weeklyData' => $action_completed_weekly,
            'weeklyData' => $weeklyData,
            'month' => $month,
            'year' => $year,
        ]);
    }
}
