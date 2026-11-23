<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pemesanan;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class OperasionalController extends Controller
{
    public function pemesanan(Request $request): View
    {
        $status = $request->query('status', 'semua');
        $cari   = trim((string) $request->query('q', ''));

        $query = Pemesanan::with([
            'user',
            'penumpang',
            'jadwal.bus',
            'jadwal.rute.terminalAsal.kota',
            'jadwal.rute.terminalTujuan.kota',
        ])->latest();

        if (in_array($status, ['lunas', 'menunggu_pembayaran', 'gagal'])) {
            $query->where('status', $status);
        }

        if ($cari !== '') {
            $query->where(function ($q) use ($cari) {
                $q->where('kode', 'like', "%{$cari}%")
                    ->orWhereHas('user', fn($u) => $u->where('name', 'like', "%{$cari}%"));
            });
        }

        $pemesanan = $query->paginate(10)->withQueryString();

        return view('admin.pemesanan.index', compact('pemesanan'));
    }

    public function showPemesanan(Pemesanan $pemesanan): View
    {
        $pemesanan->load([
            'user',
            'penumpang',
            'jadwal.bus',
            'jadwal.rute.terminalAsal.kota',
            'jadwal.rute.terminalTujuan.kota',
        ]);

        return view('admin.pemesanan.show', compact('pemesanan'));
    }

    public function updateStatusPemesanan(Request $request, Pemesanan $pemesanan): RedirectResponse
    {
        $data = $request->validate([
            'status' => ['required', 'in:menunggu_pembayaran,lunas,gagal'],
        ]);

        $pemesanan->update([
            'status'       => $data['status'],
            'dibayar_pada' => $data['status'] === 'lunas' ? ($pemesanan->dibayar_pada ?? now()) : null,
        ]);

        return back()->with('success', "Status pemesanan {$pemesanan->kode} diperbarui menjadi {$data['status']}.");
    }

    public function pembayaran(Request $request): View
    {
        $status = $request->query('status', 'semua');
        $cari   = trim((string) $request->query('q', ''));

        $query = Pemesanan::with(['user', 'jadwal.bus'])->latest();

        if (in_array($status, ['lunas', 'menunggu_pembayaran', 'gagal'])) {
            $query->where('status', $status);
        }

        if ($cari !== '') {
            $query->where('kode', 'like', "%{$cari}%");
        }

        $transaksi = $query->paginate(10)->withQueryString();

        $ringkasan = [
            'lunas'    => Pemesanan::where('status', 'lunas')->sum('total_harga'),
            'pending'  => Pemesanan::where('status', 'menunggu_pembayaran')->sum('total_harga'),
            'gagal'    => Pemesanan::where('status', 'gagal')->count(),
        ];

        return view('admin.pembayaran.index', compact('transaksi', 'ringkasan'));
    }

    public function pelanggan(Request $request): View
    {
        $cari = trim((string) $request->query('q', ''));

        $query = User::where('role', 'penumpang')
            ->withCount('pemesanan')
            ->withSum(['pemesanan as total_belanja' => fn($q) => $q->where('status', 'lunas')], 'total_harga')
            ->latest();

        if ($cari !== '') {
            $query->where(function ($q) use ($cari) {
                $q->where('name', 'like', "%{$cari}%")
                    ->orWhere('email', 'like', "%{$cari}%");
            });
        }

        $pelanggan = $query->paginate(10)->withQueryString();

        return view('admin.pelanggan.index', compact('pelanggan'));
    }

    public function laporan(Request $request): View
    {
        $dari   = $request->query('dari', now()->startOfMonth()->toDateString());
        $sampai = $request->query('sampai', now()->toDateString());

        $transaksiLunas = Pemesanan::with([
            'user',
            'penumpang',
            'jadwal.bus',
            'jadwal.rute.terminalAsal.kota',
            'jadwal.rute.terminalTujuan.kota',
        ])
            ->where('status', 'lunas')
            ->whereBetween('tanggal_berangkat', [$dari, $sampai])
            ->orderBy('tanggal_berangkat')
            ->get();

        $totalPendapatan = $transaksiLunas->sum('total_harga');
        $totalKursi      = $transaksiLunas->sum(fn($item) => $item->penumpang->count());

        $rekapArmada = $transaksiLunas
            ->groupBy(fn($item) => $item->jadwal->bus->nama)
            ->map(fn($group, $namaBus) => [
                'nama'       => $namaBus,
                'kelas'      => $group->first()->jadwal->bus->kelas,
                'transaksi'  => $group->count(),
                'kursi'      => $group->sum(fn($item) => $item->penumpang->count()),
                'pendapatan' => $group->sum('total_harga'),
            ])
            ->values();

        return view('admin.laporan.index', compact(
            'dari',
            'sampai',
            'transaksiLunas',
            'totalPendapatan',
            'totalKursi',
            'rekapArmada'
        ));
    }
}
