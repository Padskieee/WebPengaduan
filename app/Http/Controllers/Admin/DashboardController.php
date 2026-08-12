<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Laporan;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $totalLaporan  = Laporan::count();
        $menunggu      = Laporan::where('status', 'menunggu')->count();
        $selesai       = Laporan::where('status', 'selesai')->count();
        $ditolak       = Laporan::where('status', 'ditolak')->count();
        $diverifikasi  = Laporan::where('status', 'diverifikasi')->count();
        $diproses      = Laporan::where('status', 'diproses')->count();
        $totalUser     = User::count();

        $laporanTerbaru = Laporan::with(['user', 'kategori'])
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalLaporan',
            'menunggu',
            'selesai',
            'ditolak',
            'diverifikasi',
            'diproses',
            'totalUser',
            'laporanTerbaru'
        ));
    }
}
