<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Rute extends Model
{
    protected $table = 'rute';

    protected $fillable = ['terminal_asal_id', 'terminal_tujuan_id', 'durasi_menit'];

    public function terminalAsal(): BelongsTo
    {
        return $this->belongsTo(Terminal::class, 'terminal_asal_id');
    }

    public function terminalTujuan(): BelongsTo
    {
        return $this->belongsTo(Terminal::class, 'terminal_tujuan_id');
    }

    public function jadwal(): HasMany
    {
        return $this->hasMany(Jadwal::class);
    }

    protected function durasiTampil(): Attribute
    {
        return Attribute::get(function () {
            $jam   = intdiv($this->durasi_menit, 60);
            $menit = $this->durasi_menit % 60;

            return $menit ? "{$jam} Jam {$menit} Menit" : "{$jam} Jam";
        });
    }
}
