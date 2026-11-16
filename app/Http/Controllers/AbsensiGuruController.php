<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AbsensiGuru;
use App\Models\User;
use App\Models\Jadwal;
use Carbon\Carbon;

class AbsensiGuruController extends Controller
{
    // HALAMAN 1: Daftar Semua Guru
    public function daftarGuru()
    {
        $gurus = User::where('role', 'guru')->get();
        return view('admin.absensi_guru_list', compact('gurus'));
    }

    // HALAMAN 2: Detail Absensi Guru Tertentu
    public function index($id)
    {
        $guru = User::findOrFail($id);
        $jadwal = Jadwal::where('guru', $guru->name)->first();
        $absensis = AbsensiGuru::where('user_id', $guru->id)
            ->orderBy('tanggal', 'desc')
            ->paginate(10);

        return view('admin.absensi_guru', compact('guru', 'jadwal', 'absensis'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'jadwal_id' => 'required|exists:jadwals,id',
            'status' => 'required|in:Hadir,Izin,Sakit,Alpha',
        ]);

        AbsensiGuru::create([
            'user_id' => $request->user_id,
            'jadwal_id' => $request->jadwal_id,
            'tanggal' => Carbon::now()->toDateString(),
            'status' => $request->status,
            'keterangan' => $request->keterangan,
        ]);

        return back()->with('success', 'Absensi berhasil dicatat!');
    }

    // EXPORT CSV Per Guru
    public function export($id)
    {
        $guru = User::findOrFail($id);
        $absensis = AbsensiGuru::with(['user', 'jadwal'])
            ->where('user_id', $guru->id)
            ->orderBy('tanggal', 'desc')
            ->get();
        
        $filename = 'laporan_absensi_' . str_replace(' ', '_', $guru->name) . '_' . date('Y-m-d') . '.csv';
        
        $headers = [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$filename",
        ];

        $columns = ['No', 'Nama Guru', 'Tanggal', 'Jam', 'Status', 'Keterangan'];

        $callback = function() use($absensis, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);
            $no = 1;
            foreach ($absensis as $row) {
                fputcsv($file, [
                    $no++,
                    $row->user->name ?? '-',
                    Carbon::parse($row->tanggal)->format('d/m/Y'),
                    ($row->jadwal->waktu_mulai ?? '') . ' - ' . ($row->jadwal->waktu_selesai ?? ''),
                    $row->status,
                    $row->keterangan ?? '-'
                ]);
            }
            fclose($file);
        };
        return response()->stream($callback, 200, $headers);
    }

    // Absen Hari Ini Per Guru
    public function absenHariIni($id)
    {
        $guru = User::findOrFail($id);
        $jadwal = Jadwal::where('guru', $guru->name)->first();
        
        if (!$jadwal) {
            return back()->with('error', 'Jadwal guru tidak ditemukan.');
        }

        $cek = AbsensiGuru::where('user_id', $guru->id)
            ->where('tanggal', Carbon::now()->toDateString())
            ->first();

        if ($cek) {
            return back()->with('error', 'Guru ini sudah absen hari ini!');
        }

        AbsensiGuru::create([
            'user_id' => $guru->id,
            'jadwal_id' => $jadwal->id,
            'tanggal' => Carbon::now()->toDateString(),
            'status' => 'Hadir',
            'keterangan' => 'Absen via sistem',
        ]);

        return back()->with('success', 'Absensi hari ini berhasil dicatat!');
    }
}