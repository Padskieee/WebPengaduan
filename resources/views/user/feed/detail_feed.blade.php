@extends('layouts.user')

@section('title', 'Detail Feed')

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

    .hasil-judul {
        font-size: 1.2rem;
        font-weight: 700;
        color: #1B5E20;
        margin-bottom: 0.5rem;
        line-height: 1.4;
    }

    .hasil-deskripsi {
        font-size: 0.9rem;
        color: #424242;
        line-height: 1.8;
        white-space: pre-line;
    }

    .info-row {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-size: 0.8rem;
        color: #9e9e9e;
        margin-bottom: 0.5rem;
    }

    .info-row i { width: 16px; color: #2E7D32; }

    /* LAMPIRAN */
    .lampiran-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(120px, 1fr));
        gap: 0.75rem;
    }

    .lampiran-foto {
        border-radius: 10px;
        overflow: hidden;
        aspect-ratio: 1;
        background: #f5f5f5;
        cursor: pointer;
        transition: transform 0.2s;
    }

    .lampiran-foto:hover { transform: scale(1.03); }

    .lampiran-foto img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .lampiran-file {
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

    .lampiran-file:hover {
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
    }

    .jenis-badge {
        font-size: 0.7rem;
        padding: 0.2rem 0.6rem;
        border-radius: 20px;
        font-weight: 600;
    }

    .jenis-sebelum { background:#FFF3E0; color:#E65100; }
    .jenis-sesudah { background:#E8F5E9; color:#1B5E20; }
    .jenis-lainnya { background:#F3E5F5; color:#6A1B9A; }

    .laporan-info-row {
        display: flex;
        gap: 1rem;
        padding: 0.75rem 0;
        border-bottom: 1px solid #f5f5f5;
        font-size: 0.85rem;
    }

    .laporan-info-row:last-child { border-bottom: none; }

    .laporan-info-label {
        color: #9e9e9e;
        font-weight: 600;
        min-width: 120px;
        font-size: 0.78rem;
        text-transform: uppercase;
    }

    .laporan-info-value { color: #212121; flex: 1; }
</style>
@endsection

@section('content')

<div class="row">
    <div class="col-lg-8">

        <div class="d-flex align-items-center gap-2 mb-3">
            <a href="{{ route('user.feed.index') }}" class="text-white opacity-75 text-decoration-none">
                <i class="fas fa-arrow-left"></i>
            </a>
            <h6 class="text-white fw-bold mb-0">Detail Hasil Penyelesaian</h6>
        </div>

        <div class="detail-card">
            <div class="detail-card-header">
                <i class="fas fa-check-circle"></i> Hasil Penyelesaian
                <span class="ms-auto badge bg-light text-success">
                    <i class="fas fa-globe me-1"></i>Dipublikasikan
                </span>
            </div>
            <div class="detail-card-body">
                <div class="hasil-judul">{{ $feed->judul_output }}</div>

                <div class="d-flex gap-3 mb-3 flex-wrap">
                    <div class="info-row">
                        <i class="fas fa-user-shield"></i>
                        Oleh: {{ $feed->admin->nama_admin ?? 'Admin' }}
                    </div>
                    <div class="info-row">
                        <i class="fas fa-calendar-alt"></i>
                        {{ \Carbon\Carbon::parse($feed->tanggal_publish)->locale('id')->isoFormat('D MMMM Y') }}
                    </div>
                </div>

                <hr style="border-color:#f0f0f0;">

                <div class="hasil-deskripsi">{{ $feed->deskripsi_output }}</div>
            </div>
        </div>

        @if($feed->lampiranHasil->count() > 0)
            <div class="detail-card">
                <div class="detail-card-header">
                    <i class="fas fa-images"></i> Lampiran Hasil
                    ({{ $feed->lampiranHasil->count() }})
                </div>
                <div class="detail-card-body">

                    @php $fotos = $feed->lampiranHasil->where('tipe_file', 'foto'); @endphp
                    @if($fotos->count() > 0)
                        <p class="small fw-600 text-muted mb-2">Foto</p>
                        <div class="lampiran-grid mb-3">
                            @foreach($fotos as $lamp)
                                <a href="{{ Storage::url($lamp->file_path) }}"
                                   target="_blank" class="lampiran-foto">
                                    <img src="{{ Storage::url($lamp->file_path) }}"
                                         alt="Lampiran">
                                </a>
                            @endforeach
                        </div>
                    @endif

                    @foreach($feed->lampiranHasil->whereNotIn('tipe_file', ['foto']) as $lamp)
                        <a href="{{ Storage::url($lamp->file_path) }}"
                           target="_blank" class="lampiran-file">
                            <div class="lampiran-icon">
                                @if($lamp->tipe_file == 'video')
                                    <i class="fas fa-video"></i>
                                @else
                                    <i class="fas fa-file-pdf"></i>
                                @endif
                            </div>
                            <div class="flex-1">
                                <div class="small fw-600">{{ basename($lamp->file_path) }}</div>
                                <div class="small text-muted">{{ ucfirst($lamp->tipe_file) }}</div>
                            </div>
                            <span class="jenis-badge jenis-{{ $lamp->jenis_lampiran }}">
                                {{ ucfirst($lamp->jenis_lampiran) }}
                            </span>
                        </a>
                    @endforeach

                </div>
            </div>
        @endif

    </div>

    <div class="col-lg-4">

        <div class="detail-card">
            <div class="detail-card-header">
                <i class="fas fa-file-alt"></i> Info Laporan
            </div>
            <div class="detail-card-body">
                <div class="laporan-info-row">
                    <span class="laporan-info-label">Judul</span>
                    <span class="laporan-info-value fw-600">
                        {{ $feed->laporan->judul_laporan }}
                    </span>
                </div>
                <div class="laporan-info-row">
                    <span class="laporan-info-label">Pelapor</span>
                    <span class="laporan-info-value">
                        @if($feed->laporan->anonim)
                            <i class="fas fa-user-secret me-1"></i>Anonim
                        @else
                            {{ $feed->laporan->user->nama ?? '-' }}
                        @endif
                    </span>
                </div>
                <div class="laporan-info-row">
                    <span class="laporan-info-label">Kategori</span>
                    <span class="laporan-info-value">
                        {{ $feed->laporan->kategori->nama_kategori ?? '-' }}
                    </span>
                </div>
                <div class="laporan-info-row">
                    <span class="laporan-info-label">Lokasi</span>
                    <span class="laporan-info-value">
                        {{ $feed->laporan->lokasi_kejadian ?? '-' }}
                    </span>
                </div>
                <div class="laporan-info-row">
                    <span class="laporan-info-label">Isi Laporan</span>
                    <span class="laporan-info-value" style="white-space:pre-line;">
                        {{ $feed->laporan->isi_laporan }}
                    </span>
                </div>
                <div class="laporan-info-row">
                    <span class="laporan-info-label">Tgl Kejadian</span>
                    <span class="laporan-info-value">
                        {{ $feed->laporan->tanggal_kejadian
                            ? \Carbon\Carbon::parse($feed->laporan->tanggal_kejadian)->locale('id')->isoFormat('D MMMM Y')
                            : '-' }}
                    </span>
                </div>
                <div class="laporan-info-row">
                    <span class="laporan-info-label">Tgl Laporan</span>
                    <span class="laporan-info-value">
                        {{ \Carbon\Carbon::parse($feed->laporan->created_at)->locale('id')->isoFormat('D MMM Y') }}
                    </span>
                </div>
            </div>
        </div>

    </div>
</div>

@endsection
