<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pegawai extends Model
{
    protected $table = 'pegawai'; // optional (jelas & aman)
    
    public function pegawai1()
    {
        return $this->belongsTo(BeritaAcara::class,'id','pegawai1');
    }
    public function pegawai2()
    {
        return $this->belongsTo(BeritaAcara::class,'id','pegawai2');
    }
}
