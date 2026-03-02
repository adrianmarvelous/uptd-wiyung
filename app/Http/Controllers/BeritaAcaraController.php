<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\WajibPajak;
use App\Rules\SafeInput;
use App\Models\Pegawai;
use App\Models\BeritaAcara;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Mpdf\Mpdf;
use Carbon\Carbon;


class BeritaAcaraController extends Controller
{
    public function index($jenis)
    {
        $data = BeritaAcara::with(['wajibPajak', 'pegawaiSatu', 'pegawaiDua'])
            ->whereHas('wajibPajak', function ($query) use ($jenis) {
                if ($jenis === 'pbb') {
                    $query->where('jenis', 'pbb');
                } else {
                    $query->where('jenis', '!=', 'pbb');
                }
            })
            ->orderBy('created_at', 'desc')
            ->get();

        return view('berita_acara.index', compact('data', 'jenis'));
    }



    public function search(Request $request)
    {
        $q = $request->q;
        $jenis = $request->jenis;

        if (!$q || strlen($q) < 2) {
            return response()->json([]);
        }

        $query = WajibPajak::query();
        if ($jenis) {
            if ($jenis === 'pbb') {
                $query->where('jenis', 'pbb');
            } else {
                $query->where('jenis', '!=', 'pbb');
            }
        }


        $data = $query
            ->where(function ($q2) use ($q) {
                $q2->where('nop', 'like', "%{$q}%")
                    ->orWhere('nama', 'like', "%{$q}%")
                    ->orWhere('alamat', 'like', "%{$q}%");
            })
            ->limit(10)
            ->get(['id', 'nop', 'nama', 'alamat', 'jenis']);

        return response()->json($data);
    }


    public function create(Request $request)
    {
        $validated = $request->validate([
            'nop' => ['required', 'string', 'max:255', new SafeInput],
            'nama' => ['required', 'string', 'max:255', new SafeInput],
            'alamat' => ['required', 'string', 'max:255', new SafeInput],
        ]);


        $nop = $validated['nop'];
        $nama = $validated['nama'];
        $alamat = $validated['alamat'];

        $wajibPajak = WajibPajak::where('nop', $nop)->first();
        if (!$wajibPajak) {
            return back()->withErrors([
                'nop' => 'Wajib Pajak tidak ditemukan'
            ])->withInput();
        }

        $pegawai = Pegawai::orderBy('nama_pegawai', 'asc')->get();


        return view('berita_acara.create', compact('nop', 'nama', 'alamat', 'pegawai'));
    }

    public function approval_wajib_pajak(Request $request)
    {
        $validated = $request->validate([
            'nop' => ['required', 'string', 'max:255', new SafeInput],
            'nama' => ['required', 'string', 'max:255', new SafeInput],
            'alamat' => ['required', 'string', 'max:255', new SafeInput],
            'nama_responden' => ['required', 'string', 'max:255', new SafeInput],
            'telp' => ['required', 'string', 'max:255', new SafeInput],
            'narasi' => ['required', 'string', new SafeInput],
            'pegawai1' => ['required', 'integer'],
            'pegawai2' => ['nullable', 'integer'],
        ]);

        $nop = $validated['nop'];
        $nama = $validated['nama'];
        $alamat = $validated['alamat'];
        $nama_responden = $validated['nama_responden'];
        $telp = $validated['telp'];
        $narasi = $validated['narasi'];
        $pegawai1_id = $validated['pegawai1'];
        if (isset($validated['pegawai2'])) {
            $pegawai2_id = $validated['pegawai2'];
        } else {
            $pegawai2_id = null;
        }
        $pegawai1 = Pegawai::find($pegawai1_id);
        if ($pegawai2_id) {
            $pegawai2 = Pegawai::find($pegawai2_id);
        } else {
            $pegawai2 = null;
        }

        return view('berita_acara.approval_wajib_pajak', compact('nop', 'nama', 'alamat', 'nama_responden', 'telp', 'narasi', 'pegawai1', 'pegawai2'));
    }


    public function store(Request $request)
    {
        // ===============================
        // VALIDATION
        // ===============================
        $validated = $request->validate([
            'nop' => ['required', 'string', 'max:255', new SafeInput],
            'nama' => ['required', 'string', 'max:255', new SafeInput],
            'alamat' => ['required', 'string', 'max:255', new SafeInput],
            'nama_responden' => ['required', 'string', 'max:255', new SafeInput],
            'telp' => ['required', 'string', 'max:255', new SafeInput],
            'narasi' => ['required', 'string', new SafeInput],
            'ttd_wajib_pajak' => ['required', 'string'],
            'pegawai1' => ['required', 'integer'],
            'pegawai2' => ['nullable', 'integer'],
        ]);
        // ===============================
        // AMBIL DATA WAJIB PAJAK
        // ===============================
        $wajibPajak = WajibPajak::where('nop', $validated['nop'])->first();

        if (!$wajibPajak) {
            return back()->withErrors([
                'nop' => 'Wajib Pajak tidak ditemukan'
            ])->withInput();
        }

        // ===============================
        // PROSES TANDA TANGAN
        // ===============================
        $base64Image = $validated['ttd_wajib_pajak'];

        if (!str_starts_with($base64Image, 'data:image')) {
            return back()->withErrors([
                'ttd_wajib_pajak' => 'Format tanda tangan tidak valid'
            ])->withInput();
        }

        $base64Image = preg_replace('#^data:image/\w+;base64,#i', '', $base64Image);
        $imageData = base64_decode($base64Image);

        if ($imageData === false) {
            return back()->withErrors([
                'ttd_wajib_pajak' => 'Gagal memproses tanda tangan'
            ])->withInput();
        }

        // nama file
        $fileName = 'ttd_wajib_pajak/' . time() . '_' . Str::random(8) . '.png';

        Storage::disk('public')->put($fileName, $imageData);

        $ttdPath = 'storage/' . $fileName;

        // ===============================
        // SIMPAN KE DATABASE
        // ===============================
        DB::beginTransaction();

        try {
            BeritaAcara::create([
                'id_wajib_pajak'  => $wajibPajak->id,
                'telp'            => $validated['telp'],
                'nama'  => $validated['nama_responden'],
                'narasi'          => $validated['narasi'],
                'pegawai1'        => $validated['pegawai1'],
                'pegawai2'        => $validated['pegawai2'] ?? null,
                'ttd_wajib_pajak' => $ttdPath,
            ]);

            DB::commit();

            return redirect()
                ->route('berita_acara', ['jenis' => $wajibPajak->jenis])
                ->with('success', 'Berita Acara berhasil disimpan');
        } catch (\Exception $e) {
            DB::rollBack();

            return back()->withErrors([
                'error' => 'Gagal menyimpan Berita Acara: ' . $e->getMessage()
            ])->withInput();
        }
    }

    public function ba_pdf($id)
    {

        Carbon::setLocale('id');
        $data = BeritaAcara::with(['wajibPajak', 'pegawaiSatu', 'pegawaiDua'])
            ->findOrFail($id);
        // dd($data);

        // $path = public_path('spesimen/'.$data->pegawai1->nip_nik.'.png');
        // $base64 = 'data:image/png;base64,'.base64_encode(file_get_contents($path));


        // Render blade ke HTML
        $html = view('berita_acara.ba_pdf', compact('data'))->render();
        // dd($data);

        // Init mPDF
        $mpdf = new Mpdf([
            'mode' => 'utf-8',
            'format' => 'A4',
            'margin_top' => 15,
            'margin_bottom' => 15,
            'margin_left' => 15,
            'margin_right' => 15,
        ]);

        // Optional header / footer
        $mpdf->SetHeader('BERITA ACARA||{PAGENO}');
        $mpdf->SetFooter('{DATE j-m-Y}|BKPSDM Kota Surabaya|{PAGENO}');

        // Write HTML ke PDF
        $mpdf->WriteHTML($html);

        // Tampilkan PDF di browser
        return response(
            $mpdf->Output('berita-acara.pdf', 'S')
        )->header('Content-Type', 'application/pdf');
    }


    public function upload(Request $request)
    {
        $validated = $request->validate([
            'nop' => ['required', 'string', 'max:255', new SafeInput],
        ]);

        $wajibPajak = WajibPajak::where('nop', $validated['nop'])->first();

        if (!$wajibPajak) {
            return back()->withErrors([
                'nop' => 'Wajib Pajak tidak ditemukan'
            ])->withInput();
        }

        DB::beginTransaction();

        try {
            // ✅ Validation
            $request->validate([
                'file' => 'required|file|mimes:pdf,doc,docx|max:2048',
            ]);

            // ✅ Upload file
            $file = $request->file('file');
            $fileName = 'berita_acara_' . time() . '.' . $file->getClientOriginalExtension();

            $path = $file->storeAs(
                'berita_acara',
                $fileName,
                'public'
            );

            // ✅ Save / update database
            BeritaAcara::create([
                'id_wajib_pajak'  => $wajibPajak->id,
                'file_berita_acara' => $path,
            ]);

            DB::commit();

            // ✅ SUCCESS RETURN (as requested)
            return redirect()
                ->route('berita_acara', ['jenis' => $wajibPajak->jenis])
                ->with('success', 'Berita Acara berhasil disimpan');
        } catch (\Exception $e) {
            DB::rollBack();

            return back()->withErrors([
                'error' => 'Gagal menyimpan Berita Acara: ' . $e->getMessage()
            ])->withInput();
        }
    }

    public function petugas(Request $request)
    {
        // Jika tidak ada input bulan → gunakan bulan sekarang
        $bulan = $request->bulan ?? Carbon::now()->month;
        $tahun = $request->tahun ?? Carbon::now()->year;

        // Query pegawai1
        $pegawai1 = DB::table('berita_acara')
            ->select(
                'pegawai1 as id',
                DB::raw('MONTH(created_at) as bulan'),
                DB::raw('COUNT(*) as total')
            )
            ->whereNotNull('pegawai1')
            ->whereMonth('created_at', $bulan)
            ->whereYear('created_at', $tahun)
            ->groupBy('pegawai1', DB::raw('MONTH(created_at)'));

        // Query pegawai2
        $pegawai2 = DB::table('berita_acara')
            ->select(
                'pegawai2 as id',
                DB::raw('MONTH(created_at) as bulan'),
                DB::raw('COUNT(*) as total')
            )
            ->whereNotNull('pegawai2')
            ->whereMonth('created_at', $bulan)
            ->whereYear('created_at', $tahun)
            ->groupBy('pegawai2', DB::raw('MONTH(created_at)'));

        // Gabungkan dan jumlahkan
        $pegawai = DB::query()
            ->fromSub(
                $pegawai1->unionAll($pegawai2),
                'gabungan'
            )
            ->join('pegawai', 'pegawai.id', '=', 'gabungan.id')
            ->select(
                'pegawai.id',
                'pegawai.nama_pegawai',
                'gabungan.bulan',
                DB::raw('SUM(total) as jumlah_berita_acara')
            )
            ->groupBy('pegawai.id', 'pegawai.nama_pegawai', 'gabungan.bulan')
            ->orderBy('jumlah_berita_acara', 'desc')
            ->get();
        // dd($pegawai);
        return view('admin.petugas.index', compact('pegawai', 'bulan', 'tahun'));
    }

    public function detail_petugas($id, $bulan, $tahun)
    {
        $bulan = (int) $bulan;
        $tahun = (int) $tahun;
        $petugas = Pegawai::findOrFail($id);
        $data = BeritaAcara::with(['wajibPajak', 'pegawaiSatu', 'pegawaiDua'])
            ->where(function ($query) use ($id) {
                $query->where('pegawai1', $id)
                    ->orWhere('pegawai2', $id);
            })
            ->orderBy('created_at', 'desc')
            ->get();
        //    dd($data); 
        return view('admin.petugas.detail', compact('data', 'petugas', 'bulan', 'tahun'));
    }

    public function wp(Request $request, $jenis)
    {
        $bulan = $request->bulan ?? Carbon::now()->month;
        $tahun = $request->tahun ?? Carbon::now()->year;

        $jenis_ = $jenis;
        $data = BeritaAcara::with('wajibPajak')
            ->whereHas('wajibPajak', function ($query) use ($jenis) {
                $query->when(
                    $jenis === 'pbb',
                    fn ($q) => $q->where('jenis', 'pbb'),
                    fn ($q) => $q->where('jenis', '!=', 'pbb')
                );
            })
            ->whereMonth('created_at', $bulan)
            ->whereYear('created_at', $tahun)
            ->orderBy('created_at', 'desc')
            ->distinct()
            ->get();

        $jenis = $jenis_;
        // dd($data);

        return view('admin.wp.index', compact('data', 'jenis', 'bulan', 'tahun'));
    }
    // public function readCsv(Request $request)
    // {
    //     $request->validate([
    //         'file' => 'required|file|mimes:csv,txt|max:5120',
    //     ]);

    //     $file = $request->file('file');
    //     $results = [];

    //     if (($handle = fopen($file->getRealPath(), 'r')) !== false) {
    //         $isHeader = true;

    //         while (($data = fgetcsv($handle, 0, ';')) !== false) {
    //             if ($isHeader) {
    //                 $isHeader = false;
    //                 continue;
    //             }

    //             $results[] = [
    //                 'col_a' => $data[0] ?? null,
    //                 'col_b' => $data[1] ?? null,
    //             ];
    //         }
    //         fclose($handle);
    //     }
    //     foreach ($results as $value) {
    //         WajibPajak::where('nop', $value['col_b'])
    //             ->update([
    //                 'jenis' => $value['col_a']
    //             ]);
    //     }
    // }
}
