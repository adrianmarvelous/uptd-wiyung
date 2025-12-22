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


class BeritaAcaraController extends Controller
{
    public function index()
    {
        return view('admin.berita_acara.index');
    }

    public function search(Request $request)
    {
        $q = $request->q;

        if (!$q || strlen($q) < 2) {
            return response()->json([]);
        }

        $data = WajibPajak::where('nop', 'like', "%{$q}%")
            ->orWhere('nama', 'like', "%{$q}%")
            ->orWhere('alamat', 'like', "%{$q}%")
            ->limit(10)
            ->get(['id', 'nop', 'nama', 'alamat']);

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

        $pegawai = Pegawai::all();

        return view('admin.berita_acara.create', compact('nop', 'nama', 'alamat', 'pegawai'));
    }

    public function approval_wajib_pajak(Request $request)
    {
        $validated = $request->validate([
            'nop' => ['required', 'string', 'max:255', new SafeInput],
            'nama' => ['required', 'string', 'max:255', new SafeInput],
            'alamat' => ['required', 'string', 'max:255', new SafeInput],
            'narasi' => ['required', 'string', new SafeInput],
            'pegawai1' => ['required', 'integer'],
            'pegawai2' => ['nullable', 'integer'],
        ]);

        $nop = $validated['nop'];
        $nama = $validated['nama'];
        $alamat = $validated['alamat'];
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

        return view('admin.berita_acara.approval_wajib_pajak', compact('nop', 'nama', 'alamat', 'narasi', 'pegawai1', 'pegawai2'));
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
                'narasi'          => $validated['narasi'],
                'pegawai1'        => $validated['pegawai1'],
                'pegawai2'        => $validated['pegawai2'] ?? null,
                'ttd_wajib_pajak' => $ttdPath,
            ]);

            DB::commit();

            return redirect()
                ->route('berita_acara')
                ->with('success', 'Berita Acara berhasil disimpan');
        } catch (\Exception $e) {
            DB::rollBack();

            return back()->withErrors([
                'error' => 'Gagal menyimpan Berita Acara: ' . $e->getMessage()
            ])->withInput();
        }
    }
}
