<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('berita_acara', function (Blueprint $table) {
            $table->string('file_berita_acara')->nullable()->after('ttd_wajib_pajak');
        });
    }

    public function down()
    {
        Schema::table('berita_acara', function (Blueprint $table) {
            $table->dropColumn('file_berita_acara');
        });
    }
};
