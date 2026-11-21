<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Pemesanan extends Model
{
    protected $table = 'pemesanan';

    protected $fillable = ['kode', 'user_id', 'jadwal_id', 'tanggal_berangkat', 'total_harga', 'status'];

    protected function casts(): array
    {
        return [
            'tanggal_berangkat' => 'date',
            'total_harga'       => 'integer',
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
}
