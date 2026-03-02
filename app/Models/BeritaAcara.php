<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BeritaAcara extends Model
{
    protected $table = 'berita_acara'; // optional (jelas & aman)
    
    protected $fillable = [
        'nama',
        'id_wajib_pajak',
        'telp',
        'narasi',
        'pegawai1',
        'pegawai2',
        'file_berita_acara',
        'ttd_wajib_pajak',
    ];

    public function wajibPajak()
    {
        return $this->hasOne(WajibPajak::class,'id','id_wajib_pajak');
    }
    public function pegawaiSatu()
    {
        return $this->belongsTo(Pegawai::class, 'pegawai1');
    }

    public function pegawaiDua()
    {
        return $this->belongsTo(Pegawai::class, 'pegawai2');
    }
}
