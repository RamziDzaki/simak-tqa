<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pertemuan extends Model
{
    use HasFactory;

    protected $fillable = [
        'kelas', 
        'tanggal', 
        'hari', 
        'waktu_mulai', 
        'waktu_selesai', 
        'mata_pelajaran', 
        'guru'
    ];
}