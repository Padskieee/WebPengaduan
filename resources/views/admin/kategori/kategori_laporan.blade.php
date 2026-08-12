@extends('layouts.admin')

@section('title', 'Kategori Laporan')

@section('styles')
<style>
    .page-header {
        background: linear-gradient(135deg, #1B5E20, #2E7D32);
        border-radius: 16px;
        padding: 1.2rem 1.5rem;
        color: white;
        margin-bottom: 1.5rem;
        position: relative;
        overflow: hidden;
    }
    .page-header::after {
        content: '';
        position: absolute;
        right: -30px; bottom: -30px;
        width: 150px; height: 150px;
        background: rgba(255,255,255,0.06);
        border-radius: 50%;
    }
    .page-header h6 { font-weight: 700; font-size: 1rem; margin: 0; position: relative; z-index: 1; }
    .page-header p  { font-size: 0.8rem; opacity: 0.8; margin: 0; position: relative; z-index: 1; }

    .btn-tambah {
        background: white;
        color: #1B5E20;
        border: none;
        border-radius: 10px;
        padding: 0.5rem 1.1rem;
        font-size: 0.85rem;
        font-weight: 600;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        transition: background 0.15s, transform 0.15s;
        position: relative;
        z-index: 1;
    }
    .btn-tambah:hover { background: #f1f8e9; color: #1B5E20; transform: translateY(-1px); }

    /* FILTER BAR */
    .filter-bar {
        background: white;
        border-radius: 12px;
        padding: 0.9rem 1.2rem;
        margin-bottom: 1.2rem;
        box-shadow: 0 2px 8px rgba(0,0,0,0.06);
        display: flex;
        align-items: center;
        gap: 0.75rem;
        flex-wrap: wrap;
    }
    .filter-bar .form-control {
        border: 1.5px solid #e0e0e0;
        border-radius: 8px;
        font-size: 0.85rem;
        padding: 0.45rem 0.75rem;
        max-width: 260px;
    }
    .filter-bar .form-select {
        border: 1.5px solid #e0e0e0;
        border-radius: 8px;
        font-size: 0.78rem;
        padding: 0.35rem 1.8rem 0.35rem 0.6rem;
        max-width: 155px;
        color: #616161;
    }
    .filter-bar .form-control:focus,
    .filter-bar .form-select:focus {
        border-color: #2E7D32;
        box-shadow: 0 0 0 3px rgba(46,125,50,0.1);
        outline: none;
    }

    /* TABLE */
    .table-card {
        background: white;
        border-radius: 14px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.06);
        overflow: hidden;
    }
    .table thead th {
        background: #f5f5f5;
        font-size: 0.78rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: #757575;
        border: none;
        padding: 0.85rem 1rem;
    }
    .table tbody td {
        font-size: 0.85rem;
        color: #424242;
        padding: 0.85rem 1rem;
        vertical-align: middle;
        border-color: #f5f5f5;
    }
    .table tbody tr:hover { background: #fafafa; }

    .nama-cell { font-weight: 600; color: #212121; }

    .badge-count {
        background: #E8F5E9;
        color: #1B5E20;
        font-size: 0.75rem;
        font-weight: 600;
        padding: 0.25rem 0.65rem;
        border-radius: 20px;
        display: inline-flex;
        align-items: center;
        gap: 4px;
    }

    .btn-edit {
        background: #E3F2FD;
        color: #1565C0;
        border: none;
        border-radius: 7px;
        padding: 0.3rem 0.8rem;
        font-size: 0.78rem;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.2s;
    }
    .btn-edit:hover { background: #1565C0; color: white; }

    .btn-hapus {
        background: #FFEBEE;
        color: #B71C1C;
        border: none;
        border-radius: 7px;
        padding: 0.3rem 0.8rem;
        font-size: 0.78rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s;
    }
    .btn-hapus:hover { background: #B71C1C; color: white; }

    .empty-state { text-align: center; padding: 3rem; color: #9e9e9e; }

    .pagination .page-link {
        border-radius: 8px !important;
        margin: 0 2px;
        border: 1.5px solid #e0e0e0;
        color: #2E7D32;
        font-size: 0.85rem;
    }
    .pagination .page-item.active .page-link { background-color: #2E7D32; border-color: #2E7D32; color: white; }
    .pagination .page-link:hover { background-color: #E8F5E9; border-color: #2E7D32; color: #1B5E20; }

    /* ── CUSTOM MODAL MANUAL ─────────────────────────────── */
    .custom-backdrop {
        display: none;
        position: fixed;
        inset: 0;
        background: rgba(0, 0, 0, 0.55);
        z-index: 9998;
    }

    .custom-modal-wrap {
        display: none;
        position: fixed;
        inset: 0;
        z-index: 9999;
        align-items: center;
        justify-content: center;
    }

    .custom-modal-wrap.show {
        display: flex;
    }

    .custom-modal {
        background: white;
        border-radius: 14px;
        width: 100%;
        max-width: 440px;
        box-shadow: 0 24px 64px rgba(0,0,0,0.25);
        animation: modalIn 0.2s ease;
        overflow: hidden;
    }

    @keyframes modalIn {
        from { transform: translateY(-20px); opacity: 0; }
        to   { transform: translateY(0);     opacity: 1; }
    }

    .custom-modal-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 1rem 1.4rem;
        border-bottom: 1px solid #f5f5f5;
    }

    .custom-modal-header h6 {
        margin: 0;
        font-weight: 700;
        font-size: 0.95rem;
    }

    .custom-modal-close {
        background: none;
        border: none;
        font-size: 1.1rem;
        color: #9e9e9e;
        cursor: pointer;
        line-height: 1;
        padding: 0.2rem 0.4rem;
        border-radius: 6px;
        transition: all 0.2s;
    }
    .custom-modal-close:hover { background: #f5f5f5; color: #424242; }

    .custom-modal-body {
        padding: 1.2rem 1.4rem;
    }

    .custom-modal-footer {
        display: flex;
        justify-content: flex-end;
        gap: 0.5rem;
        padding: 0.9rem 1.4rem;
        border-top: 1px solid #f5f5f5;
    }

    .btn-batal {
        background: white;
        border: 1.5px solid #e0e0e0;
        border-radius: 8px;
        padding: 0.4rem 1rem;
        font-size: 0.85rem;
        font-weight: 600;
        color: #616161;
        cursor: pointer;
        transition: all 0.2s;
    }
    .btn-batal:hover { background: #f5f5f5; }

    .btn-konfirm-hapus {
        background: #C62828;
        border: none;
        border-radius: 8px;
        padding: 0.4rem 1rem;
        font-size: 0.85rem;
        font-weight: 600;
        color: white;
        cursor: pointer;
        transition: all 0.2s;
        display: inline-flex;
        align-items: center;
        gap: 5px;
    }
    .btn-konfirm-hapus:hover { background: #B71C1C; }
    .btn-konfirm-hapus:disabled {
        background: #e0e0e0;
        color: #9e9e9e;
        cursor: not-allowed;
    }
</style>
@endsection

@section('content')

{{-- PAGE HEADER --}}
<div class="page-header">
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h6><i class="fas fa-tags me-2"></i>Kategori Laporan</h6>
            <p>Kelola kategori untuk pengelompokan laporan masyarakat</p>
        </div>
        <a href="{{ route('admin.kategori.create') }}" class="btn-tambah">
            <i class="fas fa-plus"></i> Tambah Kategori
        </a>
    </div>
</div>

{{-- FILTER BAR --}}
<div class="filter-bar">
    <form method="GET" action="{{ route('admin.kategori.index') }}"
          class="d-flex align-items-center gap-2 flex-wrap w-100"
          id="filterForm">

        <span class="small fw-bold text-muted">Cari:</span>
        <input type="text" name="search" class="form-control"
               placeholder="Cari nama kategori..."
               value="{{ $search }}">

        <select name="sort" class="form-select" onchange="document.getElementById('filterForm').submit()">
            <option value="terbaru"    {{ $sort == 'terbaru'    ? 'selected' : '' }}>Terbaru</option>
            <option value="terlama"    {{ $sort == 'terlama'    ? 'selected' : '' }}>Terlama</option>
            <option value="terbanyak"  {{ $sort == 'terbanyak'  ? 'selected' : '' }}>Terbanyak</option>
            <option value="tersedikit" {{ $sort == 'tersedikit' ? 'selected' : '' }}>Tersedikit</option>
            <option value="abjad_az"   {{ $sort == 'abjad_az'   ? 'selected' : '' }}>A → Z</option>
            <option value="abjad_za"   {{ $sort == 'abjad_za'   ? 'selected' : '' }}>Z → A</option>
        </select>

        <button type="submit" class="btn btn-sm btn-success px-3">
            <i class="fas fa-search"></i>
        </button>

        @if($search || $sort != 'terbaru')
            <a href="{{ route('admin.kategori.index') }}" class="btn btn-sm btn-outline-secondary">
                <i class="fas fa-times"></i> Reset
            </a>
        @endif

        <span class="ms-auto small text-muted">
            Total: <strong>{{ $kategoris->total() }}</strong> kategori
        </span>
    </form>
</div>

{{-- TABLE --}}
<div class="table-card">
    <div class="table-responsive">
        <table class="table mb-0">
            <thead>
                <tr>
                    <th style="width:50px">#</th>
                    <th>Nama Kategori</th>
                    <th>Deskripsi</th>
                    <th style="width:140px">Jumlah Laporan</th>
                    <th style="width:100px">Dibuat</th>
                    <th style="width:130px">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @if($kategoris->count() > 0)
                    @foreach($kategoris as $i => $kategori)
                        <tr>
                            <td class="text-muted small">{{ $kategoris->firstItem() + $i }}</td>
                            <td><div class="nama-cell">{{ $kategori->nama_kategori }}</div></td>
                            <td>
                                <span class="small text-muted">
                                    {{ $kategori->deskripsi ? Str::limit($kategori->deskripsi, 60) : '—' }}
                                </span>
                            </td>
                            <td>
                                <span class="badge-count">
                                    <i class="fas fa-file-alt"></i>
                                    {{ $kategori->laporan_count }} laporan
                                </span>
                            </td>
                            <td class="small text-muted">
                                {{ \Carbon\Carbon::parse($kategori->created_at)->locale('id')->isoFormat('D MMM Y') }}
                            </td>
                            <td>
                                <div class="d-flex gap-2">
                                    <a href="{{ route('admin.kategori.edit', $kategori->id_kategori) }}"
                                       class="btn-edit">
                                        <i class="fas fa-pen"></i> Edit
                                    </a>
                                    <button class="btn-hapus"
                                            onclick="konfirmasiHapus(
                                                {{ $kategori->id_kategori }},
                                                '{{ addslashes($kategori->nama_kategori) }}',
                                                {{ $kategori->laporan_count }}
                                            )">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="6">
                            <div class="empty-state">
                                <i class="fas fa-tags fa-3x mb-3 d-block" style="color:#c8e6c9;"></i>
                                <p class="fw-bold mb-1">
                                    {{ $search ? 'Kategori tidak ditemukan' : 'Belum ada kategori' }}
                                </p>
                                <small>
                                    {{ $search ? 'Coba kata kunci lain' : 'Tambahkan kategori untuk mengelompokkan laporan' }}
                                </small>
                            </div>
                        </td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>
</div>

{{-- PAGINATION --}}
@if($kategoris->hasPages())
    <div class="d-flex justify-content-center mt-3">
        {{ $kategoris->links() }}
    </div>
@endif

{{-- ── CUSTOM MODAL MANUAL (tanpa Bootstrap Modal) ──────── --}}
<div class="custom-backdrop" id="customBackdrop"></div>

<div class="custom-modal-wrap" id="modalHapusWrap">
    <div class="custom-modal" id="modalHapusBox">

        <div class="custom-modal-header">
            <h6>
                <i class="fas fa-trash me-2 text-danger"></i>Hapus Kategori
            </h6>
            <button class="custom-modal-close" onclick="tutupModal()">
                <i class="fas fa-times"></i>
            </button>
        </div>

        <div class="custom-modal-body">
            <p class="mb-1 small text-muted">Kamu akan menghapus kategori:</p>
            <p class="fw-bold mb-3" id="namaKategoriModal">—</p>

            <div id="pesanLaporan" class="alert alert-warning small py-2 d-none">
                <i class="fas fa-exclamation-triangle me-1"></i>
                Kategori ini masih digunakan oleh
                <strong id="jumlahLaporan">0</strong> laporan dan tidak bisa dihapus.
            </div>
            <p id="pesanKonfirmasi" class="small text-muted mb-0">
                Tindakan ini tidak bisa dibatalkan.
            </p>
        </div>

        <div class="custom-modal-footer">
            <button class="btn-batal" onclick="tutupModal()">Batal</button>
            <form id="formHapus" method="POST" style="display:inline;">
                @csrf
                @method('DELETE')
                <button type="submit" id="btnHapusConfirm" class="btn-konfirm-hapus">
                    <i class="fas fa-trash"></i> Hapus
                </button>
            </form>
        </div>

    </div>
</div>

@endsection

@section('scripts')
<script>
function konfirmasiHapus(id, nama, jumlahLaporan) {
    document.getElementById('namaKategoriModal').textContent = nama;
    document.getElementById('formHapus').action = '{{ url("admin/kategori") }}/' + id;

    const pesanLaporan    = document.getElementById('pesanLaporan');
    const pesanKonfirmasi = document.getElementById('pesanKonfirmasi');
    const btnHapus        = document.getElementById('btnHapusConfirm');

    if (jumlahLaporan > 0) {
        document.getElementById('jumlahLaporan').textContent = jumlahLaporan;
        pesanLaporan.classList.remove('d-none');
        pesanKonfirmasi.style.display = 'none';
        btnHapus.disabled = true;
    } else {
        pesanLaporan.classList.add('d-none');
        pesanKonfirmasi.style.display = 'block';
        btnHapus.disabled = false;
    }

    // Tampilkan backdrop + modal
    document.getElementById('customBackdrop').style.display = 'block';
    document.getElementById('modalHapusWrap').classList.add('show');
}

function tutupModal() {
    document.getElementById('customBackdrop').style.display = 'none';
    document.getElementById('modalHapusWrap').classList.remove('show');
}

// Klik backdrop = tutup modal
document.getElementById('customBackdrop').addEventListener('click', tutupModal);

// Tekan ESC = tutup modal
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') tutupModal();
});
</script>
@endsection
