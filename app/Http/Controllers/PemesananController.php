<?php

namespace App\Http\Controllers;

use App\Models\Jadwal;
use App\Models\Pemesanan;
use App\Models\Penumpang;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\UniqueConstraintViolationException;
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
        $sesi = $request->session()->get('kursi_dipilih');
        abort_if(! $sesi || $sesi['jadwal_id'] !== $id, 404);

        $pencarian = $sesi['pencarian'];
        $kursi     = $sesi['kursi'];

        $bus = Jadwal::untukTampilan($id, $pencarian['tanggal']);
        $pencarian['asal']   = $bus['kota_asal'];
        $pencarian['tujuan'] = $bus['kota_tujuan'];

        return view('pemesanan.penumpang', [
            'bus'           => $bus,
            'pencarian'     => $pencarian,
            'kursi'         => $kursi,
            'tanggalTampil' => Carbon::parse($pencarian['tanggal'])->locale('id')->translatedFormat('d F Y'),
            'total'         => $bus['harga'] * count($kursi),
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

    public function konfirmasi(Request $request, int $id): View
    {
        $pemesanan = $request->session()->get('pemesanan');
        abort_if(! $pemesanan || ($pemesanan['jadwal_id'] ?? null) !== $id, 404);

        $bus = Jadwal::untukTampilan($id, $pemesanan['pencarian']['tanggal']);

        return view('pemesanan.konfirmasi', [
            'bus'       => $bus,
            'pemesanan' => $pemesanan,
            'total'     => $bus['harga'] * count($pemesanan['kursi']),
            'tanggalTampil' => Carbon::parse($pemesanan['pencarian']['tanggal'])
                ->locale('id')->translatedFormat('d F Y'),
        ]);
    }

    public function simpan(Request $request, int $id): RedirectResponse
    {
        $sesi = $request->session()->get('pemesanan');
        abort_if(! $sesi || ($sesi['jadwal_id'] ?? null) !== $id, 404);

        $bus    = Jadwal::untukTampilan($id, $sesi['pencarian']['tanggal']);
        $tanggal = $sesi['pencarian']['tanggal'];
        $kursi  = $sesi['kursi'];

        $sudahTerisi = Penumpang::where('jadwal_id', $id)
            ->where('tanggal_berangkat', $tanggal)
            ->whereIn('nomor_kursi', $kursi)
            ->pluck('nomor_kursi')
            ->all();

        if (! empty($sudahTerisi)) {
            return redirect()
                ->route('tiket.kursi', ['id' => $id] + $sesi['pencarian'])
                ->withErrors(['kursi' => 'Kursi ' . implode(', ', $sudahTerisi) . ' baru saja dipesan orang lain. Silakan pilih kursi lain.']);
        }

        try {
            $pemesanan = DB::transaction(function () use ($request, $id, $sesi, $bus, $tanggal, $kursi) {
                $pemesanan = Pemesanan::create([
                    'kode'             => Pemesanan::buatKode(),
                    'user_id'          => $request->user()->id,
                    'jadwal_id'        => $id,
                    'tanggal_berangkat' => $tanggal,
                    'total_harga'      => $bus['harga'] * count($kursi),
                    'status'           => 'menunggu_pembayaran',
                ]);

                foreach ($kursi as $i => $nomor) {
                    $pemesanan->penumpang()->create([
                        'jadwal_id'         => $id,
                        'tanggal_berangkat' => $tanggal,
                        'nomor_kursi'       => $nomor,
                        'nama'              => $sesi['penumpang'][$i]['nama'],
                        'nik'               => $sesi['penumpang'][$i]['nik'],
                        'telepon'           => $sesi['penumpang'][$i]['telepon'],
                        'email'             => $sesi['penumpang'][$i]['email'],
                        'jenis_kelamin'     => $sesi['penumpang'][$i]['jenis_kelamin'],
                    ]);
                }

                return $pemesanan;
            });
        } catch (UniqueConstraintViolationException) {
            return redirect()
                ->route('tiket.kursi', ['id' => $id] + $sesi['pencarian'])
                ->withErrors(['kursi' => 'Kursi yang kamu pilih baru saja dipesan orang lain. Silakan pilih kursi lain.']);
        }

        $request->session()->forget('pemesanan');

        return redirect()->route('pemesanan.sukses', $pemesanan->kode);
    }

    public function ringkasan(Request $request, int $id): View
    {
        $pemesanan = $request->session()->get('pemesanan');
        abort_if(! $pemesanan || ($pemesanan['jadwal_id'] ?? null) !== $id, 404);

        $bus = Jadwal::untukTampilan($id, $pemesanan['pencarian']['tanggal']);

        return view('pemesanan.konfirmasi', [
            'bus'           => $bus,
            'pemesanan'     => $pemesanan,
            'total'         => $bus['harga'] * count($pemesanan['kursi']),
            'tanggalTampil' => Carbon::parse($pemesanan['pencarian']['tanggal'])
                ->locale('id')->translatedFormat('d F Y'),
        ]);
    }

    public function sukses(Request $request, string $kode): View
    {
        $pemesanan = Pemesanan::with(['penumpang', 'jadwal.rute.terminalAsal.kota', 'jadwal.rute.terminalTujuan.kota', 'jadwal.bus'])
            ->where('kode', $kode)
            ->where('user_id', $request->user()->id)
            ->firstOrFail();

        return view('pemesanan.sukses', compact('pemesanan'));
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
