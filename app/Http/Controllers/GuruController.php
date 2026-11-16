<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Jadwal;
use App\Models\AbsensiGuru;
use App\Models\Pertemuan;
use App\Models\Santri;
use App\Models\AbsensiSantri;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class GuruController extends Controller
{
    // Dashboard Guru
    public function dashboard()
    {
        $guru = Auth::user();
        if ($guru->role !== 'guru') return redirect('/admin/dashboard');

        $hariIni = Carbon::now()->locale('id')->isoFormat('dddd');
        $jadwalHariIni = Jadwal::where('guru', $guru->name)->where('hari', $hariIni)->get();

        foreach ($jadwalHariIni as $j) {
            $waktuMulai = Carbon::parse($j->waktu_mulai);
            $waktuSelesai = Carbon::parse($j->waktu_selesai);
            $sekarang = Carbon::now();

            if ($sekarang->between($waktuMulai, $waktuSelesai)) {
                $j->status = 'Berlangsung'; $j->warna = 'bg-success-subtle text-success';
            } elseif ($sekarang->lt($waktuMulai)) {
                $j->status = 'Belum'; $j->warna = 'bg-danger-subtle text-danger';
            } else {
                $j->status = 'Selesai'; $j->warna = 'bg-secondary-subtle text-secondary';
            }
        }

        $totalMapel = Jadwal::where('guru', $guru->name)->distinct('mata_pelajaran')->count('mata_pelajaran');
        $jadwalSelesai = $jadwalHariIni->filter(fn($j) => $j->status === 'Selesai')->count();

        return view('guru.dashboard', compact('guru', 'jadwalHariIni', 'totalMapel', 'jadwalSelesai', 'hariIni'));
    }

    // Halaman Daftar Jadwal Mengajar
    public function jadwalIndex()
    {
        $guru = Auth::user();
        $jadwals = Jadwal::where('guru', $guru->name)->get();
        return view('guru.jadwal', compact('guru', 'jadwals'));
    }

    // Halaman Daftar Pertemuan per Jadwal
    public function pertemuanIndex($id)
    {
        $guru = Auth::user();
        $jadwal = Jadwal::findOrFail($id);
        
        if ($jadwal->guru !== $guru->name) {
            return redirect('/guru/jadwal')->with('error', 'Anda tidak berhak mengakses jadwal ini.');
        }

        $pertemuans = Pertemuan::where('jadwal_id', $id)->orderBy('pertemuan_ke', 'asc')->get();
        return view('guru.pertemuan', compact('guru', 'jadwal', 'pertemuans'));
    }

    // Halaman Pilih Metode Absensi
    public function pilihMetodeAbsensi($id, $pertemuan_id)
    {
        $guru = Auth::user();
        $jadwal = Jadwal::findOrFail($id);
        $pertemuan = Pertemuan::findOrFail($pertemuan_id);
        return view('guru.pilih_absensi', compact('guru', 'jadwal', 'pertemuan'));
    }

    // Halaman Scan QR & Daftar Hadir
    public function scanAbsensi($id, $pertemuan_id)
    {
        $guru = Auth::user();
        $jadwal = Jadwal::findOrFail($id);
        $pertemuan = Pertemuan::findOrFail($pertemuan_id);

        $santris = Santri::where('kelas', $jadwal->kelas)->get();
        $absensi = AbsensiSantri::where('pertemuan_id', $pertemuan_id)->get();

        return view('guru.scan_absensi', compact('guru', 'jadwal', 'pertemuan', 'santris', 'absensi'));
    }
}