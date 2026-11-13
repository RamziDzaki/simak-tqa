<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ruangan;

class RuanganController extends Controller
{
    public function index()
    {
        $ruangans = Ruangan::all();
        return view('admin.ruangan', compact('ruangans'));
    }

    public function store(Request $request)
    {
        $request->validate(['nama_ruangan' => 'required', 'status' => 'required']);
        Ruangan::create($request->all());
        return redirect('/admin/ruangan')->with('success', 'Ruangan berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $ruangan = Ruangan::findOrFail($id);
        return view('admin.edit_ruangan', compact('ruangan'));
    }

    public function update(Request $request, $id)
    {
        $request->validate(['nama_ruangan' => 'required', 'status' => 'required']);
        $ruangan = Ruangan::findOrFail($id);
        $ruangan->update($request->all());
        return redirect('/admin/ruangan')->with('success', 'Ruangan berhasil diupdate!');
    }

    public function destroy($id)
    {
        Ruangan::findOrFail($id)->delete();
        return redirect('/admin/ruangan')->with('success', 'Ruangan berhasil dihapus!');
    }
}