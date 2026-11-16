<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kelas;
use App\Models\Jadwal;
use App\Models\MataPelajaran;
use App\Models\User;

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

    // Menampilkan halaman form atur jadwal (pakai ID kelas)
    public function create($id)
    {
        $kelas = Kelas::findOrFail($id);
        $jadwals = Jadwal::where('kelas', $kelas->nama_kelas)->get();
        $mapels = MataPelajaran::all();
        $gurus = User::where('role', 'guru')->get();
        
        return view('admin.atur_jadwal', compact('kelas', 'jadwals', 'mapels', 'gurus'));
    }

    // Menyimpan jadwal baru
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

        // Redirect pakai ID kelas agar aman dari spasi
        $kelas = Kelas::where('nama_kelas', $request->kelas)->first();
        return redirect('/admin/jadwal/' . $kelas->id . '/atur')
            ->with('success', 'Jadwal berhasil ditambahkan!');
    }

    // --- TAMBAHAN BARU: Method untuk Edit ---
    public function edit($id)
    {
        $jadwal = Jadwal::findOrFail($id);
        return response()->json($jadwal);
    }

    // --- TAMBAHAN BARU: Method untuk Update ---
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
    // --- AKHIR TAMBAHAN BARU ---

    // Hapus jadwal
    public function destroy($id)
    {
        Jadwal::findOrFail($id)->delete();
        return back()->with('success', 'Jadwal berhasil dihapus!');
    }
}