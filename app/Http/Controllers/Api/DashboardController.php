<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        return response()->json([
            'total_santri' => 92,
            'total_guru' => 6,
            'total_kelas' => 4,
            'total_mapel' => 3,
        ]);
    }
}