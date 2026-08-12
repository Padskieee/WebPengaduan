@extends('layouts.admin')

@section('title', 'Hasil Penyelesaian')

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
        max-width: 200px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        font-weight: 600;
    }

    .publish-badge {
        font-size: 0.72rem;
        font-weight: 600;
        padding: 0.3rem 0.75rem;
        border-radius: 20px;
    }

    .publish-draft   { background:#f5f5f5; color:#757575; }
    .publish-publish { background:#E8F5E9; color:#1B5E20; }

    .btn-action {
        font-size: 0.75rem;
        font-weight: 600;
        padding: 0.3rem 0.75rem;
        border-radius: 6px;
        border: none;
        cursor: pointer;
        text-decoration: none;
        transition: all 0.2s;
    }

    .btn-detail {
        background: #E8F5E9;
        color: #1B5E20;
    }

    .btn-detail:hover { background: #1B5E20; color: white; }

    .btn-publish {
        background: #E3F2FD;
        color: #1565C0;
    }

    .btn-publish:hover { background: #1565C0; color: white; }

    .empty-state {
        text-align: center;
        padding: 3rem;
        color: #9e9e9e;
    }

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
</style>

@section('content')

{{-- PAGE HEADER --}}
<div class="page-header">
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h6><i class="fas fa-check-double me-2"></i>Hasil Penyelesaian</h6>
            <p>Kelola hasil penyelesaian laporan masyarakat</p>
        </div>
        <span class="badge bg-light text-success fw-600">
            {{ $hasils->total() }} Hasil
        </span>
    </div>
</div>

{{-- TABLE --}}
<div class="table-card">
    <div class="table-responsive">
        <table class="table mb-0">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Judul Hasil</th>
                    <th>Laporan</th>
                    <th>Admin</th>
                    <th>Tgl Publish</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @if($hasils->count() > 0)
                    @foreach($hasils as $i => $hasil)
                        <tr>
                            <td class="text-muted small">
                                {{ $hasils->firstItem() + $i }}
                            </td>
                            <td>
                                <div class="judul-cell">{{ $hasil->judul_output }}</div>
                            </td>
                            <td>
                                <div class="small" style="max-width:150px; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;">
                                    {{ $hasil->laporan->judul_laporan ?? '-' }}
                                </div>
                            </td>
                            <td class="small">{{ $hasil->admin->nama_admin ?? '-' }}</td>
                            <td class="small text-muted">
                                {{ $hasil->tanggal_publish
                                    ? \Carbon\Carbon::parse($hasil->tanggal_publish)->locale('id')->isoFormat('D MMM Y')
                                    : '-' }}
                            </td>
                            <td>
                                <span class="publish-badge publish-{{ $hasil->status_publish }}">
                                    @if($hasil->status_publish == 'publish')
                                        <i class="fas fa-globe me-1"></i>Publish
                                    @else
                                        <i class="fas fa-file me-1"></i>Draft
                                    @endif
                                </span>
                            </td>
                            <td>
                                <div class="d-flex gap-1">
                                    <a href="{{ route('admin.hasil.show', $hasil->id_hasil) }}"
                                       class="btn-action btn-detail">
                                        <i class="fas fa-eye me-1"></i>Detail
                                    </a>
                                    <form action="{{ route('admin.hasil.publish', $hasil->id_hasil) }}"
                                          method="POST">
                                        @csrf
                                        <button type="submit" class="btn-action btn-publish">
                                            @if($hasil->status_publish == 'draft')
                                                <i class="fas fa-globe me-1"></i>Publish
                                            @else
                                                <i class="fas fa-eye-slash me-1"></i>Unpublish
                                            @endif
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="7">
                            <div class="empty-state">
                                <i class="fas fa-check-double fa-3x mb-3 d-block" style="color:#c8e6c9;"></i>
                                <p class="fw-600 mb-1">Belum ada hasil penyelesaian</p>
                                <small>Hasil penyelesaian akan muncul setelah laporan diproses</small>
                            </div>
                        </td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>
</div>

@if($hasils->count() > 0)
    <div class="d-flex justify-content-center mt-3">
        {{ $hasils->links() }}
    </div>
@endif

@endsection
