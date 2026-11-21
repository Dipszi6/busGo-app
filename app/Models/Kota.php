<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Kota extends Model
{
    protected $table = 'kota';

    protected $fillable = ['nama'];

    public function terminal(): HasMany
    {
        return $this->hasMany(Terminal::class);
    }
}
