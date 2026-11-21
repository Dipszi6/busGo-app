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
        Schema::create('rute', function (Blueprint $table) {
            $table->id();
            $table->foreignId('terminal_asal_id')->constrained('terminal');
            $table->foreignId('terminal_tujuan_id')->constrained('terminal');
            $table->unsignedSmallInteger('durasi_menit');
            $table->timestamps();

            $table->unique(['terminal_asal_id', 'terminal_tujuan_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rute');
    }
};
