<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kelas;
use App\Models\Santri;
use App\Models\Ruangan;

class KelasController extends Controller
{
    public function index()
    {
        $kelas = Kelas::all();

        // Hitung jumlah santri pada setiap kelas
        foreach ($kelas as $k) {
            $k->jumlah_santri = Santri::where(
                'kelas',
                $k->nama_kelas
            )->count();
        }

        // Ambil data ruangan untuk pilihan form kelas
        $ruangans = Ruangan::all();

        return view('admin.kelas', compact('kelas', 'ruangans'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_kelas' => 'required|string|max:255',
            'ruangan' => 'nullable|exists:ruangans,nama_ruangan',
            'kapasitas' => 'required|integer|min:1',
            'status' => 'required|string|max:255',
        ]);

        Kelas::create($validated);

        return redirect('/admin/kelas')
            ->with('success', 'Kelas berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $kelas = Kelas::findOrFail($id);
        $ruangans = Ruangan::all();

        return view('admin.edit_kelas', compact('kelas', 'ruangans'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'nama_kelas' => 'required|string|max:255',
            'ruangan' => 'nullable|exists:ruangans,nama_ruangan',
            'kapasitas' => 'required|integer|min:1',
            'status' => 'required|string|max:255',
        ]);

        $kelas = Kelas::findOrFail($id);
        $kelas->update($validated);

        return redirect('/admin/kelas')
            ->with('success', 'Kelas berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $kelas = Kelas::findOrFail($id);
        $kelas->delete();

        return redirect('/admin/kelas')
            ->with('success', 'Kelas berhasil dihapus!');
    }
}
