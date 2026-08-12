<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->search ?? '';
        $sort   = $request->sort   ?? 'terbaru';

        $query = User::withCount('laporan');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('nama',  'like', '%' . $search . '%')
                  ->orWhere('email', 'like', '%' . $search . '%')
                  ->orWhere('no_hp', 'like', '%' . $search . '%');
            });
        }

        match ($sort) {
            'terlama'    => $query->orderBy('created_at', 'asc'),
            'terbanyak'  => $query->orderByDesc('laporan_count'),
            'tersedikit' => $query->orderBy('laporan_count', 'asc'),
            'abjad_az'   => $query->orderBy('nama', 'asc'),
            'abjad_za'   => $query->orderBy('nama', 'desc'),
            default      => $query->orderBy('created_at', 'desc'),
        };

        $users            = $query->paginate(10)->withQueryString();
        $totalUser        = User::count();
        $userAktif        = User::has('laporan')->count();
        $userBelumLaporan = User::doesntHave('laporan')->count();

        return view('admin.user.data_user', compact(
            'users', 'totalUser', 'userAktif', 'userBelumLaporan', 'search', 'sort'
        ));
    }

    public function show($id)
    {
        $user     = User::withCount('laporan')->findOrFail($id);
        $laporans = $user->laporan()
            ->with('kategori')
            ->orderBy('created_at', 'desc')
            ->paginate(5);

        return view('admin.user.detail_user', compact('user', 'laporans'));
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);

        $laporanAktif = $user->laporan()
            ->whereIn('status', ['menunggu', 'diverifikasi', 'diproses'])
            ->count();

        if ($laporanAktif > 0) {
            return redirect()->route('admin.user.index')
                ->with('error', 'User tidak bisa dihapus karena masih memiliki ' . $laporanAktif . ' laporan yang sedang aktif.');
        }

        $user->delete();

        return redirect()->route('admin.user.index')
            ->with('success', 'User berhasil dihapus.');
    }
}
