<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kelas;
use App\Models\Jadwal;
use App\Models\MataPelajaran;
use App\Models\User;
use App\Models\Pertemuan;
use Carbon\Carbon;

class JadwalController extends Controller
{
    public function index()
    {
        $kelas = Kelas::all();
        foreach ($kelas as $k) {
            $k->jumlah_pertemuan = Jadwal::where('kelas', $k->nama_kelas)->count();
        }
        return view('admin.jadwal', compact('kelas'));
    }

    public function create($id)
    {
        $kelas = Kelas::findOrFail($id);
        $jadwals = Jadwal::where('kelas', $kelas->nama_kelas)->get();
        $mapels = MataPelajaran::all();
        $gurus = User::where('role', 'guru')->get();
        
        return view('admin.atur_jadwal', compact('kelas', 'jadwals', 'mapels', 'gurus'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kelas' => 'required|string',
            'mata_pelajaran' => 'required|string',
            'guru' => 'required|string',
            'hari' => 'required|string',
            'waktu_mulai' => 'required',
            'waktu_selesai' => 'required|after:waktu_mulai',
        ]);

        Jadwal::create([
            'kelas' => $request->kelas,
            'mata_pelajaran' => $request->mata_pelajaran,
            'guru' => $request->guru,
            'hari' => $request->hari,
            'waktu_mulai' => $request->waktu_mulai,
            'waktu_selesai' => $request->waktu_selesai,
        ]);

        $kelas = Kelas::where('nama_kelas', $request->kelas)->first();
        return redirect('/admin/jadwal/' . $kelas->id . '/atur')
            ->with('success', 'Jadwal berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $jadwal = Jadwal::findOrFail($id);
        return response()->json($jadwal);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'mata_pelajaran' => 'required|string',
            'guru' => 'required|string',
            'hari' => 'required|string',
            'waktu_mulai' => 'required',
            'waktu_selesai' => 'required|after:waktu_mulai',
        ]);

        $jadwal = Jadwal::findOrFail($id);
        $jadwal->update([
            'mata_pelajaran' => $request->mata_pelajaran,
            'guru' => $request->guru,
            'hari' => $request->hari,
            'waktu_mulai' => $request->waktu_mulai,
            'waktu_selesai' => $request->waktu_selesai,
        ]);

        return back()->with('success', 'Jadwal berhasil diupdate!');
    }

    public function destroy($id)
    {
        Jadwal::findOrFail($id)->delete();
        return back()->with('success', 'Jadwal berhasil dihapus!');
    }

    public function generatePertemuan(Request $request, $id)
    {
        $request->validate([
            'tgl_mulai' => 'required',
            'tgl_selesai' => 'required',
            'jumlah_pertemuan' => 'required|integer|min:1',
        ]);

        $kelas = Kelas::findOrFail($id);
        $jadwals = Jadwal::where('kelas', $kelas->nama_kelas)->get();

        if ($jadwals->isEmpty()) {
            return back()->with('error', 'Belum ada jadwal untuk kelas ini.');
        }

        foreach ($jadwals as $j) {
            Pertemuan::where('jadwal_id', $j->id)->delete();
        }

        // Tangani dua format tanggal (Y-m-d atau format Indonesia)
        try {
            $tglMulai = Carbon::parse($request->tgl_mulai);
        } catch (\Exception $e) {
            $tglMulai = Carbon::createFromLocaleFormat('l, j F Y', 'id', $request->tgl_mulai);
        }

        $jumlahPertemuan = $request->jumlah_pertemuan;

        foreach ($jadwals as $jadwal) {
            $hariJadwal = strtolower($jadwal->hari);
            
            $tanggal = $tglMulai->copy();
            $count = 0;
            while ($count < $jumlahPertemuan) {
                if (strtolower($tanggal->isoFormat('dddd')) == $hariJadwal) {
                    $count++;
                    Pertemuan::create([
                        'jadwal_id' => $jadwal->id,
                        'tanggal' => $tanggal->toDateString(),
                        'pertemuan_ke' => $count,
                    ]);
                    $tanggal->addWeek();
                } else {
                    $tanggal->addDay();
                }
            }
        }

        return redirect('/admin/jadwal/' . $id . '/daftar-pertemuan')->with('success', 'Jadwal pertemuan berhasil di-generate!');
    }

    public function daftarPertemuan($id)
    {
        $kelas = Kelas::findOrFail($id);
        $jadwals = Jadwal::where('kelas', $kelas->nama_kelas)->get();
        
        $pertemuans = Pertemuan::whereIn('jadwal_id', $jadwals->pluck('id'))
            ->orderBy('tanggal', 'asc')
            ->get();

        return view('admin.daftar_pertemuan', compact('kelas', 'pertemuans', 'jadwals'));
    }
}