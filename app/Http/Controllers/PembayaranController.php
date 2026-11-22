<?php

namespace App\Http\Controllers;

use App\Models\Pemesanan;
use App\Services\MidtransService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class PembayaranController extends Controller
{
    public function __construct(private MidtransService $midtrans) {}

    public function bayar(Request $request, string $kode): View
    {
        $pemesanan = Pemesanan::with([
            'penumpang',
            'user',
            'jadwal.bus',
            'jadwal.rute.terminalAsal.kota',
            'jadwal.rute.terminalTujuan.kota',
        ])
            ->where('kode', $kode)
            ->where('user_id', $request->user()->id)
            ->where('status', 'menunggu_pembayaran')
            ->firstOrFail();

        if (! $pemesanan->snap_token) {
            $pemesanan->update([
                'snap_token' => $this->midtrans->buatSnapToken($pemesanan),
            ]);
        }

        return view('pembayaran.bayar', compact('pemesanan'));
    }

    public function webhook(Request $request): JsonResponse
    {
        $payload = $request->all();

        if (! isset($payload['order_id'], $payload['status_code'], $payload['gross_amount'], $payload['signature_key'])) {
            return response()->json(['message' => 'Invalid payload'], 400);
        }

        // Prodution 
        // $serverKey    = config('services.midtrans.server_key');
        // $signatureKey = hash('sha512',
        //     $payload['order_id'].
        //     $payload['status_code'].
        //     $payload['gross_amount'].
        //     $serverKey
        // );
        // if ($signatureKey !== $payload['signature_key']) {
        //     Log::warning('Midtrans webhook: signature tidak valid', $payload);
        //     return response()->json(['message' => 'Invalid signature'], 403);
        // }

        $pemesanan = Pemesanan::where('kode', $payload['order_id'])->first();

        if (! $pemesanan) {
            return response()->json(['message' => 'Pemesanan tidak ditemukan'], 404);
        }

        if ($pemesanan->status === 'lunas') {
            return response()->json(['message' => 'Already processed']);
        }

        $transactionStatus = $payload['transaction_status'];
        $fraudStatus       = $payload['fraud_status'] ?? null;

        $status = match (true) {
            $transactionStatus === 'capture' && $fraudStatus === 'accept' => 'lunas',
            $transactionStatus === 'settlement'                           => 'lunas',
            $transactionStatus === 'pending'                              => 'menunggu_pembayaran',
            in_array($transactionStatus, ['cancel', 'deny', 'expire'])   => 'gagal',
            default                                                       => null,
        };

        if ($status) {
            $pemesanan->update([
                'status'       => $status,
                'dibayar_pada' => $status === 'lunas' ? now() : null,
            ]);
        }

        return response()->json(['message' => 'OK']);
    }

    public function selesaiMidtrans(Request $request): RedirectResponse
    {
        $orderId           = $request->query('order_id');
        $transactionStatus = $request->query('transaction_status');

        if (! $orderId) {
            return redirect()->route('home');
        }

        if (in_array($transactionStatus, ['settlement', 'capture'])) {
            return redirect()->route('pemesanan.sukses', $orderId);
        }

        if (in_array($transactionStatus, ['cancel', 'deny', 'expire'])) {
            return redirect()->route('pembayaran.gagal', $orderId);
        }

        // pending: kembali ke halaman sukses (menunggu pembayaran)
        return redirect()->route('pemesanan.sukses', $orderId);
    }

    public function gagal(Request $request, string $kode): View
    {
        $pemesanan = Pemesanan::with([
            'penumpang',
            'jadwal.bus',
            'jadwal.rute.terminalAsal.kota',
            'jadwal.rute.terminalTujuan.kota',
        ])
            ->where('kode', $kode)
            ->where('user_id', $request->user()->id)
            ->firstOrFail();

        return view('pembayaran.gagal', compact('pemesanan'));
    }

    public function selesai(Request $request, string $kode): RedirectResponse
    {
        return redirect()->route('pemesanan.sukses', $kode);
    }
}
