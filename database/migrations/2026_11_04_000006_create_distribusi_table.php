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
        Schema::create('distribusi', function (Blueprint $table) {
            $table->id();
            $table->string('kode')->unique();
            $table->string('periode');
            $table->string('wilayah');
            $table->foreignId('paket_bantuan_id')->constrained('paket_bantuan');
            $table->integer('jumlah_penerima')->default(0);
            $table->string('status')->default('draft'); // draft, diajukan, disetujui, ditolak, disalurkan
            $table->text('catatan')->nullable();
            $table->text('catatan_persetujuan')->nullable();
            $table->foreignId('dibuat_oleh')->constrained('users');
            $table->foreignId('disetujui_oleh')->nullable()->constrained('users');
            $table->timestamp('tanggal_pengajuan')->nullable();
            $table->timestamp('tanggal_persetujuan')->nullable();
            $table->timestamps();

            $table->index('status');
            $table->index('wilayah');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('distribusi');
    }
};

