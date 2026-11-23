<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;
use Carbon\Carbon;

class Pemesanan extends Model
{
    protected $table = 'pemesanan';

    protected $fillable = [
        'kode',
        'user_id',
        'jadwal_id',
        'tanggal_berangkat',
        'total_harga',
        'status',
        'snap_token',
        'dibayar_pada'
    ];

    protected function casts(): array
    {
        return [
            'tanggal_berangkat' => 'date',
            'total_harga'       => 'integer',
            'dibayar_pada' => 'datetime',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function jadwal(): BelongsTo
    {
        return $this->belongsTo(Jadwal::class);
    }

    public function penumpang(): HasMany
    {
        return $this->hasMany(Penumpang::class);
    }

    public static function buatKode(): string
    {
        do {
            $kode = 'BG' . now()->format('Ymd') . strtoupper(Str::random(6));
        } while (static::where('kode', $kode)->exists());

        return $kode;
    }

    public function sudahKedaluwarsa(): bool
    {
        if ($this->status !== 'menunggu_pembayaran') {
            return false;
        }

        $waktuBerangkat = Carbon::parse(
            $this->tanggal_berangkat->toDateString() . ' ' . $this->jadwal->jam_berangkat
        );

        return $waktuBerangkat->isPast();
    }
}
