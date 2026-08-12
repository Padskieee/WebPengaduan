@extends('layouts.user')

@section('title', 'Riwayat Laporan')

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
        right: -30px;
        bottom: -30px;
        width: 150px;
        height: 150px;
        background: rgba(255,255,255,0.06);
        border-radius: 50%;
    }

    .page-header h6 {
        font-weight: 700;
        font-size: 1rem;
        margin: 0;
        position: relative;
        z-index: 1;
    }

    .page-header p {
        font-size: 0.8rem;
        opacity: 0.8;
        margin: 0;
        position: relative;
        z-index: 1;
    }

    /* FILTER BAR */
    .filter-bar {
        background: rgba(255,255,255,0.97);
        border-radius: 12px;
        padding: 1rem 1.2rem;
        margin-bottom: 1.2rem;
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
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

    /* LAPORAN CARD */
    .laporan-card {
        background: rgba(255,255,255,0.97);
        border-radius: 14px;
        margin-bottom: 1rem;
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        overflow: hidden;
        transition: all 0.2s;
    }

    .laporan-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(0,0,0,0.12);
    }

    .laporan-card-body {
        padding: 1.1rem 1.3rem;
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .laporan-number {
        width: 40px;
        height: 40px;
        border-radius: 10px;
        background: #E8F5E9;
        color: #1B5E20;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 0.9rem;
        flex-shrink: 0;
    }

    .laporan-info { flex: 1; min-width: 0; }

    .laporan-judul {
        font-weight: 700;
        font-size: 0.92rem;
        color: #212121;
        margin-bottom: 0.3rem;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .laporan-meta {
        display: flex;
        align-items: center;
        gap: 1rem;
        flex-wrap: wrap;
    }

    .laporan-meta span {
        font-size: 0.75rem;
        color: #9e9e9e;
        display: flex;
        align-items: center;
        gap: 4px;
    }

    .laporan-actions {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        flex-shrink: 0;
    }

    /* STATUS BADGE */
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
        padding: 0.4rem 0.9rem;
        font-size: 0.8rem;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.2s;
        white-space: nowrap;
    }

    .btn-detail:hover {
        background: #1B5E20;
        color: white;
    }

    /* EMPTY STATE */
    .empty-state {
        background: rgba(255,255,255,0.97);
        border-radius: 14px;
        padding: 3rem;
        text-align: center;
        color: #9e9e9e;
    }

    /* PAGINATION */
    .pagination .page-link {
        border-radius: 8px !important;
        margin: 0 2px;
        border: 1.5px solid #e0e0e0;
        color: #2E7D32;
        font-size: 0.85rem;
    }

    .pagination .page-item.active .page-link {
        background-color: #2E7D32;
        border-color: #2E7D32;
        color: white;
    }

    .pagination .page-link:hover {
        background-color: #E8F5E9;
        border-color: #2E7D32;
        color: #1B5E20;
    }

    /* RESPONSIVE LAPORAN CARD */
@media (max-width: 768px) {
    .laporan-card-body {
        flex-wrap: wrap;
        gap: 0.75rem;
    }

    .laporan-info {
        width: 100%;
        min-width: 0;
    }

    .laporan-judul {
        white-space: normal;
        font-size: 0.88rem;
    }

    .laporan-actions {
        width: 100%;
        justify-content: space-between;
    }

    .filter-bar {
        flex-direction: column;
        align-items: stretch !important;
        gap: 0.5rem !important;
    }

    .filter-bar form {
        flex-direction: column !important;
        gap: 0.5rem !important;
    }

    .filter-bar .form-select,
    .filter-bar .form-control {
        max-width: 100% !important;
        width: 100% !important;
    }

    .filter-bar .ms-auto {
        margin-left: 0 !important;
    }
    }

</style>
@endsection

@section('content')

{{-- PAGE HEADER --}}
<div class="page-header">
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h6><i class="fas fa-list me-2"></i>Riwayat Laporan Saya</h6>
            <p>Pantau status dan perkembangan laporan yang telah anda kirim</p>
        </div>
        <a href="{{ route('user.laporan.create') }}" class="btn btn-sm btn-light fw-600">
            <i class="fas fa-plus me-1"></i> Buat Laporan
        </a>
    </div>
</div>

{{-- FILTER --}}
<div class="filter-bar">
    <span class="small fw-600 text-muted">Filter:</span>
    <form method="GET" action="{{ route('user.laporan.index') }}"
          class="d-flex align-items-center gap-2 flex-wrap">
        <select name="status" class="form-select" onchange="this.form.submit()">
            <option value="">Semua Status</option>
            <option value="menunggu"     {{ request('status') == 'menunggu'     ? 'selected' : '' }}>Menunggu</option>
            <option value="diverifikasi" {{ request('status') == 'diverifikasi' ? 'selected' : '' }}>Diverifikasi</option>
            <option value="diproses"     {{ request('status') == 'diproses'     ? 'selected' : '' }}>Diproses</option>
            <option value="selesai"      {{ request('status') == 'selesai'      ? 'selected' : '' }}>Selesai</option>
            <option value="ditolak"      {{ request('status') == 'ditolak'      ? 'selected' : '' }}>Ditolak</option>
        </select>
        <input type="text" name="search" class="form-control"
               placeholder="Cari judul laporan..."
               value="{{ request('search') }}">
        <button type="submit" class="btn btn-sm btn-success px-3">
            <i class="fas fa-search"></i>
        </button>
        @if(request('status') || request('search'))
            <a href="{{ route('user.laporan.index') }}" class="btn btn-sm btn-outline-secondary">
                <i class="fas fa-times"></i> Reset
            </a>
        @endif
    </form>
    <span class="ms-auto small text-muted">
        Total: <strong>{{ $laporans->total() }}</strong> laporan
    </span>
</div>

{{-- LIST LAPORAN --}}
@if($laporans->count() > 0)
    @foreach($laporans as $i => $laporan)
        <div class="laporan-card">
            <div class="laporan-card-body">
                <div class="laporan-number">
                    {{ $laporans->firstItem() + $i }}
                </div>
                <div class="laporan-info">
                    <div class="laporan-judul">{{ $laporan->judul_laporan }}</div>
                    <div class="laporan-meta">
                        <span>
                            <i class="fas fa-tag"></i>
                            {{ $laporan->kategori->nama_kategori ?? '-' }}
                        </span>
                        <span>
                            <i class="fas fa-calendar-alt"></i>
                            {{ \Carbon\Carbon::parse($laporan->created_at)->locale('id')->isoFormat('D MMM Y') }}
                        </span>
                        @if($laporan->lokasi_kejadian)
                            <span>
                                <i class="fas fa-map-marker-alt"></i>
                                {{ Str::limit($laporan->lokasi_kejadian, 30) }}
                            </span>
                        @endif
                    </div>
                </div>
                <div class="laporan-actions">
                    <span class="status-badge status-{{ $laporan->status }}">
                        @switch($laporan->status)
                            @case('menunggu')
                                <i class="fas fa-clock me-1"></i>Menunggu
                                @break
                            @case('diverifikasi')
                                <i class="fas fa-check me-1"></i>Diverifikasi
                                @break
                            @case('diproses')
                                <i class="fas fa-spinner me-1"></i>Diproses
                                @break
                            @case('selesai')
                                <i class="fas fa-check-circle me-1"></i>Selesai
                                @break
                            @case('ditolak')
                                <i class="fas fa-times-circle me-1"></i>Ditolak
                                @break
                        @endswitch
                    </span>
                    <a href="{{ route('user.laporan.show', $laporan->id_laporan) }}"
                       class="btn-detail">
                        <i class="fas fa-eye me-1"></i>Detail
                    </a>
                </div>
            </div>
        </div>
    @endforeach

    {{-- PAGINATION --}}
    <div class="d-flex justify-content-center mt-3">
        {{ $laporans->links() }}
    </div>

@else
    <div class="empty-state">
        <i class="fas fa-inbox fa-3x mb-3 d-block" style="color:#c8e6c9;"></i>
        <p class="fw-600 mb-1">Belum ada laporan</p>
        <small class="d-block mb-3">Anda belum pernah membuat laporan</small>
        <a href="{{ route('user.laporan.create') }}" class="btn btn-success btn-sm px-4">
            <i class="fas fa-plus me-1"></i> Buat Laporan Pertama
        </a>
    </div>
@endif

@endsection
