<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Santri;
use App\Models\Kelas;
use App\Models\MataPelajaran;

class DashboardController extends Controller
{
    public function index()
    {
        // Menghitung data asli dari database
        $totalSantri = Santri::count();
        $totalGuru = User::where('role', 'guru')->count();
        $totalKelas = Kelas::count();
        $totalMapel = MataPelajaran::count();

        return response()->json([
            'total_santri' => $totalSantri,
            'total_guru' => $totalGuru,
            'total_kelas' => $totalKelas,
            'total_mapel' => $totalMapel,
        ]);
    }
}