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

    public function destroy($id)
    {
        MataPelajaran::findOrFail($id)->delete();
        return redirect('/admin/mata-pelajaran')->with('success', 'Mata Pelajaran berhasil dihapus!');
    }
}