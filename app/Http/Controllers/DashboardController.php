<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BeritaAcara;
use App\Models\WajibPajak;
use App\Models\Pegawai;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        if (auth()->user()->role == 'admin') {
            // ================================
            // Stat counts
            // ================================
            $todayCount = BeritaAcara::whereDate('created_at', Carbon::today())->count();
            $weekStart  = Carbon::now()->startOfWeek();
            $weekEnd    = Carbon::now()->endOfWeek();
            $thisWeekCount = BeritaAcara::whereBetween('created_at', [$weekStart, $weekEnd])->count();
            $monthStart = Carbon::now()->startOfMonth();
            $monthEnd   = Carbon::now()->endOfMonth();
            $thisMonthCount = BeritaAcara::whereBetween('created_at', [$monthStart, $monthEnd])->count();
            $totalAll   = BeritaAcara::count();
            $totalWp    = WajibPajak::count();
            $totalPegawai = Pegawai::count();

            // ================================
            // Monthly chart data (bar)
            // ================================
            $months = [];
            $counts = [];
            for ($i = 1; $i <= 12; $i++) {
                $ms = Carbon::create(null, $i, 1)->startOfMonth();
                $me = Carbon::create(null, $i, 1)->endOfMonth();
                $months[] = $ms->isoFormat('MMM');
                $counts[] = BeritaAcara::whereBetween('created_at', [$ms, $me])->count();
            }

            // ================================
            // PBB vs PBJT pie chart (this year)
            // ================================
            $tahunIni = Carbon::now()->year;
            $pbbCount = BeritaAcara::whereHas('wajibPajak', function ($q) {
                    $q->where('jenis', 'pbb');
                })
                ->whereYear('created_at', $tahunIni)
                ->count();
            $pbjtCount = BeritaAcara::whereHas('wajibPajak', function ($q) {
                    $q->where('jenis', '!=', 'pbb');
                })
                ->whereYear('created_at', $tahunIni)
                ->count();

            // ================================
            // Monthly PBB vs PBJT breakdown (stacked / grouped)
            // ================================
            $pbbMonthly = [];
            $pbjtMonthly = [];
            for ($i = 1; $i <= 12; $i++) {
                $ms = Carbon::create(null, $i, 1)->startOfMonth();
                $me = Carbon::create(null, $i, 1)->endOfMonth();

                $pbbMonthly[] = BeritaAcara::whereHas('wajibPajak', fn($q) => $q->where('jenis', 'pbb'))
                    ->whereBetween('created_at', [$ms, $me])->count();

                $pbjtMonthly[] = BeritaAcara::whereHas('wajibPajak', fn($q) => $q->where('jenis', '!=', 'pbb'))
                    ->whereBetween('created_at', [$ms, $me])->count();
            }

            // ================================
            // Top 5 petugas by activity
            // ================================
            $topPetugas = DB::query()
                ->fromSub(
                    DB::table('berita_acara')
                        ->select('pegawai1 as id', DB::raw('COUNT(*) as total'))
                        ->whereYear('created_at', $tahunIni)
                        ->groupBy('pegawai1')
                        ->unionAll(
                            DB::table('berita_acara')
                                ->select('pegawai2 as id', DB::raw('COUNT(*) as total'))
                                ->whereYear('created_at', $tahunIni)
                                ->whereNotNull('pegawai2')
                                ->groupBy('pegawai2')
                        ),
                    'gabungan'
                )
                ->join('pegawai', 'pegawai.id', '=', 'gabungan.id')
                ->select('pegawai.nama_pegawai', DB::raw('SUM(total) as jumlah'))
                ->groupBy('pegawai.id', 'pegawai.nama_pegawai')
                ->orderBy('jumlah', 'desc')
                ->limit(5)
                ->get();

            return view('index', compact(
                'todayCount', 'thisWeekCount', 'thisMonthCount', 'totalAll',
                'totalWp', 'totalPegawai',
                'months', 'counts',
                'pbbCount', 'pbjtCount',
                'pbbMonthly', 'pbjtMonthly',
                'topPetugas'
            ));
        }

        $totalAll = BeritaAcara::count();
        return view('index', compact('totalAll'));
    }
}
