<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Jadwal;
use App\Models\AbsensiGuru;
use App\Models\Pertemuan;
use App\Models\Santri;
use App\Models\AbsensiSantri;
use App\Models\Nilai;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class GuruController extends Controller
{
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

    public function jadwalIndex()
    {
        $guru = Auth::user();
        $jadwals = Jadwal::where('guru', $guru->name)->get();
        return view('guru.jadwal', compact('guru', 'jadwals'));
    }

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

    public function pilihMetodeAbsensi($id, $pertemuan_id)
    {
        $guru = Auth::user();
        $jadwal = Jadwal::findOrFail($id);
        $pertemuan = Pertemuan::findOrFail($pertemuan_id);
        return view('guru.pilih_absensi', compact('guru', 'jadwal', 'pertemuan'));
    }

    public function scanAbsensi($id, $pertemuan_id)
    {
        $guru = Auth::user();
        $jadwal = Jadwal::findOrFail($id);
        $pertemuan = Pertemuan::findOrFail($pertemuan_id);

        $santris = Santri::where('kelas', $jadwal->kelas)->get();
        $absensi = AbsensiSantri::where('pertemuan_id', $pertemuan_id)->get();

        return view('guru.scan_absensi', compact('guru', 'jadwal', 'pertemuan', 'santris', 'absensi'));
    }

    public function absensiManual($id, $pertemuan_id)
    {
        $guru = Auth::user();
        $jadwal = Jadwal::findOrFail($id);
        $pertemuan = Pertemuan::findOrFail($pertemuan_id);

        $santris = Santri::where('kelas', $jadwal->kelas)->get();
        $absensi = AbsensiSantri::where('pertemuan_id', $pertemuan_id)->get()->keyBy('santri_id');

        return view('guru.absensi_manual', compact('guru', 'jadwal', 'pertemuan', 'santris', 'absensi'));
    }

    public function simpanAbsensiManual(Request $request, $id, $pertemuan_id)
    {
        $request->validate([
            'status' => 'required|array',
            'status.*' => 'in:Hadir,Izin,Sakit,Alfa',
        ]);

        AbsensiSantri::where('pertemuan_id', $pertemuan_id)->delete();

        foreach ($request->status as $santri_id => $status) {
            AbsensiSantri::create([
                'pertemuan_id' => $pertemuan_id,
                'santri_id' => $santri_id,
                'status' => $status,
                'keterangan' => 'Input Manual',
            ]);
        }

        return redirect('/guru/jadwal/'.$id.'/absensi/'.$pertemuan_id.'/manual')
            ->with('success', 'Absensi berhasil disimpan!');
    }

    public function absensiIndex()
    {
        $guru = Auth::user();
        $jadwals = Jadwal::where('guru', $guru->name)->get();
        
        foreach ($jadwals as $j) {
            $absensi = AbsensiGuru::where('user_id', $guru->id)
                ->where('jadwal_id', $j->id)
                ->where('tanggal', Carbon::now()->toDateString())
                ->first();
            $j->sudah_absen = $absensi ? true : false;

            $waktuMulai = Carbon::parse($j->waktu_mulai);
            $waktuSelesai = Carbon::parse($j->waktu_selesai);
            $sekarang = Carbon::now();

            if ($sekarang->between($waktuMulai, $waktuSelesai)) {
                $j->status = 'Sedang Berlangsung';
                $j->warna = 'bg-success-subtle text-success';
            } elseif ($sekarang->lt($waktuMulai)) {
                $j->status = 'Belum Dimulai';
                $j->warna = 'bg-danger-subtle text-danger';
            } else {
                $j->status = 'Selesai';
                $j->warna = 'bg-secondary-subtle text-secondary';
            }
        }

        return view('guru.absensi_index', compact('guru', 'jadwals'));
    }

    public function absenGuru($id)
    {
        $guru = Auth::user();
        $jadwal = Jadwal::findOrFail($id);

        $cek = AbsensiGuru::where('user_id', $guru->id)
            ->where('jadwal_id', $id)
            ->where('tanggal', Carbon::now()->toDateString())
            ->first();

        if ($cek) {
            return back()->with('error', 'Anda sudah absen untuk jadwal ini hari ini.');
        }

        AbsensiGuru::create([
            'user_id' => $guru->id,
            'jadwal_id' => $id,
            'tanggal' => Carbon::now()->toDateString(),
            'status' => 'Hadir',
            'keterangan' => 'Absen via guru',
        ]);

        return back()->with('success', 'Absensi berhasil dicatat!');
    }

    public function absensiDetail($id)
    {
        $guru = Auth::user();
        $jadwal = Jadwal::findOrFail($id);

        $absensi = AbsensiGuru::where('user_id', $guru->id)
            ->where('jadwal_id', $id)
            ->where('tanggal', Carbon::now()->toDateString())
            ->first();

        $waktuMulai = Carbon::parse($jadwal->waktu_mulai);
        $waktuSelesai = Carbon::parse($jadwal->waktu_selesai);
        $sekarang = Carbon::now();

        if ($sekarang->between($waktuMulai, $waktuSelesai)) {
            $jadwal->status = 'Sedang Berlangsung';
            $jadwal->warna = 'bg-success-subtle text-success';
        } elseif ($sekarang->lt($waktuMulai)) {
            $jadwal->status = 'Belum Dimulai';
            $jadwal->warna = 'bg-danger-subtle text-danger';
        } else {
            $jadwal->status = 'Selesai';
            $jadwal->warna = 'bg-secondary-subtle text-secondary';
        }

        $sudah_absen = $absensi ? true : false;
        $pertemuans = Pertemuan::where('jadwal_id', $id)->orderBy('pertemuan_ke', 'asc')->get();

        return view('guru.absensi_detail', compact('guru', 'jadwal', 'sudah_absen', 'pertemuans'));
    }

    // --- METHOD UNTUK KELOLA NILAI ---

    public function nilaiIndex()
    {
        $guru = Auth::user();
        $jadwals = Jadwal::where('guru', $guru->name)->get();
        return view('guru.nilai_index', compact('guru', 'jadwals'));
    }

    public function nilaiInput($id)
    {
        $guru = Auth::user();
        $jadwal = Jadwal::findOrFail($id);
        $santris = Santri::where('kelas', $jadwal->kelas)->get();
        $nilais = Nilai::where('jadwal_id', $id)->get()->keyBy('santri_id');

        return view('guru.nilai_input', compact('guru', 'jadwal', 'santris', 'nilais'));
    }

    public function nilaiSimpan(Request $request, $id)
    {
        $request->validate([
            'nilai' => 'required|array',
            'nilai.*' => 'nullable|integer|min:0|max:100',
        ]);

        foreach ($request->nilai as $santri_id => $nilai) {
            Nilai::updateOrCreate(
                ['santri_id' => $santri_id, 'jadwal_id' => $id],
                ['nilai' => $nilai]
            );
        }

        return back()->with('success', 'Nilai berhasil disimpan!');
    }

    public function nilaiEdit($jadwal_id, $santri_id)
    {
        $guru = Auth::user();
        $jadwal = Jadwal::findOrFail($jadwal_id);
        $santri = Santri::findOrFail($santri_id);
        $nilai = Nilai::where('jadwal_id', $jadwal_id)->where('santri_id', $santri_id)->first();

        return view('guru.nilai_edit', compact('guru', 'jadwal', 'santri', 'nilai'));
    }

    public function nilaiUpdate(Request $request, $jadwal_id, $santri_id)
    {
        $request->validate([
            'nilai' => 'required|integer|min:0|max:100',
        ]);

        Nilai::updateOrCreate(
            ['jadwal_id' => $jadwal_id, 'santri_id' => $santri_id],
            ['nilai' => $request->nilai]
        );

        return redirect('/guru/nilai/'.$jadwal_id.'/input')->with('success', 'Nilai berhasil diupdate!');
    }
}