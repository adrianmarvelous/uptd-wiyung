<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('berita_acara', function (Blueprint $table) {
            $table->id();

            // relasi wajib pajak
            $table->unsignedBigInteger('id_wajib_pajak');

            // isi berita acara
            $table->longText('narasi');

            // petugas
            $table->unsignedBigInteger('pegawai1');
            $table->unsignedBigInteger('pegawai2')->nullable();

            // tanda tangan wajib pajak (path/file/base64)
            $table->text('ttd_wajib_pajak')->nullable();

            // waktu pembuatan
            $table->timestamps();

            // OPTIONAL foreign key (recommended)
            $table->foreign('id_wajib_pajak')
                ->references('id')->on('wajib_pajak')
                ->onDelete('cascade');

            $table->foreign('pegawai1')
                ->references('id')->on('pegawai');

            $table->foreign('pegawai2')
                ->references('id')->on('pegawai');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('berita_acara');
    }
};
