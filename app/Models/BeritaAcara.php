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
        'ttd_wajib_pajak',
    ];

    public function wajibPajak()
    {
        return $this->hasOne(WajibPajak::class,'id','id_wajib_pajak');
    }
    public function pegawai_1()
    {
        return $this->hasOne(Pegawai::class,'id','pegawai1');
    }
    public function pegawai_2()
    {
        return $this->hasOne(Pegawai::class,'id','pegawai2');
    }
}
