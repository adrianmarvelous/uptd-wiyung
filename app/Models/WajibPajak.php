<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WajibPajak extends Model
{
    protected $table = 'wajib_pajak'; // optional (jelas & aman)

    protected $fillable = [
        'nop',
        'nama',
        'alamat',
        'jenis',
    ];

    public function beritaAcara()
    {
        return $this->belongsTo(BeritaAcara::class,'id','id_wajib_pajak');
    }
}
