<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MataPelajaran;

class MataPelajaranController extends Controller
{
    public function index()
    {
        $mapels = MataPelajaran::all();
        return view('admin.mata_pelajaran', compact('mapels'));
    }

    public function store(Request $request)
    {
        $request->validate(['nama' => 'required', 'status' => 'required']);
        MataPelajaran::create($request->all());
        return redirect('/admin/mata-pelajaran')->with('success', 'Mata Pelajaran berhasil ditambahkan!');
    }

    // TAMBAHAN: FUNGSI UNTUK MENAMPILKAN HALAMAN EDIT
    public function edit($id)
    {
        $mapel = MataPelajaran::findOrFail($id);
        return view('admin.edit_mata_pelajaran', compact('mapel'));
    }

    // TAMBAHAN: FUNGSI UNTUK MENYIMPAN PERUBAHAN (UPDATE)
    public function update(Request $request, $id)
    {
        $request->validate(['nama' => 'required', 'status' => 'required']);
        $mapel = MataPelajaran::findOrFail($id);
        $mapel->update($request->all());
        return redirect('/admin/mata-pelajaran')->with('success', 'Mata Pelajaran berhasil diupdate!');
    }

    public function destroy($id)
    {
        MataPelajaran::findOrFail($id)->delete();
        return redirect('/admin/mata-pelajaran')->with('success', 'Mata Pelajaran berhasil dihapus!');
    }
}