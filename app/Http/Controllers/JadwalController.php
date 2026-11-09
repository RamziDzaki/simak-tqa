<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kelas;
use App\Models\Jadwal;

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

    // Menampilkan halaman form atur jadwal
    public function create($nama_kelas)
    {
        $kelas = Kelas::where('nama_kelas', $nama_kelas)->firstOrFail();
        $jadwals = Jadwal::where('kelas', $nama_kelas)->get();
        return view('admin.atur_jadwal', compact('kelas', 'jadwals'));
    }

    // Menyimpan jadwal baru
    public function store(Request $request)
    {
        $request->validate([
            'kelas' => 'required',
            'mata_pelajaran' => 'required',
            'guru' => 'required',
            'hari' => 'required',
            'waktu_mulai' => 'required',
            'waktu_selesai' => 'required',
        ]);

        Jadwal::create($request->all());

        return redirect('/admin/jadwal/' . $request->kelas . '/atur')->with('success', 'Jadwal berhasil ditambahkan!');
    }
}