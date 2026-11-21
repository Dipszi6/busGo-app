<?php

namespace App\Http\Controllers;

use App\Models\Jadwal;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\View\View;

class PemesananController extends Controller
{
    public function penumpang(Request $request, int $id): View
    {
        $data = $request->validate($this->aturanPilihan($request));

        $bus = Jadwal::untukTampilan($id, $data['tanggal']);

        $pencarian = Arr::only($data, ['asal', 'tujuan', 'tanggal', 'penumpang']);
        $pencarian['asal']   = $bus['kota_asal'];
        $pencarian['tujuan'] = $bus['kota_tujuan'];

        return view('pemesanan.penumpang', [
            'bus'           => $bus,
            'pencarian'     => $pencarian,
            'kursi'         => $data['kursi'],
            'tanggalTampil' => Carbon::parse($data['tanggal'])->locale('id')->translatedFormat('d F Y'),
            'total'         => $bus['harga'] * count($data['kursi']),
        ]);
    }

    public function simpanPenumpang(Request $request, int $id): RedirectResponse
    {
        $jumlah = (int) $request->input('penumpang');

        $data = $request->validate($this->aturanPilihan($request) + [
            'identitas'                 => ['required', 'array', 'size:' . $jumlah],
            'identitas.*.nama'          => ['required', 'string', 'max:100'],
            'identitas.*.nik'           => ['required', 'digits:16'],
            'identitas.*.telepon'       => ['required', 'regex:/^(\+62|62|0)8\d{8,12}$/'],
            'identitas.*.email'         => ['required', 'email', 'max:100'],
            'identitas.*.jenis_kelamin' => ['required', 'in:L,P'],
        ], [
            'identitas.*.nama.required'          => 'Nama lengkap wajib diisi.',
            'identitas.*.nik.required'           => 'NIK wajib diisi.',
            'identitas.*.nik.digits'             => 'NIK harus terdiri dari 16 angka.',
            'identitas.*.telepon.required'       => 'Nomor telepon wajib diisi.',
            'identitas.*.telepon.regex'          => 'Format nomor telepon tidak valid. Contoh: 081234567890.',
            'identitas.*.email.required'         => 'Alamat email wajib diisi.',
            'identitas.*.email.email'            => 'Format email tidak valid.',
            'identitas.*.jenis_kelamin.required' => 'Pilih jenis kelamin.',
            'identitas.*.jenis_kelamin.in'       => 'Pilihan jenis kelamin tidak valid.',
        ]);

        $bus = Jadwal::untukTampilan($id, $data['tanggal']);

        $pencarian = Arr::only($data, ['asal', 'tujuan', 'tanggal', 'penumpang']);
        $pencarian['asal']   = $bus['kota_asal'];
        $pencarian['tujuan'] = $bus['kota_tujuan'];

        $request->session()->put('pemesanan', [
            'jadwal_id' => $bus['id'],
            'pencarian' => $pencarian,
            'kursi'     => $data['kursi'],
            'penumpang' => $data['identitas'],
        ]);

        return redirect()->route('pemesanan.ringkasan', ['id' => $bus['id']]);
    }

    public function ringkasan(Request $request, int $id): JsonResponse
    {
        $pemesanan = $request->session()->get('pemesanan');
        abort_if(! $pemesanan || ($pemesanan['jadwal_id'] ?? null) !== $id, 404);

        return response()->json($pemesanan, 200, [], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    }

    private function aturanPilihan(Request $request): array
    {
        return [
            'asal'      => ['required', 'string', 'max:100'],
            'tujuan'    => ['required', 'string', 'max:100'],
            'tanggal'   => ['required', 'date', 'after_or_equal:today'],
            'penumpang' => ['required', 'integer', 'min:1', 'max:5'],
            'kursi'     => ['required', 'array', 'size:' . (int) $request->input('penumpang')],
            'kursi.*'   => ['string', 'regex:/^\d{2}$/', 'distinct'],
        ];
    }
}
