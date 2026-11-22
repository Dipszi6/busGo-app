<?php

namespace App\Services;

use App\Models\Pemesanan;
use Midtrans\Config;
use Midtrans\Snap;

class MidtransService
{
    public function __construct()
    {
        Config::$serverKey    = config('services.midtrans.server_key');
        Config::$isProduction = config('services.midtrans.is_production');
        Config::$isSanitized  = config('services.midtrans.is_sanitized');
        Config::$is3ds        = config('services.midtrans.is_3ds');
    }

    public function buatSnapToken(Pemesanan $pemesanan): string
    {
        $penumpangPertama = $pemesanan->penumpang->first();

        $params = [
            'transaction_details' => [
                'order_id'     => $pemesanan->kode,
                'gross_amount' => $pemesanan->total_harga,
            ],
            'customer_details' => [
                'first_name' => $pemesanan->user->name,
                'email'      => $pemesanan->user->email,
            ],
            'item_details' => $pemesanan->penumpang->map(fn($p) => [
                'id'       => 'KURSI-' . $p->nomor_kursi,
                'price'    => $pemesanan->jadwal->harga,
                'quantity' => 1,
                'name'     => $pemesanan->jadwal->bus->nama . ' - Kursi ' . $p->nomor_kursi,
            ])->values()->all(),
        ];

        return Snap::getSnapToken($params);
    }
}
