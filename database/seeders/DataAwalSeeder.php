<?php

namespace Database\Seeders;

use App\Models\Bus;
use App\Models\Jadwal;
use App\Models\Kota;
use App\Models\Rute;
use App\Models\Terminal;
use Illuminate\Database\Seeder;

class DataAwalSeeder extends Seeder
{
    public function run(): void
    {
        $jakarta = Kota::firstOrCreate(['nama' => 'Jakarta']);
        $yogya   = Kota::firstOrCreate(['nama' => 'Yogyakarta']);

        $pulogebang = Terminal::firstOrCreate(['kota_id' => $jakarta->id, 'nama' => 'Terminal Pulo Gebang']);
        $giwangan   = Terminal::firstOrCreate(['kota_id' => $yogya->id, 'nama' => 'Terminal Giwangan']);

        $executive = Bus::updateOrCreate(['nama' => 'Nusantara Executive'], [
            'kelas'     => 'Executive',
            'denah'     => '2-2',
            'kapasitas' => 28,
            'fasilitas' => ['AC', 'WiFi Gratis', 'Reclining Seat', 'USB Charger', 'Bagasi'],
            'deskripsi' => 'Armada nyaman untuk perjalanan jarak jauh.',
        ]);

        $sleeper = Bus::updateOrCreate(['nama' => 'Nusantara Sleeper'], [
            'kelas'     => 'Sleeper',
            'denah'     => '1-1',
            'kapasitas' => 18,
            'fasilitas' => ['AC', 'WiFi Gratis', 'Bed Seat'],
            'deskripsi' => 'Istirahat lebih nyaman di perjalanan.',
        ]);

        $rute = Rute::firstOrCreate(
            ['terminal_asal_id' => $pulogebang->id, 'terminal_tujuan_id' => $giwangan->id],
            ['durasi_menit' => 480],
        );

        Jadwal::firstOrCreate(
            ['rute_id' => $rute->id, 'bus_id' => $executive->id, 'jam_berangkat' => '08:00:00'],
            ['harga' => 250000],
        );

        Jadwal::firstOrCreate(
            ['rute_id' => $rute->id, 'bus_id' => $sleeper->id, 'jam_berangkat' => '20:00:00'],
            ['harga' => 320000],
        );
    }
}
