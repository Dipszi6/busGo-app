<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Penumpang extends Model
{
    protected $table = 'penumpang';

    protected $fillable = [
        'pemesanan_id',
        'jadwal_id',
        'tanggal_berangkat',
        'nomor_kursi',
        'nama',
        'nik',
        'telepon',
        'email',
        'jenis_kelamin',
    ];

    protected function casts(): array
    {
        return [
            'tanggal_berangkat' => 'date',
            'nik'               => 'encrypted',
        ];
    }

    public function pemesanan(): BelongsTo
    {
        return $this->belongsTo(Pemesanan::class);
    }

    public function jadwal(): BelongsTo
    {
        return $this->belongsTo(Jadwal::class);
    }
}
