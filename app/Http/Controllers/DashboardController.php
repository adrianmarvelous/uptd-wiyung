<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BeritaAcara;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        if (auth()->user()->role == 'admin') {
            // ================================
            // Count for today
            // ================================
            $todayCount = BeritaAcara::whereDate('created_at', Carbon::today())->count();

            // ================================
            // Count for this week
            // ================================
            // Assuming week starts on Monday
            $weekStart = Carbon::now()->startOfWeek();
            $weekEnd   = Carbon::now()->endOfWeek();

            $thisWeekCount = BeritaAcara::whereBetween('created_at', [$weekStart, $weekEnd])->count();

            // ================================
            // Count for this month
            // ================================
            $monthStart = Carbon::now()->startOfMonth();
            $monthEnd   = Carbon::now()->endOfMonth();

            $thisMonthCount = BeritaAcara::whereBetween('created_at', [$monthStart, $monthEnd])->count();


            // Prepare data for bar chart
            $months = [];
            $counts = [];

            for ($i = 1; $i <= 12; $i++) {
                $monthStart = Carbon::create(null, $i, 1)->startOfMonth();
                $monthEnd = Carbon::create(null, $i, 1)->endOfMonth();

                $months[] = $monthStart->format('F'); // e.g., January
                $counts[] = BeritaAcara::whereBetween('created_at', [$monthStart, $monthEnd])->count();
            }

            // Only pass data if admin
            return view('index', compact('todayCount', 'thisWeekCount', 'thisMonthCount','months','counts'));
        }
        // You can pass data to the view if needed
        return view('index'); 
    }
}
