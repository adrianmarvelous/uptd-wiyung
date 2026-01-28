<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('wajib_pajak', function (Blueprint $table) {
            $table->string('jenis')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('wajib_pajak', function (Blueprint $table) {
            
            // 1. Fix invalid values first
            DB::table('wajib_pajak')
                ->whereNotIn('jenis', ['OP', 'BP'])
                ->orWhereNull('jenis')
                ->update([
                    'jenis' => 'OP' // or 'BP', choose default
                ]);

            // 2. Then safely convert back to ENUM
            Schema::table('wajib_pajak', function (Blueprint $table) {
                $table->enum('jenis', ['OP', 'BP'])->change();
            });
        });
    }
};
