<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
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

        return response()->json($data);
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

        return response()->json(['message' => 'Data berhasil ditambahkan!'], 201);
    }

    public function destroy(int $id, Request $request)
    {
        $tab = $request->query('tab', 'santri');

        if ($tab == 'santri') {
            Santri::findOrFail($id)->delete();
        } else {
            User::findOrFail($id)->delete();
        }

        return response()->json(['message' => 'Data berhasil dihapus!']);
    }
}