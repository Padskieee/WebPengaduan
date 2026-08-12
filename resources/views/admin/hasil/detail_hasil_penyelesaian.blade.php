@extends('layouts.admin')

@section('title', 'Detail Hasil Penyelesaian')

@section('styles')
<style>
    .detail-card {
        background: white;
        border-radius: 14px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.06);
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
        padding: 0.75rem 0;
        border-bottom: 1px solid #f5f5f5;
    }

    .detail-row:last-child { border-bottom: none; }

    .detail-label {
        font-size: 0.78rem;
        font-weight: 700;
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

    .publish-badge {
        font-size: 0.78rem;
        font-weight: 600;
        padding: 0.35rem 0.9rem;
        border-radius: 20px;
    }

    .publish-draft   { background:#f5f5f5; color:#757575; }
    .publish-publish { background:#E8F5E9; color:#1B5E20; }

    /* LAMPIRAN */
    .lampiran-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(120px, 1fr));
        gap: 0.75rem;
        margin-bottom: 1rem;
    }

    .lampiran-foto {
        border-radius: 10px;
        overflow: hidden;
        aspect-ratio: 1;
        background: #f5f5f5;
        cursor: pointer;
        transition: transform 0.2s;
        position: relative;
    }

    .lampiran-foto:hover { transform: scale(1.03); }

    .lampiran-foto img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .lampiran-foto .jenis-tag {
        position: absolute;
        bottom: 6px;
        left: 6px;
        font-size: 0.65rem;
        font-weight: 700;
        padding: 0.2rem 0.5rem;
        border-radius: 10px;
    }

    .jenis-sebelum { background:#FF9800; color:white; }
    .jenis-sesudah { background:#4CAF50; color:white; }
    .jenis-lainnya { background:#9C27B0; color:white; }

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

    .lampiran-file:hover { background: #E8F5E9; color: #1B5E20; }

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

    /* BUTTONS */
    .btn-publish {
        background: linear-gradient(135deg, #1565C0, #1976D2);
        color: white;
        border: none;
        border-radius: 8px;
        padding: 0.65rem 1.5rem;
        font-weight: 600;
        font-size: 0.88rem;
        transition: all 0.2s;
        width: 100%;
    }

    .btn-publish:hover {
        background: linear-gradient(135deg, #1976D2, #1E88E5);
        color: white;
        transform: translateY(-1px);
    }

    .btn-unpublish {
        background: #f5f5f5;
        color: #757575;
        border: none;
        border-radius: 8px;
        padding: 0.65rem 1.5rem;
        font-weight: 600;
        font-size: 0.88rem;
        transition: all 0.2s;
        width: 100%;
    }

    .btn-unpublish:hover {
        background: #e0e0e0;
        color: #424242;
    }
</style>
@endsection

@section('content')

<div class="row">
    <div class="col-lg-8">

        {{-- BACK --}}
        <div class="d-flex align-items-center gap-2 mb-3">
            <a href="{{ route('admin.hasil.index') }}"
               class="text-muted text-decoration-none">
                <i class="fas fa-arrow-left"></i>
            </a>
            <h6 class="fw-bold mb-0" style="color:#1B5E20;">
                Detail Hasil Penyelesaian
            </h6>
        </div>

        {{-- HASIL --}}
        <div class="detail-card">
            <div class="detail-card-header">
                <i class="fas fa-check-circle"></i> Hasil Penyelesaian
                <span class="ms-auto publish-badge publish-{{ $hasil->status_publish }}">
                    @if($hasil->status_publish == 'publish')
                        <i class="fas fa-globe me-1"></i>Dipublikasikan
                    @else
                        <i class="fas fa-file me-1"></i>Draft
                    @endif
                </span>
            </div>
            <div class="detail-card-body">
                <div class="detail-row">
                    <span class="detail-label">Judul</span>
                    <span class="detail-value fw-600">{{ $hasil->judul_output }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Deskripsi</span>
                    <span class="detail-value" style="white-space:pre-line;">
                        {{ $hasil->deskripsi_output }}
                    </span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Admin</span>
                    <span class="detail-value">{{ $hasil->admin->nama_admin ?? '-' }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Tgl Publish</span>
                    <span class="detail-value">
                        {{ $hasil->tanggal_publish
                            ? \Carbon\Carbon::parse($hasil->tanggal_publish)->locale('id')->isoFormat('D MMMM Y, HH:mm')
                            : '-' }}
                    </span>
                </div>
            </div>
        </div>

        {{-- LAMPIRAN --}}
        @if($hasil->lampiranHasil->count() > 0)
            <div class="detail-card">
                <div class="detail-card-header">
                    <i class="fas fa-images"></i>
                    Lampiran ({{ $hasil->lampiranHasil->count() }})
                </div>
                <div class="detail-card-body">

                    {{-- Foto --}}
                    @php $fotos = $hasil->lampiranHasil->where('tipe_file', 'foto'); @endphp
                    @if($fotos->count() > 0)
                        <p class="small fw-600 text-muted mb-2">Foto</p>
                        <div class="lampiran-grid">
                            @foreach($fotos as $lamp)
                                <a href="{{ Storage::url($lamp->file_path) }}"
                                   target="_blank" class="lampiran-foto">
                                    <img src="{{ Storage::url($lamp->file_path) }}"
                                         alt="Lampiran">
                                    <span class="jenis-tag jenis-{{ $lamp->jenis_lampiran }}">
                                        {{ ucfirst($lamp->jenis_lampiran) }}
                                    </span>
                                </a>
                            @endforeach
                        </div>
                    @endif

                    {{-- Dokumen & Video --}}
                    @foreach($hasil->lampiranHasil->whereNotIn('tipe_file', ['foto']) as $lamp)
                        <a href="{{ Storage::url($lamp->file_path) }}"
                           target="_blank" class="lampiran-file">
                            <div class="lampiran-icon">
                                @if($lamp->tipe_file == 'video')
                                    <i class="fas fa-video"></i>
                                @else
                                    <i class="fas fa-file-pdf"></i>
                                @endif
                            </div>
                            <div>
                                <div class="small fw-600">{{ basename($lamp->file_path) }}</div>
                                <div class="small text-muted">{{ ucfirst($lamp->tipe_file) }}</div>
                            </div>
                            <span class="ms-auto badge jenis-{{ $lamp->jenis_lampiran }}"
                                  style="font-size:0.7rem;">
                                {{ ucfirst($lamp->jenis_lampiran) }}
                            </span>
                        </a>
                    @endforeach

                </div>
            </div>
        @endif

        {{-- INFO LAPORAN --}}
        <div class="detail-card">
            <div class="detail-card-header">
                <i class="fas fa-file-alt"></i> Laporan Terkait
            </div>
            <div class="detail-card-body">
                <div class="detail-row">
                    <span class="detail-label">Judul</span>
                    <span class="detail-value fw-600">
                        {{ $hasil->laporan->judul_laporan }}
                    </span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Pelapor</span>
                    <span class="detail-value">
                        @if($hasil->laporan->anonim)
                            <i class="fas fa-user-secret me-1"></i>Anonim
                        @else
                            {{ $hasil->laporan->user->nama ?? '-' }}
                        @endif
                    </span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Kategori</span>
                    <span class="detail-value">
                        {{ $hasil->laporan->kategori->nama_kategori ?? '-' }}
                    </span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Tgl Laporan</span>
                    <span class="detail-value">
                        {{ \Carbon\Carbon::parse($hasil->laporan->created_at)->locale('id')->isoFormat('D MMMM Y') }}
                    </span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Lihat Laporan</span>
                    <span class="detail-value">
                        <a href="{{ route('admin.laporan.show', $hasil->laporan->id_laporan) }}"
                           class="text-success small fw-600 text-decoration-none">
                            <i class="fas fa-external-link-alt me-1"></i>Buka Detail Laporan
                        </a>
                    </span>
                </div>
            </div>
        </div>

    </div>

    <div class="col-lg-4">

        {{-- AKSI PUBLISH --}}
        <div class="detail-card">
            <div class="detail-card-header">
                <i class="fas fa-globe"></i> Kelola Publikasi
            </div>
            <div class="detail-card-body">
                <p class="small text-muted mb-3">
                    @if($hasil->status_publish == 'draft')
                        Hasil ini belum dipublikasikan. Klik tombol di bawah untuk mempublikasikan ke feed publik.
                    @else
                        Hasil ini sudah dipublikasikan dan dapat dilihat oleh masyarakat di feed publik.
                    @endif
                </p>
                <form action="{{ route('admin.hasil.publish', $hasil->id_hasil) }}"
                      method="POST">
                    @csrf
                    @if($hasil->status_publish == 'draft')
                        <button type="submit" class="btn-publish">
                            <i class="fas fa-globe me-2"></i>Publikasikan Sekarang
                        </button>
                    @else
                        <button type="submit" class="btn-unpublish">
                            <i class="fas fa-eye-slash me-2"></i>Tarik dari Publikasi
                        </button>
                    @endif
                </form>
            </div>
        </div>

    </div>
</div>

@endsection
