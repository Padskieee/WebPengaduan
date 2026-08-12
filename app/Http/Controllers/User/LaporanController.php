<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\KategoriLaporan;
use App\Models\Laporan;
use App\Models\Lampiran;
use App\Models\LogStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class LaporanController extends Controller
{
    // Halaman buat laporan
    public function create()
    {
        $kategoris = KategoriLaporan::all();
        return view('user.laporan.buat_laporan', compact('kategoris'));
    }

    // Simpan laporan
    public function store(Request $request)
    {
        $request->validate([
            'judul_laporan'   => 'required|string|max:200',
            'isi_laporan'     => 'required|string',
            'id_kategori'     => 'required|exists:kategori_laporan,id_kategori',
            'tanggal_kejadian'=> 'nullable|date',
            'lokasi_kejadian' => 'nullable|string|max:255',
            'anonim'          => 'nullable|boolean',
            'lampiran.*'      => 'nullable|file|mimes:jpg,jpeg,png,pdf,mp4|max:10240',
        ]);

        // Simpan laporan
        $laporan = Laporan::create([
            'id_user'          => Auth::guard('web')->id(),
            'id_kategori'      => $request->id_kategori,
            'judul_laporan'    => $request->judul_laporan,
            'isi_laporan'      => $request->isi_laporan,
            'tanggal_kejadian' => $request->tanggal_kejadian,
            'lokasi_kejadian'  => $request->lokasi_kejadian,
            'anonim'           => $request->has('anonim') ? 1 : 0,
            'status'           => 'menunggu',
        ]);

        // Simpan lampiran jika ada
        if ($request->hasFile('lampiran')) {
            foreach ($request->file('lampiran') as $file) {
                $ext      = $file->getClientOriginalExtension();
                $tipe     = in_array($ext, ['jpg','jpeg','png']) ? 'foto'
                          : (in_array($ext, ['mp4']) ? 'video' : 'dokumen');
                $path     = $file->store('lampiran', 'public');

                Lampiran::create([
                    'id_laporan' => $laporan->id_laporan,
                    'file_path'  => $path,
                    'tipe_file'  => $tipe,
                ]);
            }
        }

        // Catat log status
        LogStatus::create([
            'id_laporan'     => $laporan->id_laporan,
            'status'         => 'menunggu',
            'keterangan'     => 'Laporan berhasil dikirim',
            'updated_by'     => 'user',
            'tanggal_update' => now(),
        ]);

        return redirect()->route('user.laporan.index')
            ->with('success', 'Laporan berhasil dikirim!');
    }

        // Riwayat laporan
    public function index(Request $request)
    {
        $query = Laporan::where('id_user', Auth::guard('web')->id())
            ->with('kategori')
            ->latest();

        // Filter status
        if ($request->status) {
            $query->where('status', $request->status);
        }

        // Filter pencarian judul
        if ($request->search) {
            $query->where('judul_laporan', 'like', '%' . $request->search . '%');
        }

        $laporans = $query->paginate(10);

        return view('user.laporan.riwayat_laporan', compact('laporans'));
    }

    // Detail laporan
    public function show($id)
    {
        $laporan = Laporan::where('id_user', Auth::guard('web')->id())
            ->with(['kategori', 'lampiran', 'logStatus', 'hasilLaporan.lampiranHasil'])
            ->findOrFail($id);

        return view('user.laporan.detail_laporan', compact('laporan'));
    }
}
