@extends('layouts.user')

@section('title', 'Feed Laporan')

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

    /* FEED WRAPPER */
    .feed-wrapper {
        max-width: 680px;
        margin: 0 auto;
    }

    /* FEED CARD */
    .feed-card {
        background: rgba(255,255,255,0.97);
        border-radius: 14px;
        margin-bottom: 1.2rem;
        box-shadow: 0 2px 12px rgba(0,0,0,0.08);
        overflow: hidden;
        transition: transform 0.2s, box-shadow 0.2s;
        cursor: pointer;
    }

    .feed-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 24px rgba(0,0,0,0.15);
    }

    .feed-card-header {
        padding: 1rem 1.2rem 0.5rem;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .feed-avatar {
        width: 44px;
        height: 44px;
        border-radius: 50%;
        background: linear-gradient(135deg, #1B5E20, #4CAF50);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: 700;
        font-size: 1rem;
        flex-shrink: 0;
    }

    .feed-avatar.anonim {
        background: linear-gradient(135deg, #757575, #9e9e9e);
    }

    .feed-meta { flex: 1; }

    .feed-meta .feed-name {
        font-weight: 600;
        font-size: 0.88rem;
        color: #212121;
        margin-bottom: 2px;
    }

    .feed-meta .feed-time {
        font-size: 0.73rem;
        color: #9e9e9e;
    }

    .feed-status-badge {
        background: #E8F5E9;
        color: #1B5E20;
        font-size: 0.72rem;
        font-weight: 600;
        padding: 0.25rem 0.75rem;
        border-radius: 20px;
        display: flex;
        align-items: center;
        gap: 4px;
    }

    .feed-card-body {
        padding: 0.5rem 1.2rem 0.75rem;
    }

    .feed-judul {
        font-weight: 700;
        font-size: 0.95rem;
        color: #212121;
        margin-bottom: 0.5rem;
        line-height: 1.4;
    }

    .feed-deskripsi {
        font-size: 0.83rem;
        color: #616161;
        line-height: 1.7;
        margin-bottom: 0.75rem;
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .feed-tags {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        flex-wrap: wrap;
    }

    .feed-tag {
        font-size: 0.72rem;
        background: #f5f5f5;
        color: #757575;
        padding: 0.2rem 0.65rem;
        border-radius: 20px;
        display: flex;
        align-items: center;
        gap: 4px;
    }

    .feed-card-footer {
        padding: 0.65rem 1.2rem;
        border-top: 1px solid #f5f5f5;
        display: flex;
        align-items: center;
        gap: 1.5rem;
    }

    .feed-action {
        font-size: 0.78rem;
        color: #9e9e9e;
        display: flex;
        align-items: center;
        gap: 5px;
        text-decoration: none;
        transition: color 0.2s;
    }

    .feed-action:hover { color: #2E7D32; }

    .feed-action-detail {
        margin-left: auto;
        font-size: 0.78rem;
        font-weight: 600;
        color: #2E7D32;
        text-decoration: none;
        display: flex;
        align-items: center;
        gap: 5px;
        transition: all 0.2s;
    }

    .feed-action-detail:hover {
        color: #1B5E20;
        gap: 8px;
    }

    /* EMPTY STATE */
    .empty-state {
        background: rgba(255,255,255,0.97);
        border-radius: 14px;
        padding: 4rem 2rem;
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

    /* SKELETON LOADING */
    @keyframes shimmer {
        0% { background-position: -468px 0; }
        100% { background-position: 468px 0; }
    }
</style>
@endsection

@section('content')

{{-- PAGE HEADER --}}
<div class="page-header">
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h6><i class="fas fa-newspaper me-2"></i>Feed Laporan Publik</h6>
            <p>Laporan yang telah diselesaikan dan dipublikasikan oleh admin</p>
        </div>
        <span class="badge bg-light text-success fw-600">
            {{ $feeds->total() }} Laporan
        </span>
    </div>
</div>

{{-- FEED LIST --}}
<div class="feed-wrapper">

    @if($feeds->count() > 0)
        @foreach($feeds as $feed)
            <div class="feed-card"
                 onclick="window.location='{{ route('user.feed.show', $feed->id_hasil) }}'">

                {{-- HEADER --}}
                <div class="feed-card-header">
                    @if($feed->laporan->anonim)
                        <div class="feed-avatar anonim">
                            <i class="fas fa-user-secret"></i>
                        </div>
                    @else
                        <div class="feed-avatar">
                            {{ strtoupper(substr($feed->laporan->user->nama ?? 'U', 0, 1)) }}
                        </div>
                    @endif

                    <div class="feed-meta">
                        <div class="feed-name">
                            {{ $feed->laporan->anonim ? 'Anonim' : ($feed->laporan->user->nama ?? 'User') }}
                        </div>
                        <div class="feed-time">
                            <i class="fas fa-clock me-1"></i>
                            {{ \Carbon\Carbon::parse($feed->tanggal_publish)->locale('id')->diffForHumans() }}
                        </div>
                    </div>

                    <span class="feed-status-badge">
                        <i class="fas fa-check-circle"></i> Selesai
                    </span>
                </div>

                {{-- BODY --}}
                <div class="feed-card-body">
                    {{-- Judul Laporan Pelapor --}}
                    <div class="feed-judul">{{ $feed->laporan->judul_laporan }}</div>

                    {{-- Isi Laporan Pelapor--}}
                    <div class="feed-deskripsi">{{ Str::limit($feed->laporan->isi_laporan, 150) }}</div>

                    <div class="feed-tags">
                        <span class="feed-tag">
                            <i class="fas fa-tag"></i>
                            {{ $feed->laporan->kategori->nama_kategori ?? '-' }}
                        </span>
                        @if($feed->laporan->lokasi_kejadian)
                            <span class="feed-tag">
                                <i class="fas fa-map-marker-alt"></i>
                                {{ Str::limit($feed->laporan->lokasi_kejadian, 25) }}
                            </span>
                        @endif
                        @if($feed->lampiranHasil->count() > 0)
                            <span class="feed-tag">
                                <i class="fas fa-paperclip"></i>
                                {{ $feed->lampiranHasil->count() }} Lampiran
                            </span>
                        @endif
                    </div>
                </div>

                {{-- FOOTER --}}
                <div class="feed-card-footer">
                    <span class="feed-action">
                        <i class="fas fa-calendar-alt"></i>
                        {{ \Carbon\Carbon::parse($feed->laporan->created_at)->locale('id')->isoFormat('D MMM Y') }}
                    </span>
                    <span class="feed-action">
                        <i class="fas fa-user-shield"></i>
                        {{ $feed->admin->nama_admin ?? 'Admin' }}
                    </span>
                    <a href="{{ route('user.feed.show', $feed->id_hasil) }}"
                       class="feed-action-detail"
                       onclick="event.stopPropagation()">
                        Lihat Detail <i class="fas fa-arrow-right"></i>
                    </a>
                </div>

            </div>
        @endforeach

        {{-- PAGINATION --}}
        <div class="d-flex justify-content-center mt-3">
            {{ $feeds->links() }}
        </div>

    @else
        <div class="empty-state">
            <i class="fas fa-newspaper fa-3x mb-3 d-block" style="color:#c8e6c9;"></i>
            <p class="fw-600 mb-1">Belum ada laporan publik</p>
            <small>Laporan yang sudah selesai dan dipublikasikan akan muncul di sini</small>
        </div>
    @endif

</div>

@endsection
