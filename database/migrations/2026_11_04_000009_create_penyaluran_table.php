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
        Schema::create('penyaluran', function (Blueprint $table) {
            $table->id();
            $table->foreignId('distribusi_id')->constrained('distribusi')->cascadeOnDelete();
            $table->date('tanggal_penyaluran');
            $table->integer('jumlah_disalurkan');
            $table->text('keterangan')->nullable();
            $table->string('foto_bukti')->nullable(); // Path penyimpanan berkas foto serah terima
            $table->foreignId('user_id')->constrained('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penyaluran');
    }
};

