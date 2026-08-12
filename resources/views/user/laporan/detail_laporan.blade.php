@extends('layouts.user')

@section('title', 'Detail Laporan')

@section('styles')
<style>
    .detail-card {
        background: rgba(255,255,255,0.97);
        border-radius: 14px;
        box-shadow: 0 2px 12px rgba(0,0,0,0.1);
        overflow: hidden;
        margin-bottom: 1.2rem;
    }

    .detail-card-header {
        background: linear-gradient(135deg, #1B5E20, #2E7D32);
        padding: 1rem 1.3rem;
        color: white;
        font-weight: 600;
        font-size: 0.9rem;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .detail-card-body { padding: 1.3rem; }

    .detail-row {
        display: flex;
        gap: 1rem;
        margin-bottom: 1rem;
        padding-bottom: 1rem;
        border-bottom: 1px solid #f5f5f5;
    }

    .detail-row:last-child {
        margin-bottom: 0;
        padding-bottom: 0;
        border-bottom: none;
    }

    .detail-label {
        font-size: 0.8rem;
        font-weight: 600;
        color: #9e9e9e;
        min-width: 130px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .detail-value {
        font-size: 0.88rem;
        color: #212121;
        flex: 1;
    }

    /* STATUS BADGE */
    .status-badge {
        font-size: 0.78rem;
        font-weight: 600;
        padding: 0.35rem 0.9rem;
        border-radius: 20px;
    }

    .status-menunggu     { background:#FFF8E1; color:#F57F17; }
    .status-diverifikasi { background:#E3F2FD; color:#1565C0; }
    .status-diproses     { background:#FFF3E0; color:#E65100; }
    .status-selesai      { background:#E8F5E9; color:#1B5E20; }
    .status-ditolak      { background:#FFEBEE; color:#B71C1C; }

    /* TIMELINE LOG */
    .timeline { position: relative; padding-left: 1.5rem; }

    .timeline::before {
        content: '';
        position: absolute;
        left: 7px;
        top: 0;
        bottom: 0;
        width: 2px;
        background: #e0e0e0;
    }

    .timeline-item {
        position: relative;
        margin-bottom: 1.2rem;
    }

    .timeline-item:last-child { margin-bottom: 0; }

    .timeline-dot {
        position: absolute;
        left: -1.5rem;
        top: 4px;
        width: 16px;
        height: 16px;
        border-radius: 50%;
        background: #2E7D32;
        border: 3px solid white;
        box-shadow: 0 0 0 2px #2E7D32;
    }

    .timeline-content {
        background: #f9f9f9;
        border-radius: 10px;
        padding: 0.75rem 1rem;
    }

    .timeline-status {
        font-size: 0.82rem;
        font-weight: 700;
        color: #1B5E20;
        margin-bottom: 0.25rem;
    }

    .timeline-keterangan {
        font-size: 0.8rem;
        color: #616161;
        margin-bottom: 0.25rem;
    }

    .timeline-time {
        font-size: 0.72rem;
        color: #9e9e9e;
    }

    /* LAMPIRAN */
    .lampiran-item {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        padding: 0.6rem 0.9rem;
        background: #f9f9f9;
        border-radius: 8px;
        margin-bottom: 0.5rem;
        text-decoration: none;
        color: #212121;
        transition: all 0.2s;
    }

    .lampiran-item:hover {
        background: #E8F5E9;
        color: #1B5E20;
    }

    .lampiran-icon {
        width: 36px;
        height: 36px;
        border-radius: 8px;
        background: #E8F5E9;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #2E7D32;
        flex-shrink: 0;
    }
</style>
@endsection

@section('content')

<div class="row">
    <div class="col-lg-8">

        {{-- BACK + TITLE --}}
        <div class="d-flex align-items-center gap-2 mb-3">
            <a href="{{ route('user.laporan.index') }}" class="text-white opacity-75 text-decoration-none">
                <i class="fas fa-arrow-left"></i>
            </a>
            <h6 class="text-white fw-bold mb-0">Detail Laporan</h6>
        </div>

        {{-- INFO LAPORAN --}}
        <div class="detail-card">
            <div class="detail-card-header">
                <i class="fas fa-file-alt"></i> Informasi Laporan
                <span class="ms-auto status-badge status-{{ $laporan->status }}">
                    {{ ucfirst($laporan->status) }}
                </span>
            </div>
            <div class="detail-card-body">
                <div class="detail-row">
                    <span class="detail-label">Judul</span>
                    <span class="detail-value fw-600">{{ $laporan->judul_laporan }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Kategori</span>
                    <span class="detail-value">{{ $laporan->kategori->nama_kategori ?? '-' }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Isi Laporan</span>
                    <span class="detail-value" style="white-space:pre-line;">{{ $laporan->isi_laporan }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Tanggal Kejadian</span>
                    <span class="detail-value">
                        {{ $laporan->tanggal_kejadian
                            ? \Carbon\Carbon::parse($laporan->tanggal_kejadian)->locale('id')->isoFormat('D MMMM Y')
                            : '-' }}
                    </span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Lokasi</span>
                    <span class="detail-value">{{ $laporan->lokasi_kejadian ?? '-' }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Identitas</span>
                    <span class="detail-value">
                        @if($laporan->anonim)
                            <i class="fas fa-user-secret me-1"></i>Anonim
                        @else
                            <i class="fas fa-user me-1"></i>{{ Auth::guard('web')->user()->nama }}
                        @endif
                    </span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Tanggal Kirim</span>
                    <span class="detail-value">
                        {{ \Carbon\Carbon::parse($laporan->created_at)->locale('id')->isoFormat('D MMMM Y, HH:mm') }}
                    </span>
                </div>
            </div>
        </div>

        {{-- LAMPIRAN --}}
        @if($laporan->lampiran->count() > 0)
            <div class="detail-card">
                <div class="detail-card-header">
                    <i class="fas fa-paperclip"></i> Lampiran ({{ $laporan->lampiran->count() }})
                </div>
                <div class="detail-card-body">
                    @foreach($laporan->lampiran as $lamp)
                        <a href="{{ Storage::url($lamp->file_path) }}"
                           target="_blank" class="lampiran-item">
                            <div class="lampiran-icon">
                                @if($lamp->tipe_file == 'foto')
                                    <i class="fas fa-image"></i>
                                @elseif($lamp->tipe_file == 'video')
                                    <i class="fas fa-video"></i>
                                @else
                                    <i class="fas fa-file-pdf"></i>
                                @endif
                            </div>
                            <div>
                                <div class="small fw-600">{{ basename($lamp->file_path) }}</div>
                                <div class="small text-muted">{{ ucfirst($lamp->tipe_file) }}</div>
                            </div>
                            <i class="fas fa-external-link-alt ms-auto text-muted small"></i>
                        </a>
                    @endforeach
                </div>
            </div>
        @endif

    </div>

    <div class="col-lg-4">

        {{-- TIMELINE LOG STATUS --}}
        <div class="detail-card">
            <div class="detail-card-header">
                <i class="fas fa-history"></i> Riwayat Status
            </div>
            <div class="detail-card-body">
                @if($laporan->logStatus->count() > 0)
                    <div class="timeline">
                        @foreach($laporan->logStatus->sortByDesc('tanggal_update') as $log)
                            <div class="timeline-item">
                                <div class="timeline-dot"></div>
                                <div class="timeline-content">
                                    <div class="timeline-status">
                                        {{ ucfirst($log->status) }}
                                    </div>
                                    @if($log->keterangan)
                                        <div class="timeline-keterangan">
                                            {{ $log->keterangan }}
                                        </div>
                                    @endif
                                    <div class="timeline-time">
                                        <i class="fas fa-clock me-1"></i>
                                        {{ \Carbon\Carbon::parse($log->tanggal_update)->locale('id')->isoFormat('D MMM Y, HH:mm') }}
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center text-muted py-3">
                        <i class="fas fa-history fa-2x mb-2 d-block" style="color:#c8e6c9;"></i>
                        <small>Belum ada riwayat status</small>
                    </div>
                @endif
            </div>
        </div>

        {{-- HASIL PENYELESAIAN --}}
        @if($laporan->hasilLaporan->count() > 0)
            @foreach($laporan->hasilLaporan as $hasil)
                @if($hasil->status_publish == 'publish')
                    <div class="detail-card">
                        <div class="detail-card-header">
                            <i class="fas fa-check-circle"></i> Hasil Penyelesaian
                        </div>
                        <div class="detail-card-body">
                            <div class="fw-700 mb-2">{{ $hasil->judul_output }}</div>
                            <p class="small text-muted mb-2" style="white-space:pre-line;">
                                {{ $hasil->deskripsi_output }}
                            </p>
                            <small class="text-muted">
                                <i class="fas fa-calendar-alt me-1"></i>
                                {{ \Carbon\Carbon::parse($hasil->tanggal_publish)->locale('id')->isoFormat('D MMM Y') }}
                            </small>
                        </div>
                    </div>
                @endif
            @endforeach
        @endif

    </div>
</div>

@endsection
