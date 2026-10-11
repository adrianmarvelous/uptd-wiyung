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
            // Monthly chart data (bar) — ONE query for all 12 months
            // ================================
            $tahunIni = Carbon::now()->year;

            $monthlyTotals = DB::table('berita_acara')
                ->selectRaw('MONTH(created_at) as bulan, COUNT(*) as total')
                ->whereYear('created_at', $tahunIni)
                ->groupBy('bulan')
                ->pluck('total', 'bulan'); // [1 => n, 2 => n, ...]

            $months = [];
            $counts = [];
            for ($i = 1; $i <= 12; $i++) {
                $months[] = Carbon::create($tahunIni, $i, 1)->isoFormat('MMM');
                $counts[] = (int) ($monthlyTotals[$i] ?? 0);
            }

            // ================================
            // Monthly PBB vs PBJT breakdown — ONE query
            // ================================
            $monthlyJenis = DB::table('berita_acara')
                ->join('wajib_pajak', 'wajib_pajak.id', '=', 'berita_acara.id_wajib_pajak')
                ->selectRaw(
                    "MONTH(berita_acara.created_at) as bulan, " .
                    "CASE WHEN wajib_pajak.jenis = 'pbb' THEN 'pbb' ELSE 'pbjt' END as kategori, " .
                    "COUNT(*) as total"
                )
                ->whereYear('berita_acara.created_at', $tahunIni)
                ->groupBy('bulan', 'kategori')
                ->get();

            $pbbMonthly  = array_fill(0, 12, 0);
            $pbjtMonthly = array_fill(0, 12, 0);

            foreach ($monthlyJenis as $row) {
                $idx = ((int) $row->bulan) - 1;
                if ($row->kategori === 'pbb') {
                    $pbbMonthly[$idx] = (int) $row->total;
                } else {
                    $pbjtMonthly[$idx] = (int) $row->total;
                }
            }

            // Pie chart totals (this year) — derived from the same result set
            $pbbCount  = array_sum($pbbMonthly);
            $pbjtCount = array_sum($pbjtMonthly);

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
