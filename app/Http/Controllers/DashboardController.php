<?php

namespace App\Http\Controllers;

use App\Models\Pemesanan;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(Request $request): View|RedirectResponse
    {
        $user = $request->user();

        if ($user->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }

        Pemesanan::where('user_id', $user->id)
            ->where('status', 'menunggu_pembayaran')
            ->whereDate('tanggal_berangkat', '<', today())
            ->update(['status' => 'gagal']);

        $baseQuery = Pemesanan::where('user_id', $user->id);

        $statistik = [
            'aktif'    => (clone $baseQuery)->where('status', 'lunas')
                ->whereDate('tanggal_berangkat', '>=', today())
                ->count(),
            'menunggu' => (clone $baseQuery)->where('status', 'menunggu_pembayaran')->count(),
            'total'    => (clone $baseQuery)->count(),
        ];

        $perjalananBerikutnya = Pemesanan::with([
            'penumpang',
            'jadwal.bus',
            'jadwal.rute.terminalAsal.kota',
            'jadwal.rute.terminalTujuan.kota',
        ])
            ->where('user_id', $user->id)
            ->where('status', 'lunas')
            ->whereDate('tanggal_berangkat', '>=', today())
            ->orderBy('tanggal_berangkat')
            ->first();

        $transaksiTerbaru = Pemesanan::with([
            'penumpang',
            'jadwal.bus',
            'jadwal.rute.terminalAsal.kota',
            'jadwal.rute.terminalTujuan.kota',
        ])
            ->where('user_id', $user->id)
            ->latest()
            ->take(3)
            ->get();

        return view('dashboard', compact('statistik', 'perjalananBerikutnya', 'transaksiTerbaru'));
    }

    public function riwayat(Request $request): View
    {
        Pemesanan::where('user_id', $request->user()->id)
            ->where('status', 'menunggu_pembayaran')
            ->whereDate('tanggal_berangkat', '<', today())
            ->update(['status' => 'gagal']);

        $status = $request->query('status', 'semua');
        $cari   = trim((string) $request->query('q', ''));

        $query = Pemesanan::with([
            'penumpang',
            'jadwal.bus',
            'jadwal.rute.terminalAsal.kota',
            'jadwal.rute.terminalTujuan.kota',
        ])
            ->where('user_id', $request->user()->id)
            ->latest();

        if (in_array($status, ['lunas', 'menunggu_pembayaran', 'gagal'])) {
            $query->where('status', $status);
        }

        if ($cari !== '') {
            $query->where('kode', 'like', '%' . $cari . '%');
        }

        $pemesanan = $query->paginate(6)->withQueryString();

        return view('riwayat.index', compact('pemesanan', 'status', 'cari'));
    }
}
