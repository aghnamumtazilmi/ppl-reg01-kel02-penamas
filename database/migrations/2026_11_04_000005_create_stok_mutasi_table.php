<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('stok_mutasi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('stok_bantuan_id')->constrained('stok_bantuan')->cascadeOnDelete();
            $table->string('tipe'); // 'masuk', 'keluar'
            $table->integer('jumlah');
            $table->text('keterangan')->nullable();
            $table->foreignId('user_id')->constrained('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stok_mutasi');
    }
};

