<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\KategoriLaporan;
use Illuminate\Http\Request;

class KategoriController extends Controller
{
    public function index(Request $request)
    {
        $search  = $request->input('search');
        $sort    = $request->input('sort', 'terbaru'); // default: terbaru

        $query = KategoriLaporan::withCount('laporan');

        // ── SEARCH ──────────────────────────────────────────
        if ($search) {
            $query->where('nama_kategori', 'like', '%' . $search . '%');
        }

        // ── SORTING ─────────────────────────────────────────
        switch ($sort) {
            case 'terbanyak':
                $query->orderBy('laporan_count', 'desc');
                break;
            case 'tersedikit':
                $query->orderBy('laporan_count', 'asc');
                break;
            case 'abjad_az':
                $query->orderBy('nama_kategori', 'asc');
                break;
            case 'abjad_za':
                $query->orderBy('nama_kategori', 'desc');
                break;
            case 'terlama':
                $query->orderBy('created_at', 'asc');
                break;
            default: // terbaru
                $query->orderBy('created_at', 'desc');
                break;
        }

        $kategoris = $query->paginate(10)->withQueryString();

        return view('admin.kategori.kategori_laporan', compact('kategoris', 'search', 'sort'));
    }

    public function create()
    {
        return view('admin.kategori.tambah_kategori');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_kategori' => 'required|string|max:255|unique:kategori_laporan,nama_kategori',
            'deskripsi'     => 'nullable|string',
        ], [
            'nama_kategori.required' => 'Nama kategori wajib diisi.',
            'nama_kategori.unique'   => 'Nama kategori sudah ada.',
        ]);

        KategoriLaporan::create([
            'nama_kategori' => $request->nama_kategori,
            'deskripsi'     => $request->deskripsi,
        ]);

        return redirect()->route('admin.kategori.index')
            ->with('success', 'Kategori berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $kategori = KategoriLaporan::findOrFail($id);
        return view('admin.kategori.edit_kategori', compact('kategori'));
    }

    public function update(Request $request, $id)
    {
        $kategori = KategoriLaporan::findOrFail($id);

        $request->validate([
            'nama_kategori' => 'required|string|max:255|unique:kategori_laporan,nama_kategori,' . $id . ',id_kategori',
            'deskripsi'     => 'nullable|string',
        ], [
            'nama_kategori.required' => 'Nama kategori wajib diisi.',
            'nama_kategori.unique'   => 'Nama kategori sudah ada.',
        ]);

        $kategori->update([
            'nama_kategori' => $request->nama_kategori,
            'deskripsi'     => $request->deskripsi,
        ]);

        return redirect()->route('admin.kategori.index')
            ->with('success', 'Kategori berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $kategori = KategoriLaporan::withCount('laporan')->findOrFail($id);

        if ($kategori->laporan_count > 0) {
            return redirect()->route('admin.kategori.index')
                ->with('error', 'Kategori tidak bisa dihapus karena masih digunakan oleh ' . $kategori->laporan_count . ' laporan.');
        }

        $kategori->delete();

        return redirect()->route('admin.kategori.index')
            ->with('success', 'Kategori berhasil dihapus.');
    }
}
