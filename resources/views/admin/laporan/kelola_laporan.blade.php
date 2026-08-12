@extends('layouts.admin')

@section('title', 'Kelola Laporan')

@push('styles')
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

    .filter-bar {
        background: white;
        border-radius: 12px;
        padding: 1rem 1.2rem;
        margin-bottom: 1.2rem;
        box-shadow: 0 2px 8px rgba(0,0,0,0.06);
        display: flex;
        align-items: center;
        gap: 1rem;
        flex-wrap: wrap;
    }
    .filter-bar .form-select,
    .filter-bar .form-control {
        border: 1.5px solid #e0e0e0;
        border-radius: 8px;
        font-size: 0.85rem;
        padding: 0.5rem 0.75rem;
        max-width: 200px;
    }
    .filter-bar .form-select:focus,
    .filter-bar .form-control:focus {
        border-color: #2E7D32;
        box-shadow: 0 0 0 3px rgba(46,125,50,0.1);
    }

    .stat-mini {
        display: flex;
        gap: 0.75rem;
        margin-bottom: 1.2rem;
        flex-wrap: wrap;
    }
    .stat-mini-item {
        background: white;
        border-radius: 10px;
        padding: 0.6rem 1rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        box-shadow: 0 2px 6px rgba(0,0,0,0.06);
        font-size: 0.82rem;
        cursor: pointer;
        text-decoration: none;
        color: #424242;
        transition: all 0.2s;
        border: 2px solid transparent;
    }
    .stat-mini-item:hover  { border-color: #2E7D32; color: #1B5E20; }
    .stat-mini-item.active { border-color: #2E7D32; background: #E8F5E9; color: #1B5E20; }
    .stat-mini-item .count { font-weight: 700; font-size: 1rem; }

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

    .judul-cell {
        max-width: 220px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        font-weight: 600;
        color: #212121;
    }

    .status-badge {
        font-size: 0.72rem;
        font-weight: 600;
        padding: 0.3rem 0.75rem;
        border-radius: 20px;
        white-space: nowrap;
    }
    .status-menunggu     { background:#FFF8E1; color:#F57F17; }
    .status-diverifikasi { background:#E3F2FD; color:#1565C0; }
    .status-diproses     { background:#FFF3E0; color:#E65100; }
    .status-selesai      { background:#E8F5E9; color:#1B5E20; }
    .status-ditolak      { background:#FFEBEE; color:#B71C1C; }

    .btn-detail {
        background: #E8F5E9;
        color: #1B5E20;
        border: none;
        border-radius: 8px;
        padding: 0.35rem 0.85rem;
        font-size: 0.78rem;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.2s;
    }
    .btn-detail:hover { background: #1B5E20; color: white; }

    .btn-hapus {
        background: #FFEBEE;
        color: #B71C1C;
        border: none;
        border-radius: 7px;
        padding: 0.35rem 0.65rem;
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

    /* ── CUSTOM MODAL ── */
    .custom-backdrop {
        display: none;
        position: fixed;
        inset: 0;
        background: rgba(0,0,0,0.55);
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
    .custom-modal-wrap.show { display: flex; }
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
    .custom-modal-header h6 { margin: 0; font-weight: 700; font-size: 0.95rem; }
    .custom-modal-close {
        background: none; border: none; font-size: 1.1rem;
        color: #9e9e9e; cursor: pointer; line-height: 1;
        padding: 0.2rem 0.4rem; border-radius: 6px; transition: all 0.2s;
    }
    .custom-modal-close:hover { background: #f5f5f5; color: #424242; }
    .custom-modal-body  { padding: 1.2rem 1.4rem; }
    .custom-modal-footer {
        display: flex; justify-content: flex-end;
        gap: 0.5rem; padding: 0.9rem 1.4rem;
        border-top: 1px solid #f5f5f5;
    }
    .btn-batal {
        background: white; border: 1.5px solid #e0e0e0;
        border-radius: 8px; padding: 0.4rem 1rem;
        font-size: 0.85rem; font-weight: 600;
        color: #616161; cursor: pointer; transition: all 0.2s;
    }
    .btn-batal:hover { background: #f5f5f5; }
    .btn-konfirm-hapus {
        background: #C62828; border: none; border-radius: 8px;
        padding: 0.4rem 1rem; font-size: 0.85rem; font-weight: 600;
        color: white; cursor: pointer; transition: all 0.2s;
        display: inline-flex; align-items: center; gap: 5px;
    }
    .btn-konfirm-hapus:hover { background: #B71C1C; }
</style>
@endpush

@section('content')

<div class="page-header">
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h6><i class="fas fa-inbox me-2"></i>Kelola Laporan Masuk</h6>
            <p>Verifikasi dan proses laporan dari masyarakat</p>
        </div>
        <span class="badge bg-light text-success fw-bold" style="position:relative;z-index:1;">
            {{ $laporans->total() }} Laporan
        </span>
    </div>
</div>

{{-- STAT MINI --}}
<div class="stat-mini">
    <a href="{{ route('admin.laporan.index') }}"
       class="stat-mini-item {{ !request('status') ? 'active' : '' }}">
        <i class="fas fa-list" style="color:#2E7D32;"></i>
        <span>Semua</span>
        <span class="count">{{ $laporans->total() }}</span>
    </a>
    <a href="{{ route('admin.laporan.index', ['status' => 'menunggu']) }}"
       class="stat-mini-item {{ request('status') == 'menunggu' ? 'active' : '' }}">
        <i class="fas fa-clock" style="color:#F57F17;"></i>
        <span>Menunggu</span>
    </a>
    <a href="{{ route('admin.laporan.index', ['status' => 'diverifikasi']) }}"
       class="stat-mini-item {{ request('status') == 'diverifikasi' ? 'active' : '' }}">
        <i class="fas fa-check" style="color:#1565C0;"></i>
        <span>Diverifikasi</span>
    </a>
    <a href="{{ route('admin.laporan.index', ['status' => 'diproses']) }}"
       class="stat-mini-item {{ request('status') == 'diproses' ? 'active' : '' }}">
        <i class="fas fa-spinner" style="color:#E65100;"></i>
        <span>Diproses</span>
    </a>
    <a href="{{ route('admin.laporan.index', ['status' => 'selesai']) }}"
       class="stat-mini-item {{ request('status') == 'selesai' ? 'active' : '' }}">
        <i class="fas fa-check-circle" style="color:#1B5E20;"></i>
        <span>Selesai</span>
    </a>
    <a href="{{ route('admin.laporan.index', ['status' => 'ditolak']) }}"
       class="stat-mini-item {{ request('status') == 'ditolak' ? 'active' : '' }}">
        <i class="fas fa-times-circle" style="color:#B71C1C;"></i>
        <span>Ditolak</span>
    </a>
</div>

{{-- FILTER --}}
<div class="filter-bar">
    <form method="GET" action="{{ route('admin.laporan.index') }}"
          class="d-flex align-items-center gap-2 flex-wrap w-100">
        <input type="hidden" name="status" value="{{ request('status') }}">
        <span class="small fw-bold text-muted">Cari:</span>
        <input type="text" name="search" class="form-control"
               placeholder="Cari judul laporan..."
               value="{{ request('search') }}">
        <button type="submit" class="btn btn-sm btn-success px-3">
            <i class="fas fa-search"></i>
        </button>
        @if(request('search'))
            <a href="{{ route('admin.laporan.index', ['status' => request('status')]) }}"
               class="btn btn-sm btn-outline-secondary">
                <i class="fas fa-times"></i> Reset
            </a>
        @endif
    </form>
</div>

{{-- TABLE --}}
<div class="table-card">
    <div class="table-responsive">
        <table class="table mb-0">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Pelapor</th>
                    <th>Judul Laporan</th>
                    <th>Kategori</th>
                    <th>Tanggal</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @if($laporans->count() > 0)
                    @foreach($laporans as $i => $laporan)
                        <tr>
                            <td class="text-muted small">{{ $laporans->firstItem() + $i }}</td>
                            <td>
                                @if($laporan->anonim)
                                    <span class="text-muted small"><i class="fas fa-user-secret me-1"></i>Anonim</span>
                                @else
                                    <span class="small fw-bold">{{ $laporan->user->nama ?? '-' }}</span>
                                @endif
                            </td>
                            <td><div class="judul-cell">{{ $laporan->judul_laporan }}</div></td>
                            <td>
                                <span class="small text-muted">
                                    {{ Str::limit($laporan->kategori->nama_kategori ?? '-', 25) }}
                                </span>
                            </td>
                            <td class="small text-muted">
                                {{ \Carbon\Carbon::parse($laporan->created_at)->locale('id')->isoFormat('D MMM Y') }}
                            </td>
                            <td>
                                <span class="status-badge status-{{ $laporan->status }}">
                                    @switch($laporan->status)
                                        @case('menunggu')     <i class="fas fa-clock me-1"></i>Menunggu @break
                                        @case('diverifikasi') <i class="fas fa-check me-1"></i>Diverifikasi @break
                                        @case('diproses')     <i class="fas fa-spinner me-1"></i>Diproses @break
                                        @case('selesai')      <i class="fas fa-check-circle me-1"></i>Selesai @break
                                        @case('ditolak')      <i class="fas fa-times-circle me-1"></i>Ditolak @break
                                    @endswitch
                                </span>
                            </td>
                            <td>
                                <div class="d-flex gap-2">
                                    <a href="{{ route('admin.laporan.show', $laporan->id_laporan) }}" class="btn-detail">
                                        <i class="fas fa-eye me-1"></i>Detail
                                    </a>
                                    <button class="btn-hapus"
                                            onclick="bukaModalHapus({{ $laporan->id_laporan }}, '{{ addslashes($laporan->judul_laporan) }}')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="7">
                            <div class="empty-state">
                                <i class="fas fa-inbox fa-3x mb-3 d-block" style="color:#c8e6c9;"></i>
                                <p class="fw-bold mb-1">Belum ada laporan</p>
                                <small>Laporan dari masyarakat akan muncul di sini</small>
                            </div>
                        </td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>
</div>

@if($laporans->hasPages())
    <div class="d-flex justify-content-center mt-3">{{ $laporans->links() }}</div>
@endif

{{-- CUSTOM MODAL HAPUS LAPORAN --}}
<div class="custom-backdrop" id="backdropLaporan"></div>
<div class="custom-modal-wrap" id="modalHapusLaporanWrap">
    <div class="custom-modal">
        <div class="custom-modal-header">
            <h6><i class="fas fa-trash me-2 text-danger"></i>Hapus Laporan</h6>
            <button class="custom-modal-close" onclick="tutupModalLaporan()">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div class="custom-modal-body">
            <p class="mb-1 small text-muted">Kamu akan menghapus laporan:</p>
            <p class="fw-bold mb-3" id="judulLaporanModal">—</p>
            <div class="alert alert-warning small py-2 mb-0">
                <i class="fas fa-exclamation-triangle me-1"></i>
                Semua data terkait (lampiran, hasil, log status) akan ikut terhapus permanen.
            </div>
        </div>
        <div class="custom-modal-footer">
            <button class="btn-batal" onclick="tutupModalLaporan()">Batal</button>
            <form id="formHapusLaporan" method="POST" style="display:inline;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn-konfirm-hapus">
                    <i class="fas fa-trash"></i> Hapus
                </button>
            </form>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
function bukaModalHapus(id, judul) {
    document.getElementById('judulLaporanModal').textContent = judul;
    document.getElementById('formHapusLaporan').action = '{{ url("admin/laporan") }}/' + id;
    document.getElementById('backdropLaporan').style.display = 'block';
    document.getElementById('modalHapusLaporanWrap').classList.add('show');
}

function tutupModalLaporan() {
    document.getElementById('backdropLaporan').style.display = 'none';
    document.getElementById('modalHapusLaporanWrap').classList.remove('show');
}

document.getElementById('backdropLaporan').addEventListener('click', tutupModalLaporan);
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') tutupModalLaporan();
});
</script>
@endpush
