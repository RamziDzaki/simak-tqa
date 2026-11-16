<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pertemuan extends Model
{
    use HasFactory;

    protected $fillable = [
        'jadwal_id',
        'tanggal',
        'pertemuan_ke',
        'sub_materi',
    ];

    public function jadwal()
    {
        return $this->belongsTo(Jadwal::class);
    }
}