<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Laporan;
use App\Models\LogStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $query = Laporan::with(['user', 'kategori', 'admin'])->latest();

        if ($request->status) {
            $query->where('status', $request->status);
        }

        if ($request->search) {
            $query->where('judul_laporan', 'like', '%' . $request->search . '%');
        }

        $laporans = $query->paginate(10)->withQueryString();

        return view('admin.laporan.kelola_laporan', compact('laporans'));
    }

    public function show($id)
    {
        $laporan = Laporan::with([
            'user', 'kategori', 'admin',
            'lampiran', 'logStatus',
            'hasilLaporan.lampiranHasil'
        ])->findOrFail($id);

        return view('admin.laporan.detail_laporan', compact('laporan'));
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status'     => 'required|in:diverifikasi,diproses,selesai,ditolak',
            'keterangan' => 'nullable|string',
        ]);

        $laporan           = Laporan::findOrFail($id);
        $laporan->status   = $request->status;
        $laporan->id_admin = Auth::guard('admin')->id();
        $laporan->save();

        LogStatus::create([
            'id_laporan'     => $laporan->id_laporan,
            'status'         => $request->status,
            'keterangan'     => $request->keterangan ?? 'Status diperbarui oleh admin',
            'updated_by'     => 'admin',
            'tanggal_update' => now(),
        ]);

        return back()->with('success', 'Status laporan berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $laporan = Laporan::with(['lampiran', 'hasilLaporan.lampiranHasil'])->findOrFail($id);

        // Hapus file lampiran laporan
        foreach ($laporan->lampiran as $lamp) {
            Storage::disk('public')->delete($lamp->file_path);
        }

        // Hapus file lampiran hasil laporan
        foreach ($laporan->hasilLaporan as $hasil) {
            foreach ($hasil->lampiranHasil as $lamp) {
                Storage::disk('public')->delete($lamp->file_path);
            }
        }

        $laporan->delete();

        return redirect()->route('admin.laporan.index')
            ->with('success', 'Laporan berhasil dihapus.');
    }
}
