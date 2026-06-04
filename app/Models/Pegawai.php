<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pegawai extends Model
{
    protected $table = 'pegawai'; // optional (jelas & aman)
    
    public function beritaAcaraSebagaiPegawai1()
    {
        return $this->hasMany(BeritaAcara::class, 'pegawai1');
    }

    public function beritaAcaraSebagaiPegawai2()
    {
        return $this->hasMany(BeritaAcara::class, 'pegawai2');
    }
}
