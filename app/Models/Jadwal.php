<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jadwal extends Model
{
    use HasFactory;
    protected $fillable = ['kelas', 'mata_pelajaran', 'guru', 'hari', 'waktu_mulai', 'waktu_selesai'];
}