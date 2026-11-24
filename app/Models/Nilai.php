<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Nilai extends Model
{
    use HasFactory;

    protected $fillable = ['santri_id', 'jadwal_id', 'nilai'];

    public function santri()
    {
        return $this->belongsTo(Santri::class);
    }

    public function jadwal()
    {
        return $this->belongsTo(Jadwal::class);
    }
}