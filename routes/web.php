<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BeritaAcaraController;

Route::get('/', function () {
    return view('welcome');
});

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth', 'verified'])->prefix('dashboard')->group(function () {

    // Dashboard main page
    Route::get('/', function () {
        return view('admin.index');
    })->name('dashboard');

    Route::get('/berita_acara', [BeritaAcaraController::class, 'index'])->name('berita_acara');
    Route::get('/berita_acara/search', [BeritaAcaraController::class, 'search'])->name('berita_acara.search');
    Route::post('/berita_acara/create', [BeritaAcaraController::class, 'create'])->name('berita_acara.create');
    Route::post('/berita_acara/approval_wajib_pajak', [BeritaAcaraController::class, 'approval_wajib_pajak'])->name('berita_acara.approval_wajib_pajak');
    Route::post('/berita_acara/store', [BeritaAcaraController::class, 'store'])->name('berita_acara.store');
    Route::get('/berita_acara/ba_pdf/{id}', [BeritaAcaraController::class, 'ba_pdf'])->name('berita_acara.ba_pdf');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
