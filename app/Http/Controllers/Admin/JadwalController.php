<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Bus;
use App\Models\Jadwal;
use App\Models\Kota;
use App\Models\Rute;
use App\Models\Terminal;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class JadwalController extends Controller
{
    public function index(): View
    {
        $jadwal = Jadwal::with(['bus', 'rute.terminalAsal.kota', 'rute.terminalTujuan.kota'])
            ->latest()
            ->get();

        $rute     = Rute::with(['terminalAsal.kota', 'terminalTujuan.kota'])->get();
        $bus      = Bus::orderBy('nama')->get();
        $terminal = Terminal::with('kota')->orderBy('nama')->get();

        return view('admin.jadwal.index', compact('jadwal', 'rute', 'bus', 'terminal'));
    }

    public function storeTerminal(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'nama_kota'     => ['required', 'string', 'max:100'],
            'nama_terminal' => ['required', 'string', 'max:150'],
        ]);

        $kota = Kota::firstOrCreate(['nama' => trim($data['nama_kota'])]);
        Terminal::firstOrCreate([
            'kota_id' => $kota->id,
            'nama'    => trim($data['nama_terminal']),
        ]);

        return back()->with('success', 'Kota & Terminal berhasil ditambahkan.');
    }

    public function storeRute(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'terminal_asal_id'   => ['required', 'exists:terminal,id', 'different:terminal_tujuan_id'],
            'terminal_tujuan_id' => ['required', 'exists:terminal,id'],
            'durasi_menit'       => ['required', 'integer', 'min:30', 'max:2880'],
        ], [
            'terminal_asal_id.different' => 'Terminal asal dan tujuan tidak boleh sama.',
        ]);

        Rute::firstOrCreate(
            [
                'terminal_asal_id'   => $data['terminal_asal_id'],
                'terminal_tujuan_id' => $data['terminal_tujuan_id'],
            ],
            ['durasi_menit' => $data['durasi_menit']]
        );

        return back()->with('success', 'Rute perjalanan berhasil disimpan.');
    }

    public function storeJadwal(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'rute_id'       => ['required', 'exists:rute,id'],
            'bus_id'        => ['required', 'exists:bus,id'],
            'jam_berangkat' => ['required', 'date_format:H:i'],
            'harga'         => ['required', 'integer', 'min:10000'],
        ]);

        Jadwal::create([
            'rute_id'       => $data['rute_id'],
            'bus_id'        => $data['bus_id'],
            'jam_berangkat' => $data['jam_berangkat'] . ':00',
            'harga'         => $data['harga'],
            'aktif'         => true,
        ]);

        return back()->with('success', 'Jadwal keberangkatan berhasil ditambahkan.');
    }

    public function toggleAktif(Jadwal $jadwal): RedirectResponse
    {
        $jadwal->update(['aktif' => ! $jadwal->aktif]);
        return back()->with('success', 'Status jadwal berhasil diubah.');
    }

    public function destroyJadwal(Jadwal $jadwal): RedirectResponse
    {
        if ($jadwal->pemesanan()->exists()) {
            return back()->withErrors(['jadwal' => 'Jadwal sudah memiliki riwayat pemesanan. Gunakan tombol nonaktifkan saja.']);
        }

        $jadwal->delete();
        return back()->with('success', 'Jadwal berhasil dihapus.');
    }
}
