<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Jadwal;
use App\Models\AbsensiGuru;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class GuruController extends Controller
{
    public function dashboard()
    {
        $guru = Auth::user();
        
        if ($guru->role !== 'guru') {
            return redirect('/admin/dashboard');
        }

        $hariIni = Carbon::now()->locale('id')->isoFormat('dddd');
        $tanggalIni = Carbon::now();

        // Ambil jadwal hari ini untuk guru ini
        $jadwalHariIni = Jadwal::where('guru', $guru->name)
            ->where('hari', $hariIni)
            ->get();

        // Tentukan status untuk setiap jadwal
        foreach ($jadwalHariIni as $j) {
            $waktuMulai = Carbon::parse($j->waktu_mulai);
            $waktuSelesai = Carbon::parse($j->waktu_selesai);
            $sekarang = Carbon::now();

            if ($sekarang->between($waktuMulai, $waktuSelesai)) {
                $j->status = 'Berlangsung';
                $j->warna = 'bg-success-subtle text-success';
            } elseif ($sekarang->lt($waktuMulai)) {
                $j->status = 'Belum';
                $j->warna = 'bg-danger-subtle text-danger';
            } else {
                $j->status = 'Selesai';
                $j->warna = 'bg-secondary-subtle text-secondary';
            }
        }

        // Total mata pelajaran unik
        $totalMapel = Jadwal::where('guru', $guru->name)
            ->distinct('mata_pelajaran')
            ->count('mata_pelajaran');

        // Jumlah jadwal yang sudah selesai (hari ini)
        $jadwalSelesai = $jadwalHariIni->filter(function($j) {
            return $j->status === 'Selesai';
        })->count();

        return view('guru.dashboard', compact('guru', 'jadwalHariIni', 'totalMapel', 'jadwalSelesai', 'hariIni'));
    }
}