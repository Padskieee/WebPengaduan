<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HasilLaporan;
use App\Models\LampiranHasil;
use App\Models\Laporan;
use App\Models\LogStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class HasilLaporanController extends Controller
{
    // Form buat hasil
    public function create($id_laporan)
    {
        $laporan = Laporan::with(['user', 'kategori'])
            ->findOrFail($id_laporan);

        return view('admin.hasil.buat_hasil_penyelesaian', compact('laporan'));
    }

    // Simpan hasil
    public function store(Request $request, $id_laporan)
    {
        $request->validate([
            'judul_output'    => 'required|string|max:200',
            'deskripsi_output'=> 'required|string',
            'status_publish'  => 'required|in:draft,publish',
            'lampiran.*'      => 'nullable|file|mimes:jpg,jpeg,png,pdf,mp4|max:10240',
            'jenis_lampiran.*'=> 'nullable|in:sebelum,sesudah,lainnya',
        ]);

        // Simpan hasil
        $hasil = HasilLaporan::create([
            'id_laporan'      => $id_laporan,
            'id_admin'        => Auth::guard('admin')->id(),
            'judul_output'    => $request->judul_output,
            'deskripsi_output'=> $request->deskripsi_output,
            'status_publish'  => $request->status_publish,
            'tanggal_publish' => $request->status_publish == 'publish' ? now() : null,
        ]);

        // Simpan lampiran
        if ($request->hasFile('lampiran')) {
            foreach ($request->file('lampiran') as $key => $file) {
                $ext   = $file->getClientOriginalExtension();
                $tipe  = in_array($ext, ['jpg','jpeg','png']) ? 'foto'
                       : ($ext == 'mp4' ? 'video' : 'dokumen');
                $path  = $file->store('lampiran_hasil', 'public');
                $jenis = $request->jenis_lampiran[$key] ?? 'lainnya';

                LampiranHasil::create([
                    'id_hasil'      => $hasil->id_hasil,
                    'jenis_lampiran'=> $jenis,
                    'file_path'     => $path,
                    'tipe_file'     => $tipe,
                ]);
            }
        }

        // Update status laporan jadi selesai jika publish
        if ($request->status_publish == 'publish') {
            $laporan = Laporan::findOrFail($id_laporan);
            $laporan->status = 'selesai';
            $laporan->save();

            LogStatus::create([
                'id_laporan'     => $id_laporan,
                'status'         => 'selesai',
                'keterangan'     => 'Hasil penyelesaian telah dipublikasikan',
                'updated_by'     => 'admin',
                'tanggal_update' => now(),
            ]);
        }

        return redirect()->route('admin.laporan.show', $id_laporan)
            ->with('success', 'Hasil penyelesaian berhasil disimpan!');
    }

    // List semua hasil
    public function index()
    {
        $hasils = HasilLaporan::with(['laporan.kategori', 'admin'])
            ->latest()
            ->paginate(10);

        return view('admin.hasil.hasil_penyelesaian', compact('hasils'));
    }

    // Detail hasil
    public function show($id)
    {
        $hasil = HasilLaporan::with([
            'laporan.user',
            'laporan.kategori',
            'lampiranHasil',
            'admin'
        ])->findOrFail($id);

        return view('admin.hasil.detail_hasil_penyelesaian', compact('hasil'));
    }

    // Publish/unpublish
    public function togglePublish($id)
    {
        $hasil = HasilLaporan::findOrFail($id);

        if ($hasil->status_publish == 'draft') {
            $hasil->status_publish  = 'publish';
            $hasil->tanggal_publish = now();

            // Update laporan jadi selesai
            $hasil->laporan->update(['status' => 'selesai']);

            LogStatus::create([
                'id_laporan'     => $hasil->id_laporan,
                'status'         => 'selesai',
                'keterangan'     => 'Hasil penyelesaian dipublikasikan',
                'updated_by'     => 'admin',
                'tanggal_update' => now(),
            ]);
        } else {
            $hasil->status_publish  = 'draft';
            $hasil->tanggal_publish = null;
        }

        $hasil->save();

        return back()->with('success', 'Status publish berhasil diubah!');
    }
}
