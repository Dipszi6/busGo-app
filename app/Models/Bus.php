<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Bus extends Model
{
    protected $table = 'bus';

    protected $fillable = ['nama', 'kelas', 'denah', 'kapasitas', 'fasilitas', 'deskripsi'];

    protected function casts(): array
    {
        return [
            'fasilitas' => 'array',
        ];
    }

    public function jadwal(): HasMany
    {
        return $this->hasMany(Jadwal::class);
    }
}
