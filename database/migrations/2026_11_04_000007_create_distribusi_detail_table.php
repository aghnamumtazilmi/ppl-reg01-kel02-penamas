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
        Schema::create('distribusi_detail', function (Blueprint $table) {
            $table->id();
            $table->foreignId('distribusi_id')->constrained('distribusi')->cascadeOnDelete();
            $table->foreignId('penerima_id')->constrained('penerima')->cascadeOnDelete();
            $table->timestamps();

            $table->unique(['distribusi_id', 'penerima_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('distribusi_detail');
    }
};

