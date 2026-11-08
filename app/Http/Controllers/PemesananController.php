<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PemesananController extends Controller
{
    public function penumpang(Request $request, int $id)
    {
        $data = $request->validate([
            'asal'      => ['required', 'string', 'max:100'],
            'tujuan'    => ['required', 'string', 'max:100'],
            'tanggal'   => ['required', 'date'],
            'penumpang' => ['required', 'integer', 'min:1', 'max:5'],
            'kursi'     => ['required', 'array', 'size:' . (int) $request->input('penumpang')],
            'kursi.*'   => ['string', 'regex:/^\d{2}$/'],
        ]);

        return response('Data Penumpang (sementara). Bus ID ' . $id . ', kursi: ' . implode(', ', $data['kursi']));
    }
}
