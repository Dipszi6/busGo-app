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
        Schema::create('penumpang', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pemesanan_id')->constrained('pemesanan')->cascadeOnDelete();
            $table->foreignId('jadwal_id')->constrained('jadwal');
            $table->date('tanggal_berangkat');
            $table->string('nomor_kursi', 3);
            $table->string('nama', 100);
            $table->string('nik', 255);
            $table->string('telepon', 20);
            $table->string('email', 100);
            $table->char('jenis_kelamin', 1);
            $table->timestamps();

            $table->unique(['jadwal_id', 'tanggal_berangkat', 'nomor_kursi']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penumpang');
    }
};
