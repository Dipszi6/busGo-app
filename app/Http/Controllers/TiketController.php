<?php

namespace App\Http\Controllers;

use App\Models\Jadwal;
use App\Models\Kota;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class TiketController extends Controller
{
    public function cari(Request $request): View
    {
        $data = $request->validate([
            'asal'      => ['required', 'string', 'max:100', Rule::exists('kota', 'nama')],
            'tujuan'    => ['required', 'string', 'max:100', Rule::exists('kota', 'nama'), 'different:asal'],
            'tanggal'   => ['required', 'date', 'after_or_equal:today'],
            'penumpang' => ['required', 'integer', 'min:1', 'max:5'],
            'waktu'     => ['nullable', 'array'],
            'waktu.*'   => ['in:pagi,siang,sore,malam'],
            'kelas'     => ['nullable', 'array'],
            'kelas.*'   => ['in:Executive,Sleeper'],
            'urut'      => ['nullable', 'in:termurah,termahal'],
        ], [
            'asal.required'          => 'Kota asal wajib dipilih.',
            'asal.exists'            => 'Kota asal tidak tersedia.',
            'tujuan.required'        => 'Kota tujuan wajib dipilih.',
            'tujuan.exists'          => 'Kota tujuan tidak tersedia.',
            'tujuan.different'       => 'Kota tujuan harus berbeda dengan kota asal.',
            'tanggal.required'       => 'Tanggal berangkat wajib diisi.',
            'tanggal.date'           => 'Format tanggal tidak valid.',
            'tanggal.after_or_equal' => 'Tanggal berangkat tidak boleh sebelum hari ini.',
        ]);

        $jumlah = (int) $data['penumpang'];

        $hasil = Jadwal::with(['bus', 'rute.terminalAsal.kota', 'rute.terminalTujuan.kota'])
            ->where('aktif', true)
            ->whereHas('rute.terminalAsal.kota', fn($q) => $q->where('nama', $data['asal']))
            ->whereHas('rute.terminalTujuan.kota', fn($q) => $q->where('nama', $data['tujuan']))
            ->get()
            ->map(fn(Jadwal $jadwal) => $jadwal->tampilan($data['tanggal']))
            ->filter(fn($bus) => ($bus['kapasitas'] - count($bus['kursi_terisi'])) >= $jumlah)
            ->values();

        $slotWaktu = fn(string $jam) => match (true) {
            $jam >= '06:00' && $jam < '11:00' => 'pagi',
            $jam >= '11:00' && $jam < '15:00' => 'siang',
            $jam >= '15:00' && $jam < '18:00' => 'sore',
            default                           => 'malam',
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
            default    => $hasil->sortBy('berangkat'),
        };

        return view('tiket.hasil', [
            'pencarian'     => $request->only(['asal', 'tujuan', 'tanggal', 'penumpang']),
            'filter'        => $request->only(['waktu', 'kelas', 'urut']),
            'hasil'         => $hasil->values(),
            'kota'          => Kota::orderBy('nama')->pluck('nama'),
            'tanggalTampil' => Carbon::parse($data['tanggal'])->locale('id')->translatedFormat('d F Y'),
        ]);
    }

    public function detail(Request $request, int $id): View
    {
        $pencarian = $request->validate($this->aturanPencarian());

        $bus = Jadwal::untukTampilan($id, $pencarian['tanggal']);
        $pencarian['asal']   = $bus['kota_asal'];
        $pencarian['tujuan'] = $bus['kota_tujuan'];

        return view('tiket.detail', [
            'bus'           => $bus,
            'pencarian'     => $pencarian,
            'tanggalTampil' => Carbon::parse($pencarian['tanggal'])->locale('id')->translatedFormat('d F Y'),
        ]);
    }

    public function kursi(Request $request, int $id): View
    {
        $pencarian = $request->validate($this->aturanPencarian());

        $bus = Jadwal::untukTampilan($id, $pencarian['tanggal']);
        $pencarian['asal']   = $bus['kota_asal'];
        $pencarian['tujuan'] = $bus['kota_tujuan'];

        return view('tiket.kursi', [
            'bus'           => $bus,
            'pencarian'     => $pencarian,
            'tanggalTampil' => Carbon::parse($pencarian['tanggal'])->locale('id')->translatedFormat('d F Y'),
        ]);
    }

    private function aturanPencarian(): array
    {
        return [
            'asal'      => ['required', 'string', 'max:100'],
            'tujuan'    => ['required', 'string', 'max:100'],
            'tanggal'   => ['required', 'date', 'after_or_equal:today'],
            'penumpang' => ['required', 'integer', 'min:1', 'max:5'],
        ];
    }
}
