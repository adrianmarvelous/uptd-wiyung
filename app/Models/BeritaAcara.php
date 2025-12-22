<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BeritaAcara extends Model
{
    protected $table = 'berita_acara'; // optional (jelas & aman)
    
    protected $fillable = [
        'id_wajib_pajak',
        'narasi',
        'pegawai1',
        'pegawai2',
        'ttd_wajib_pajak',
    ];
}
