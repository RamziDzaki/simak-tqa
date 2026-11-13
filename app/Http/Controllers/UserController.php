<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Santri;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $tab = $request->query('tab', 'santri');

        if ($tab == 'santri') {
            $data = Santri::all();
        } elseif ($tab == 'admin') {
            $data = User::where('role', 'admin')->get();
        } else {
            $data = User::where('role', 'guru')->get();
        }

        return view('admin.user', compact('data', 'tab'));
    }

    public function store(Request $request)
    {
        $tab = $request->input('tab', 'santri');

        if ($tab == 'santri') {
            $request->validate(['nama' => 'required', 'kelas' => 'required']);
            Santri::create($request->only('nama', 'kelas', 'status'));
        } else {
            $request->validate(['name' => 'required', 'email' => 'required|email|unique:users', 'password' => 'required']);
            User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => $tab,
                'nip_nik' => $request->nip_nik,
                'mata_pelajaran' => $request->mata_pelajaran,
                'jenis_kelamin' => $request->jenis_kelamin,
                'status' => $request->status ?? 'Aktif',
            ]);
        }

        return redirect('/admin/user?tab=' . $tab)->with('success', 'Data berhasil ditambahkan!');
    }

    // TAMBAHAN: FUNGSI UNTUK MENAMPILKAN HALAMAN EDIT
    public function edit($id, Request $request)
    {
        $tab = $request->query('tab', 'santri');
        
        if ($tab == 'santri') {
            $item = Santri::findOrFail($id);
        } else {
            $item = User::findOrFail($id);
        }

        return view('admin.edit_user', compact('item', 'tab'));
    }

    // TAMBAHAN: FUNGSI UNTUK MENYIMPAN PERUBAHAN (UPDATE)
    public function update(Request $request, $id)
    {
        $tab = $request->input('tab', 'santri');

        if ($tab == 'santri') {
            $item = Santri::findOrFail($id);
            $item->update($request->only('nama', 'kelas', 'status'));
        } else {
            $item = User::findOrFail($id);
            
            $data = [
                'name' => $request->name,
                'email' => $request->email,
                'jenis_kelamin' => $request->jenis_kelamin,
                'status' => $request->status,
            ];

            // Update password hanya jika diisi
            if ($request->filled('password')) {
                $data['password'] = Hash::make($request->password);
            }

            if ($tab == 'guru') {
                $data['nip_nik'] = $request->nip_nik;
                $data['mata_pelajaran'] = $request->mata_pelajaran;
            }

            $item->update($data);
        }

        return redirect('/admin/user?tab=' . $tab)->with('success', 'Data berhasil diupdate!');
    }

    public function destroy($id, Request $request)
    {
        $tab = $request->query('tab', 'santri');
        if ($tab == 'santri') {
            Santri::findOrFail($id)->delete();
        } else {
            User::findOrFail($id)->delete();
        }

        return redirect('/admin/user?tab=' . $tab)->with('success', 'Data berhasil dihapus!');
    }
}