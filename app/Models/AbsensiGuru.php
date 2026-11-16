<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AbsensiGuru extends Model
{
    use HasFactory;

    protected $table = 'absensi_gurus';

    protected $fillable = [
        'user_id',
        'jadwal_id',
        'tanggal',
        'status',
        'keterangan',
    ];

    // Relasi ke User (Guru)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke Jadwal
    public function jadwal()
    {
        return $this->belongsTo(Jadwal::class);
    }
}