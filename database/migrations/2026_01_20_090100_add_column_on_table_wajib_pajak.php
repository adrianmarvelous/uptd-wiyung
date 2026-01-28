<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    public function up(): void
    {
        Schema::table('wajib_pajak', function (Blueprint $table) {
            $table->string('kecamatan')->nullable()->after('id');
            $table->string('kelurahan')->nullable()->after('kecamatan');
            $table->string('rt_op')->nullable()->after('alamat');
            $table->string('rw_op')->nullable()->after('rt_op');
            $table->string('alamat_wp')->nullable()->after('rw_op');
            $table->integer('luas_bumi')->nullable()->after('alamat_wp');
            $table->integer('luas_bangunan')->nullable()->after('luas_bumi');
            $table->integer('total_pbb')->nullable()->after('luas_bangunan');
        });
    }

    public function down(): void
    {
        Schema::table('wajib_pajak', function (Blueprint $table) {
            $table->dropColumn([
                'kecamatan',
                'kelurahan',
                'rt_op',
                'rw_op',
                'alamat_wp',
                'luas_bumi',
                'luas_bangunan',
                'total_pbb',
            ]);
        });
    }
};
