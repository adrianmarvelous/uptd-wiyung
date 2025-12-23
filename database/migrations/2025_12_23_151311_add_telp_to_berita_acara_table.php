<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('berita_acara', function (Blueprint $table) {
            $table->string('telp', 20)->nullable()->after('id_wajib_pajak');
        });
    }

    public function down(): void
    {
        Schema::table('berita_acara', function (Blueprint $table) {
            $table->dropColumn('telp');
        });
    }
};
