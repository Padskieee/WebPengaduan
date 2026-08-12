@extends('layouts.admin')

@section('title', 'Detail User')

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

    /* PROFILE CARD */
    .profile-card {
        background: white;
        border-radius: 14px;
        box-shadow: 0 2px 8px rgba(0,0,0,.06);
        padding: 1.75rem;
        margin-bottom: 1.2rem;
        display: flex;
        align-items: center;
        gap: 1.5rem;
    }
    .profile-avatar {
        width: 72px; height: 72px;
        border-radius: 50%;
        background: linear-gradient(135deg, #1B5E20, #2E7D32);
        display: flex; align-items: center; justify-content: center;
        color: white;
        font-weight: 700;
        font-size: 1.8rem;
        flex-shrink: 0;
    }
    .profile-nama  { font-size: 1.1rem; font-weight: 700; color: #212121; margin-bottom: 4px; }
    .profile-email { font-size: 0.85rem; color: #9e9e9e; }

    /* INFO GRID */
    .info-grid {
        display: grid;
        grid-template-columns: repeat(3, minmax(0,1fr));
        gap: 12px;
        margin-bottom: 1.2rem;
    }
    .info-card {
        background: white;
        border: 1px solid #f0f0f0;
        border-radius: 12px;
        padding: 14px 18px;
    }
    .info-label { font-size: 11px; font-weight: 600; text-transform: uppercase; letter-spacing: .05em; color: #9e9e9e; margin-bottom: 4px; }
    .info-value { font-size: 0.9rem; font-weight: 600; color: #212121; }

    /* LAPORAN TABLE */
    .table-card {
        background: white;
        border-radius: 14px;
        box-shadow: 0 2px 8px rgba(0,0,0,.06);
        overflow: hidden;
    }
    .table-card-header {
        padding: 1rem 1.2rem;
        border-bottom: 1px solid #f5f5f5;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }
    .table-card-header h6 { font-weight: 700; font-size: 0.9rem; margin: 0; color: #212121; }

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

    .btn-detail-sm {
    background: #E8F5E9;
    color: #1B5E20;
    border: none;
    border-radius: 7px;
    padding: 0.28rem 0.75rem;
    font-size: 0.78rem;
    font-weight: 600;
    text-decoration: none;
    transition: all .2s;
    display: inline-flex;
    align-items: center;
    gap: 4px;
    }
    .btn-detail-sm:hover { background: #1B5E20; color: white; }
    .empty-state { text-align: center; padding: 2.5rem; color: #9e9e9e; }

    .pagination .page-link {
        border-radius: 8px !important;
        margin: 0 2px;
        border: 1.5px solid #e0e0e0;
        color: #2E7D32;
        font-size: 0.85rem;
    }
    .pagination .page-item.active .page-link { background-color: #2E7D32; border-color: #2E7D32; color: white; }
    .pagination .page-link:hover { background-color: #E8F5E9; border-color: #2E7D32; color: #1B5E20; }

    .btn-kembali {
        color: rgba(255,255,255,.8);
        font-size: 0.82rem;
        text-decoration: none;
        position: relative;
        z-index: 1;
        display: flex;
        align-items: center;
        gap: 5px;
        transition: color .15s;
    }
    .btn-kembali:hover { color: white; }
</style>
@endpush

@section('content')

{{-- PAGE HEADER --}}
<div class="page-header">
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h6><i class="fas fa-user me-2"></i>Detail User</h6>
            <p>Informasi lengkap dan riwayat laporan user</p>
        </div>
        <a href="{{ route('admin.user.index') }}" class="btn-kembali">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>
</div>

{{-- PROFILE CARD --}}
<div class="profile-card">
    <div class="profile-avatar">
        {{ strtoupper(substr($user->nama, 0, 1)) }}
    </div>
    <div>
        <div class="profile-nama">{{ $user->nama }}</div>
        <div class="profile-email">{{ $user->email }}</div>
    </div>
    <div class="ms-auto text-end">
        <div style="font-size:11px;text-transform:uppercase;letter-spacing:.05em;color:#9e9e9e;margin-bottom:4px;">Total Laporan</div>
        <div style="font-size:2rem;font-weight:700;color:#1B5E20;line-height:1;">{{ $user->laporan_count }}</div>
    </div>
</div>

{{-- INFO GRID --}}
<div class="info-grid">
    <div class="info-card">
        <div class="info-label"><i class="fas fa-phone me-1"></i>No. HP</div>
        <div class="info-value">{{ $user->no_hp ?? '—' }}</div>
    </div>
    <div class="info-card">
        <div class="info-label"><i class="fas fa-calendar-alt me-1"></i>Terdaftar</div>
        <div class="info-value">
            {{ \Carbon\Carbon::parse($user->created_at)->locale('id')->isoFormat('D MMMM Y') }}
        </div>
    </div>
    <div class="info-card">
        <div class="info-label"><i class="fas fa-clock me-1"></i>Terakhir Update</div>
        <div class="info-value">
            {{ \Carbon\Carbon::parse($user->updated_at)->locale('id')->diffForHumans() }}
        </div>
    </div>
</div>

{{-- TABEL LAPORAN --}}
<div class="table-card">
    <div class="table-card-header">
        <h6><i class="fas fa-file-alt me-2" style="color:#2E7D32;"></i>Riwayat Laporan</h6>
        <span style="font-size:0.8rem;color:#9e9e9e;">{{ $user->laporan_count }} laporan</span>
    </div>
    <div class="table-responsive">
        <table class="table mb-0">
            <thead>
                <tr>
                    <th style="width:50px">#</th>
                    <th>Judul Laporan</th>
                    <th>Kategori</th>
                    <th style="width:120px">Tanggal</th>
                    <th style="width:130px">Status</th>
                    <th style="width:90px">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @if($laporans->count() > 0)
                    @foreach($laporans as $i => $laporan)
                        <tr>
                            <td class="text-muted small">{{ $laporans->firstItem() + $i }}</td>
                            <td>
                                <div class="judul-cell">
                                    @if($laporan->anonim)
                                        <i class="fas fa-user-secret me-1 text-muted"></i>
                                    @endif
                                    {{ $laporan->judul_laporan }}
                                </div>
                            </td>
                            <td class="small text-muted">
                                {{ $laporan->kategori->nama_kategori ?? '—' }}
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
                                <a href="{{ route('admin.laporan.show', $laporan->id_laporan) }}"
                                   class="btn-detail-sm">
                                    <i class="fas fa-eye me-1"></i>Lihat
                                </a>
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="6">
                            <div class="empty-state">
                                <i class="fas fa-file-alt fa-2x mb-2 d-block" style="color:#c8e6c9;"></i>
                                <p class="fw-bold mb-1">Belum ada laporan</p>
                                <small>User ini belum pernah membuat laporan</small>
                            </div>
                        </td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>
</div>

{{-- PAGINATION --}}
@if($laporans->hasPages())
    <div class="d-flex justify-content-center mt-3">
        {{ $laporans->onEachSide(1)->links() }}
    </div>
@endif

@endsection
