<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\HasilLaporan;
use App\Models\Laporan;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::guard('web')->user();

        // ── Statistik laporan MILIK USER ──
        $totalLaporan = Laporan::where('id_user', $user->id_user)->count();
        $menunggu     = Laporan::where('id_user', $user->id_user)->where('status', 'menunggu')->count();
        $diproses     = Laporan::where('id_user', $user->id_user)->where('status', 'diproses')->count();
        $selesai      = Laporan::where('id_user', $user->id_user)->where('status', 'selesai')->count();
        $ditolak      = Laporan::where('id_user', $user->id_user)->where('status', 'ditolak')->count();

        // ── Rekap KESELURUHAN SISTEM (semua user) ──
        $sistemTotal    = Laporan::count();
        $sistemMenunggu = Laporan::where('status', 'menunggu')->count();
        $sistemDiproses = Laporan::where('status', 'diproses')->count();
        $sistemSelesai  = Laporan::where('status', 'selesai')->count();
        $sistemDitolak  = Laporan::where('status', 'ditolak')->count();

        // ── Feed publik terbaru ──
        $feeds = HasilLaporan::where('status_publish', 'publish')
            ->with(['laporan.kategori', 'laporan.user', 'lampiranHasil', 'admin'])
            ->latest('tanggal_publish')
            ->take(5)
            ->get();

        return view('user.dashboard', compact(
            'user',
            'totalLaporan',
            'menunggu',
            'diproses',
            'selesai',
            'ditolak',
            'sistemTotal',
            'sistemMenunggu',
            'sistemDiproses',
            'sistemSelesai',
            'sistemDitolak',
            'feeds'
        ));
    }
}
