<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('berita_acara', function (Blueprint $table) {
            $table->longText('narasi')->nullable()->change();
            $table->longText('pegawai1')->nullable()->change();
            
        });
    }

    public function down()
    {
        Schema::table('berita_acara', function (Blueprint $table) {
            $table->longText('narasi')->nullable(false)->change();
            $table->longText('pegawai1')->nullable(false)->change();
        });
    }
};
