<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Terminal extends Model
{
    protected $table = 'terminal';

    protected $fillable = ['kota_id', 'nama'];

    public function kota(): BelongsTo
    {
        return $this->belongsTo(Kota::class);
    }

    public function ruteAsal(): HasMany
    {
        return $this->hasMany(Rute::class, 'terminal_asal_id');
    }

    public function ruteTujuan(): HasMany
    {
        return $this->hasMany(Rute::class, 'terminal_tujuan_id');
    }
}
