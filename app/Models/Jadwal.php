<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Jadwal extends Model
{
    protected $table = 'jadwal';

    protected $fillable = ['rute_id', 'bus_id', 'jam_berangkat', 'harga', 'aktif'];

    protected function casts(): array
    {
        return [
            'harga' => 'integer',
            'aktif' => 'boolean',
        ];
    }

    public function rute(): BelongsTo
    {
        return $this->belongsTo(Rute::class);
    }

    public function bus(): BelongsTo
    {
        return $this->belongsTo(Bus::class);
    }

    public function pemesanan(): HasMany
    {
        return $this->hasMany(Pemesanan::class);
    }

    protected function jamBerangkatTampil(): Attribute
    {
        return Attribute::get(fn() => substr($this->jam_berangkat, 0, 5));
    }

    protected function jamTiba(): Attribute
    {
        return Attribute::get(fn() => Carbon::createFromFormat('H:i:s', $this->jam_berangkat)
            ->addMinutes($this->rute->durasi_menit)
            ->format('H:i'));
    }

    public static function untukTampilan(int $id, string $tanggal): array
    {
        return static::with(['bus', 'rute.terminalAsal.kota', 'rute.terminalTujuan.kota'])
            ->where('aktif', true)
            ->findOrFail($id)
            ->tampilan($tanggal);
    }
    public function tampilan(string $tanggal): array
    {
        $tanggal = Carbon::parse($tanggal)->toDateString();

        $terisi = Penumpang::where('jadwal_id', $this->id)
            ->where('tanggal_berangkat', $tanggal)
            ->pluck('nomor_kursi')
            ->sort()
            ->values()
            ->all();

        return [
            'id'              => $this->id,
            'nama'            => $this->bus->nama,
            'kelas'           => $this->bus->kelas,
            'fasilitas'       => $this->bus->fasilitas ?? [],
            'deskripsi'       => $this->bus->deskripsi,
            'berangkat'       => $this->jam_berangkat_tampil,
            'tiba'            => $this->jam_tiba,
            'durasi'          => $this->rute->durasi_tampil,
            'terminal_asal'   => $this->rute->terminalAsal->nama,
            'terminal_tujuan' => $this->rute->terminalTujuan->nama,
            'kota_asal'       => $this->rute->terminalAsal->kota->nama,
            'kota_tujuan'     => $this->rute->terminalTujuan->kota->nama,
            'harga'           => $this->harga,
            'denah'           => $this->bus->denah,
            'kapasitas'       => $this->bus->kapasitas,
            'kursi_terisi'    => $terisi,
        ];
    }
}
