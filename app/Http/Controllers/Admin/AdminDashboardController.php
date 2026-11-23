<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Bus;
use App\Models\Jadwal;
use App\Models\Pemesanan;
use App\Models\User;
use Illuminate\View\View;

class AdminDashboardController extends Controller
{
    public function index(): View
    {
        $totalPendapatan = Pemesanan::where('status', 'lunas')->sum('total_harga');
        $tiketTerjual    = Pemesanan::where('status', 'lunas')->withCount('penumpang')->get()->sum('penumpang_count');
        $menungguBayar   = Pemesanan::where('status', 'menunggu_pembayaran')->count();
        $totalArmada     = Bus::count();
        $jadwalAktif     = Jadwal::where('aktif', true)->count();
        $totalPelanggan  = User::where('role', 'penumpang')->count();

        $transaksiTerbaru = Pemesanan::with([
            'user',
            'penumpang',
            'jadwal.bus',
            'jadwal.rute.terminalAsal.kota',
            'jadwal.rute.terminalTujuan.kota',
        ])
            ->latest()
            ->take(6)
            ->get();

        $keberangkatanHariIni = Pemesanan::with([
            'user',
            'penumpang',
            'jadwal.bus',
            'jadwal.rute.terminalAsal.kota',
            'jadwal.rute.terminalTujuan.kota',
        ])
            ->where('status', 'lunas')
            ->whereDate('tanggal_berangkat', today())
            ->get();

        return view('admin.dashboard', compact(
            'totalPendapatan',
            'tiketTerjual',
            'menungguBayar',
            'totalArmada',
            'jadwalAktif',
            'totalPelanggan',
            'transaksiTerbaru',
            'keberangkatanHariIni'
        ));
    }
}
