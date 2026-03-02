<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BeritaAcaraController;


Route::middleware(['auth', 'verified'])->prefix('/')->group(function () {

    // Dashboard main page
    Route::get('/', function () {
        return view('index');
    })->name('dashboard');

    Route::get('/berita_acara/search', [BeritaAcaraController::class, 'search'])->name('berita_acara.search');
    Route::get('/berita_acara/{jenis}', [BeritaAcaraController::class, 'index'])->name('berita_acara');
    Route::post('/berita_acara/create', [BeritaAcaraController::class, 'create'])->name('berita_acara.create');
    Route::post('/berita_acara/upload', [BeritaAcaraController::class, 'upload'])->name('berita_acara.upload');
    Route::get('/berita_acara/upload-csv', function () {
        return view('berita_acara.upload_csv');
    })->name('berita_acara.upload_csv');
    Route::post('/berita_acara/approval_wajib_pajak', [BeritaAcaraController::class, 'approval_wajib_pajak'])->name('berita_acara.approval_wajib_pajak');
    Route::post('/berita_acara/store', [BeritaAcaraController::class, 'store'])->name('berita_acara.store');
    Route::get('/berita_acara/ba_pdf/{id}', [BeritaAcaraController::class, 'ba_pdf'])->name('berita_acara.ba_pdf');
    // Route::post('/readCsv', [BeritaAcaraController::class, 'readCsv'])->name('read.csv');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::middleware(['auth', 'role:admin'])->group(function () {
        Route::get('/berita_acara_petugas',[BeritaAcaraController::class, 'petugas'])->name('berita_acara.petugas');
        Route::get('/berita_acara_petugas/detail/{id}/{bulan}/{tahun}',[BeritaAcaraController::class, 'detail_petugas'])->name('berita_acara.petugas.detail');
        Route::get('/berita_acara_wp/{jenis}',[BeritaAcaraController::class, 'wp'])->name('berita_acara.wp');
        Route::get('/berita_acara_wp/detail/{id}/{bulan}/{tahun}',[BeritaAcaraController::class, 'detail_pwp'])->name('berita_acara.wp.detail');
    });
});

require __DIR__ . '/auth.php';
