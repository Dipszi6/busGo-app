<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TiketController extends Controller
{
    public function detail(Request $request, int $id): View
    {
        $pencarian = $request->validate([
            'asal'      => ['required', 'string', 'max:100'],
            'tujuan'    => ['required', 'string', 'max:100'],
            'tanggal'   => ['required', 'date'],
            'penumpang' => ['required', 'integer', 'min:1', 'max:5'],
        ]);

        $bus = $this->dataBus()->firstWhere('id', $id);
        abort_if(! $bus, 404);

        return view('tiket.detail', [
            'bus'           => $bus,
            'pencarian'     => $pencarian,
            'tanggalTampil' => Carbon::parse($pencarian['tanggal'])->locale('id')->translatedFormat('d F Y'),
        ]);
    }

    public function kursi(Request $request, int $id): View
    {
        $pencarian = $request->validate([
            'asal'      => ['required', 'string', 'max:100'],
            'tujuan'    => ['required', 'string', 'max:100'],
            'tanggal'   => ['required', 'date'],
            'penumpang' => ['required', 'integer', 'min:1', 'max:5'],
        ]);

        $bus = $this->dataBus()->firstWhere('id', $id);
        abort_if(! $bus, 404);

        return view('tiket.kursi', [
            'bus'           => $bus,
            'pencarian'     => $pencarian,
            'tanggalTampil' => Carbon::parse($pencarian['tanggal'])->locale('id')->translatedFormat('d F Y'),
        ]);
    }

    private function dataBus(): Collection
    {
        return collect([
            [
                'id' => 1,
                'nama' => 'Nusantara Executive',
                'kelas' => 'Executive',
                'fasilitas' => ['AC', 'WiFi Gratis', 'Reclining Seat', 'USB Charger', 'Bagasi'],
                'deskripsi' => 'Armada nyaman untuk perjalanan jarak jauh.',
                'berangkat' => '08:00',
                'tiba' => '16:00',
                'durasi' => '8 Jam',
                'terminal_asal' => 'Terminal Pulo Gebang',
                'terminal_tujuan' => 'Terminal Giwangan',
                'harga' => 250000,
                'denah' => '2-2',
                'kapasitas' => 28,
                'kursi_terisi' => ['02', '07', '12'],
            ],
            [
                'id' => 2,
                'nama' => 'Nusantara Sleeper',
                'kelas' => 'Sleeper',
                'fasilitas' => ['AC', 'WiFi Gratis', 'Bed Seat'],
                'deskripsi' => 'Istirahat lebih nyaman di perjalanan.',
                'berangkat' => '20:00',
                'tiba' => '04:00',
                'durasi' => '8 Jam',
                'terminal_asal' => 'Terminal Pulo Gebang',
                'terminal_tujuan' => 'Terminal Giwangan',
                'harga' => 320000,
                'denah' => '1-1',
                'kapasitas' => 18,
                'kursi_terisi' => ['03'],
            ],
        ]);
    }
    public function cari(Request $request): View
    {
        $data = $request->validate([
            'asal'      => ['required', 'string', 'max:100'],
            'tujuan'    => ['required', 'string', 'max:100'],
            'tanggal'   => ['required', 'date'],
            'penumpang' => ['required', 'integer', 'min:1', 'max:5'],
            'waktu'     => ['nullable', 'array'],
            'waktu.*'   => ['in:pagi,siang,sore,malam'],
            'kelas'     => ['nullable', 'array'],
            'kelas.*'   => ['in:Executive,Sleeper'],
            'urut'      => ['nullable', 'in:termurah,termahal'],
        ]);

        $hasil = $this->dataBus();

        $slotWaktu = fn(string $jam) => match (true) {
            $jam >= '06:00' && $jam < '11:00' => 'pagi',
            $jam >= '11:00' && $jam < '15:00' => 'siang',
            $jam >= '15:00' && $jam < '18:00' => 'sore',
            $jam >= '18:00' || $jam < '06:00'  => 'malam',
        };

        if (! empty($data['waktu'])) {
            $hasil = $hasil->filter(fn($bus) => in_array($slotWaktu($bus['berangkat']), $data['waktu']));
        }

        if (! empty($data['kelas'])) {
            $hasil = $hasil->whereIn('kelas', $data['kelas']);
        }

        $hasil = match ($data['urut'] ?? null) {
            'termurah' => $hasil->sortBy('harga'),
            'termahal' => $hasil->sortByDesc('harga'),
            default    => $hasil,
        };

        return view('tiket.hasil', [
            'pencarian'     => $request->only(['asal', 'tujuan', 'tanggal', 'penumpang']),
            'filter'        => $request->only(['waktu', 'kelas', 'urut']),
            'hasil'         => $hasil->values(),
            'tanggalTampil' => Carbon::parse($data['tanggal'])->locale('id')->translatedFormat('d F Y'),
        ]);
    }
}
