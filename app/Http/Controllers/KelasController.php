<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kelas;
use App\Models\Santri;

class KelasController extends Controller
{
    public function index()
    {
        $kelas = Kelas::all();
        
        // Hitung jumlah santri per kelas
        foreach ($kelas as $k) {
            $k->jumlah_santri = Santri::where('kelas', $k->nama_kelas)->count();
        }

        return view('admin.kelas', compact('kelas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_kelas' => 'required',
            'kapasitas' => 'required|integer',
            'status' => 'required'
        ]);

        Kelas::create($request->all());
        return redirect('/admin/kelas')->with('success', 'Kelas berhasil ditambahkan!');
    }

    // TAMBAHAN: FUNGSI UNTUK MENAMPILKAN HALAMAN EDIT
    public function edit($id)
    {
        $kelas = Kelas::findOrFail($id);
        return view('admin.edit_kelas', compact('kelas'));
    }

    // TAMBAHAN: FUNGSI UNTUK MENYIMPAN PERUBAHAN (UPDATE)
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_kelas' => 'required',
            'kapasitas' => 'required|integer',
            'status' => 'required'
        ]);

        $kelas = Kelas::findOrFail($id);
        $kelas->update($request->all());

        return redirect('/admin/kelas')->with('success', 'Kelas berhasil diupdate!');
    }

    public function destroy($id)
    {
        Kelas::findOrFail($id)->delete();
        return redirect('/admin/kelas')->with('success', 'Kelas berhasil dihapus!');
    }
}