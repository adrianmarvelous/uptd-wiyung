<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('wajib_pajak', function (Blueprint $table) {
            $table->id();
            $table->string('nop', 30)->unique();
            $table->enum('jenis', ['OP', 'BP']); // OP = Orang Pribadi, BP = Badan
            $table->string('nama', 150);
            $table->text('alamat');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('wajib_pajak');
    }
};
