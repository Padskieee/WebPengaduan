@extends('layouts.admin')

@section('title', 'Dashboard')

@push('styles')
<style>
    /* ── Grid layout ── */
    .stats-grid-4 {
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        gap: 12px;
        margin-bottom: 12px;
    }
    .stats-grid-3 {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 12px;
    }

    @media (max-width: 1024px) {
        .stats-grid-4 { grid-template-columns: repeat(2, minmax(0, 1fr)); }
    }
    @media (max-width: 640px) {
        .stats-grid-4,
        .stats-grid-3 { grid-template-columns: repeat(2, minmax(0, 1fr)); }
    }

    /* ── Section label ── */
    .stats-section-label {
        font-size: 11px;
        font-weight: 500;
        letter-spacing: 0.06em;
        text-transform: uppercase;
        color: #9e9e9e;
        margin: 0 0 10px;
    }

    /* ── Kartu dasar ── */
    .stat-card-new {
        background: #ffffff;
        border: 1px solid #f0f0f0;
        border-radius: 14px;
        padding: 18px 20px 16px;
        display: flex;
        flex-direction: column;
        gap: 6px;
        transition: border-color 0.15s, box-shadow 0.15s;
    }
    .stat-card-new:hover {
        border-color: #e0e0e0;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    }

    /* ── Ikon ── */
    .stat-icon-wrap {
        width: 36px;
        height: 36px;
        border-radius: 9px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 4px;
    }

    /* ── Nilai angka ── */
    .stat-val {
        font-size: 28px;
        font-weight: 600;
        line-height: 1;
    }

    /* ── Label bawah ── */
    .stat-lbl {
        font-size: 12px;
        color: #9e9e9e;
        display: flex;
        align-items: center;
        gap: 6px;
    }
    .stat-dot {
        width: 7px;
        height: 7px;
        border-radius: 50%;
        flex-shrink: 0;
    }

    /* ── Tema warna ── */
    .s-navy .stat-icon-wrap  { background: #E6F1FB; }
    .s-navy .stat-val        { color: #0C447C; }
    .s-navy .stat-dot        { background: #0C447C; }

    .s-amber .stat-icon-wrap { background: #FAEEDA; }
    .s-amber .stat-val       { color: #F57F17; }
    .s-amber .stat-dot       { background: #F57F17; }

    .s-green .stat-icon-wrap { background: #EAF3DE; }
    .s-green .stat-val       { color: #3B6D11; }
    .s-green .stat-dot       { background: #3B6D11; }

    .s-red .stat-icon-wrap   { background: #FCEBEB; }
    .s-red .stat-val         { color: #A32D2D; }
    .s-red .stat-dot         { background: #A32D2D; }

    .s-teal .stat-icon-wrap  { background: #E1F5EE; }
    .s-teal .stat-val        { color: #0F6E56; }
    .s-teal .stat-dot        { background: #0F6E56; }

    .s-orange .stat-icon-wrap { background: #FFF3E0; }
    .s-orange .stat-val       { color: #E65100; }
    .s-orange .stat-dot       { background: #E65100; }

    .s-purple .stat-icon-wrap { background: #EEEDFE; }
    .s-purple .stat-val       { color: #3C3489; }
    .s-purple .stat-dot       { background: #3C3489; }
</style>
@endpush

@section('content')

{{-- GREETING --}}
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h5 class="fw-bold mb-1" style="color:#1B5E20;">
            Selamat Datang, {{ Auth::guard('admin')->user()->nama_admin }}!
        </h5>
        <p class="text-muted mb-0 small">
            <i class="fas fa-calendar-alt me-1"></i>
            {{ \Carbon\Carbon::now()->locale('id')->isoFormat('dddd, D MMMM Y') }}
        </p>
    </div>
</div>

{{-- STATISTIK BARIS 1 --}}
<div class="mb-1">
    <p class="stats-section-label">Statistik laporan</p>
    <div class="stats-grid-4 mb-4">

        <div class="stat-card-new s-navy">
            <div class="stat-icon-wrap">
                <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="#185FA5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414A1 1 0 0119 9.414V19a2 2 0 01-2 2z"/>
                </svg>
            </div>
            <div class="stat-val">{{ $totalLaporan }}</div>
            <div class="stat-lbl"><span class="stat-dot"></span> Total laporan</div>
        </div>

        <div class="stat-card-new s-amber">
            <div class="stat-icon-wrap">
                <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="#F57F17">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div class="stat-val">{{ $menunggu }}</div>
            <div class="stat-lbl"><span class="stat-dot"></span> Menunggu verifikasi</div>
        </div>

        <div class="stat-card-new s-green">
            <div class="stat-icon-wrap">
                <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="#3B6D11">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div class="stat-val">{{ $selesai }}</div>
            <div class="stat-lbl"><span class="stat-dot"></span> Selesai</div>
        </div>

        <div class="stat-card-new s-red">
            <div class="stat-icon-wrap">
                <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="#A32D2D">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div class="stat-val">{{ $ditolak }}</div>
            <div class="stat-lbl"><span class="stat-dot"></span> Ditolak</div>
        </div>

    </div>
</div>

{{-- STATISTIK BARIS 2 --}}
<div class="mb-4">
    <p class="stats-section-label">Status &amp; pengguna</p>
    <div class="stats-grid-3">

        <div class="stat-card-new s-teal">
            <div class="stat-icon-wrap">
                <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="#0F6E56">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                </svg>
            </div>
            <div class="stat-val">{{ $diverifikasi }}</div>
            <div class="stat-lbl"><span class="stat-dot"></span> Diverifikasi</div>
        </div>

        <div class="stat-card-new s-orange">
            <div class="stat-icon-wrap">
                <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="#E65100">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                </svg>
            </div>
            <div class="stat-val">{{ $diproses }}</div>
            <div class="stat-lbl"><span class="stat-dot"></span> Sedang diproses</div>
        </div>

        <div class="stat-card-new s-purple">
            <div class="stat-icon-wrap">
                <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="#534AB7">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
            </div>
            <div class="stat-val">{{ $totalUser }}</div>
            <div class="stat-lbl"><span class="stat-dot"></span> Total user</div>
        </div>

    </div>
</div>

{{-- LAPORAN TERBARU --}}
<div class="card mb-4">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span><i class="fas fa-inbox me-2"></i>Laporan Masuk Terbaru</span>
        <a href="{{ route('admin.laporan.index') }}" class="btn btn-sm btn-outline-light">
            Lihat Semua
        </a>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead style="background:#f5f5f5;">
                    <tr>
                        <th class="ps-3">#</th>
                        <th>Pelapor</th>
                        <th>Judul Laporan</th>
                        <th>Kategori</th>
                        <th>Tanggal</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @if($laporanTerbaru->count() > 0)
                        @foreach($laporanTerbaru as $i => $laporan)
                            <tr>
                                <td class="ps-3 text-muted small">{{ $i + 1 }}</td>
                                <td class="small">
                                    @if($laporan->anonim)
                                        <i class="fas fa-user-secret me-1 text-muted"></i>Anonim
                                    @else
                                        {{ $laporan->user->nama ?? '-' }}
                                    @endif
                                </td>
                                <td class="small fw-600" style="max-width:200px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">
                                    {{ $laporan->judul_laporan }}
                                </td>
                                <td class="small text-muted">
                                    {{ Str::limit($laporan->kategori->nama_kategori ?? '-', 20) }}
                                </td>
                                <td class="small text-muted">
                                    {{ \Carbon\Carbon::parse($laporan->created_at)->locale('id')->isoFormat('D MMM Y') }}
                                </td>
                                <td>
                                    <span class="badge rounded-pill"
                                        style="font-size:0.7rem;
                                        @switch($laporan->status)
                                            @case('menunggu') background:#FFF8E1;color:#F57F17; @break
                                            @case('diverifikasi') background:#E3F2FD;color:#1565C0; @break
                                            @case('diproses') background:#FFF3E0;color:#E65100; @break
                                            @case('selesai') background:#E8F5E9;color:#1B5E20; @break
                                            @case('ditolak') background:#FFEBEE;color:#B71C1C; @break
                                        @endswitch">
                                        {{ ucfirst($laporan->status) }}
                                    </span>
                                </td>
                                <td>
                                    <a href="{{ route('admin.laporan.show', $laporan->id_laporan) }}"
                                       class="btn btn-sm"
                                       style="background:#E8F5E9;color:#1B5E20;font-size:0.75rem;border-radius:6px;">
                                        <i class="fas fa-eye me-1"></i>Detail
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="7" class="text-center py-4 text-muted">
                                <i class="fas fa-inbox fa-2x mb-2 d-block" style="color:#c8e6c9;"></i>
                                Belum ada laporan masuk
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- INFO SINGKAT --}}
<div class="row g-3">
    <div class="col-md-6">
    <div class="card h-100">
        <div class="card-header">
            <i class="fas fa-chart-bar me-2"></i>Ringkasan Status Laporan
        </div>
        <div class="card-body">
            @php $total = $totalLaporan > 0 ? $totalLaporan : 1; @endphp

            <div class="d-flex justify-content-between align-items-center mb-2">
                <span class="small">Menunggu</span>
                <div class="progress flex-grow-1 mx-3" style="height:8px;">
                    <div class="progress-bar bg-warning"
                         style="width:{{ ($menunggu/$total)*100 }}%"></div>
                </div>
                <span class="small fw-bold">{{ $menunggu }}</span>
            </div>
            <div class="d-flex justify-content-between align-items-center mb-2">
                <span class="small">Diverifikasi</span>
                <div class="progress flex-grow-1 mx-3" style="height:8px;">
                    <div class="progress-bar bg-info"
                         style="width:{{ ($diverifikasi/$total)*100 }}%"></div>
                </div>
                <span class="small fw-bold">{{ $diverifikasi }}</span>
            </div>
            <div class="d-flex justify-content-between align-items-center mb-2">
                <span class="small">Diproses</span>
                <div class="progress flex-grow-1 mx-3" style="height:8px;">
                    <div class="progress-bar"
                         style="width:{{ ($diproses/$total)*100 }}%;background:#E65100;"></div>
                </div>
                <span class="small fw-bold">{{ $diproses }}</span>
            </div>
            <div class="d-flex justify-content-between align-items-center mb-2">
                <span class="small">Selesai</span>
                <div class="progress flex-grow-1 mx-3" style="height:8px;">
                    <div class="progress-bar bg-success"
                         style="width:{{ ($selesai/$total)*100 }}%"></div>
                </div>
                <span class="small fw-bold">{{ $selesai }}</span>
            </div>
            <div class="d-flex justify-content-between align-items-center">
                <span class="small">Ditolak</span>
                <div class="progress flex-grow-1 mx-3" style="height:8px;">
                    <div class="progress-bar bg-danger"
                         style="width:{{ ($ditolak/$total)*100 }}%"></div>
                </div>
                <span class="small fw-bold">{{ $ditolak }}</span>
            </div>
        </div>
    </div>
</div>

@endsection
