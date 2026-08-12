@extends('layouts.user')

@section('title', 'Dashboard')

@section('styles')
<style>
    /* ══════════════════════════════════════
       RESET PADDING MAIN CONTENT
       ══════════════════════════════════════ */
    #mainContent { padding: 0 !important; }

    /* ══════════════════════════════════════
       1. HERO SECTION
       ══════════════════════════════════════ */
    .hero-section {
        position: relative;
        width: 100%;
        min-height: 420px;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        overflow: hidden;
        text-align: center;
        padding: 3rem 2rem 4rem;
    }

    .hero-bg {
        position: absolute;
        inset: 0;
        background-image: url('https://upload.wikimedia.org/wikipedia/commons/thumb/7/73/Kota_Sibolga.jpg/1280px-Kota_Sibolga.jpg');
        background-size: cover;
        background-position: center;
        filter: brightness(0.38);
        z-index: 0;
    }

    .hero-overlay {
        position: absolute;
        inset: 0;
        background: linear-gradient(
            180deg,
            rgba(27,94,32,0.55) 0%,
            rgba(0,0,0,0.45) 60%,
            rgba(27,94,32,0.7) 100%
        );
        z-index: 1;
    }

    .hero-content {
        position: relative;
        z-index: 2;
        max-width: 720px;
    }

    /* Logo row */
    .hero-logos {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 2rem;
        margin-bottom: 1.8rem;
        flex-wrap: nowrap; /* tetap 1 baris di semua ukuran layar, sama seperti tampilan PC */
    }

    .hero-logo-item {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 6px;
        flex-shrink: 0;
    }

    .hero-logo-item img {
        height: 72px;
        width: auto;
        object-fit: contain;
        filter: drop-shadow(0 2px 8px rgba(0,0,0,0.4));
        transition: transform 0.3s;
    }
    .hero-logo-item img:hover { transform: scale(1.07); }

    .logo-divider {
        width: 1px;
        height: 60px;
        background: rgba(255,255,255,0.25);
        flex-shrink: 0;
    }

    /* ── Responsif: perkecil logo & jarak di HP, tetap sejajar horizontal ── */
    @media (max-width: 640px) {
        .hero-logos {
            gap: 0.9rem;
        }
        .hero-logo-item img {
            height: 42px;
        }
        .logo-divider {
            height: 36px;
        }
    }

    @media (max-width: 400px) {
        .hero-logos {
            gap: 0.6rem;
        }
        .hero-logo-item img {
            height: 34px;
        }
        .logo-divider {
            height: 30px;
        }
    }

    /* Teks hero */
    .hero-tag {
        display: inline-block;
        background: rgba(255,255,255,0.15);
        border: 1px solid rgba(255,255,255,0.3);
        color: rgba(255,255,255,0.9);
        font-size: 0.72rem;
        font-weight: 600;
        letter-spacing: 0.12em;
        text-transform: uppercase;
        padding: 0.3rem 1rem;
        border-radius: 20px;
        margin-bottom: 1rem;
        backdrop-filter: blur(4px);
    }

    .hero-title {
        font-size: clamp(1.4rem, 3vw, 2.1rem);
        font-weight: 800;
        color: white;
        line-height: 1.25;
        margin-bottom: 0.75rem;
        text-shadow: 0 2px 12px rgba(0,0,0,0.5);
    }

    .hero-title span {
        color: #A5D6A7;
    }

    .hero-subtitle {
        font-size: 0.95rem;
        color: rgba(255,255,255,0.8);
        line-height: 1.65;
        margin-bottom: 0;
        text-shadow: 0 1px 4px rgba(0,0,0,0.4);
    }

    /* Wave separator bawah hero */
    .hero-wave {
        position: absolute;
        bottom: -1px;
        left: 0;
        width: 100%;
        z-index: 3;
        line-height: 0;
    }

    /* ══════════════════════════════════════
       2. STATISTIK + GREETING (putih)
       ══════════════════════════════════════ */
    .stats-section {
        background: #ffffff;
        padding: 2rem 2rem 2.5rem;
    }

    .greeting-bar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1.25rem;
    }
    .greeting-name {
        font-size: 1.05rem;
        font-weight: 700;
        color: #212121;
    }
    .greeting-date {
        font-size: 0.8rem;
        color: #9e9e9e;
        margin-top: 2px;
        display: flex;
        align-items: center;
        gap: 5px;
    }

    .btn-buat-laporan {
        background: #1B5E20;
        color: white;
        border: none;
        border-radius: 10px;
        padding: 9px 20px;
        font-size: 0.875rem;
        font-weight: 600;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 7px;
        transition: background 0.15s, transform 0.15s, box-shadow 0.15s;
        text-decoration: none;
    }
    .btn-buat-laporan:hover {
        background: #2E7D32;
        color: white;
        transform: translateY(-1px);
        box-shadow: 0 4px 14px rgba(27,94,32,0.35);
    }

    .stats-section-label {
        font-size: 11px;
        font-weight: 600;
        letter-spacing: 0.07em;
        text-transform: uppercase;
        color: #9e9e9e;
        margin: 0 0 10px;
    }

    .stats-grid-5 {
        display: grid;
        grid-template-columns: repeat(5, minmax(0, 1fr));
        gap: 10px;
    }
    @media (max-width: 1024px) { .stats-grid-5 { grid-template-columns: repeat(3, minmax(0,1fr)); } }
    @media (max-width: 640px)  { .stats-grid-5 { grid-template-columns: repeat(2, minmax(0,1fr)); } }

    .stat-card-user {
        background: #fafafa;
        border: 1px solid #f0f0f0;
        border-radius: 14px;
        padding: 16px 16px 14px;
        display: flex;
        flex-direction: column;
        gap: 5px;
        transition: border-color 0.15s, box-shadow 0.15s, transform 0.15s;
    }
    .stat-card-user:hover {
        border-color: #e0e0e0;
        box-shadow: 0 4px 14px rgba(0,0,0,0.08);
        transform: translateY(-2px);
    }
    .stat-icon-user {
        width: 34px; height: 34px;
        border-radius: 9px;
        display: flex; align-items: center; justify-content: center;
        margin-bottom: 4px;
    }
    .stat-val-user  { font-size: 26px; font-weight: 700; line-height: 1; }
    .stat-lbl-user  { font-size: 11px; color: #9e9e9e; display: flex; align-items: center; gap: 5px; }
    .stat-dot-user  { width: 6px; height: 6px; border-radius: 50%; flex-shrink: 0; }

    .s-navy   .stat-icon-user { background: #E6F1FB; } .s-navy   .stat-val-user { color: #0C447C; } .s-navy   .stat-dot-user { background: #0C447C; }
    .s-amber  .stat-icon-user { background: #FAEEDA; } .s-amber  .stat-val-user { color: #f57f17; } .s-amber  .stat-dot-user { background: #f57f17; }
    .s-orange .stat-icon-user { background: #FFF3E0; } .s-orange .stat-val-user { color: #E65100; } .s-orange .stat-dot-user { background: #E65100; }
    .s-green  .stat-icon-user { background: #EAF3DE; } .s-green  .stat-val-user { color: #3B6D11; } .s-green  .stat-dot-user { background: #3B6D11; }
    .s-red    .stat-icon-user { background: #FCEBEB; } .s-red    .stat-val-user { color: #A32D2D; } .s-red    .stat-dot-user { background: #A32D2D; }

    /* ══════════════════════════════════════
       3. COUNTER SECTION (hijau)
       ══════════════════════════════════════ */
    .counter-section {
        background: linear-gradient(135deg, #1B5E20, #2E7D32, #388E3C);
        padding: 3rem 2rem;
        position: relative;
        overflow: hidden;
    }

    .counter-section::before {
        content: '';
        position: absolute;
        top: -80px; right: -80px;
        width: 300px; height: 300px;
        background: rgba(255,255,255,0.05);
        border-radius: 50%;
    }
    .counter-section::after {
        content: '';
        position: absolute;
        bottom: -60px; left: -60px;
        width: 220px; height: 220px;
        background: rgba(0,0,0,0.08);
        border-radius: 50%;
    }

    .counter-title {
        text-align: center;
        color: white;
        font-size: 0.8rem;
        font-weight: 600;
        letter-spacing: 0.1em;
        text-transform: uppercase;
        opacity: 0.75;
        margin-bottom: 0.4rem;
    }
    .counter-subtitle {
        text-align: center;
        color: white;
        font-size: 1.35rem;
        font-weight: 800;
        margin-bottom: 2.5rem;
    }

    .counter-grid {
        display: grid;
        grid-template-columns: repeat(5, minmax(0,1fr));
        gap: 1.5rem;
        max-width: 900px;
        margin: 0 auto;
        position: relative;
        z-index: 1;
    }
    @media (max-width: 1024px) { .counter-grid { grid-template-columns: repeat(3, minmax(0,1fr)); } }
    @media (max-width: 640px)  { .counter-grid { grid-template-columns: repeat(2, minmax(0,1fr)); } }

    .counter-item {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 0.75rem;
    }

    /* Lingkaran animasi */
    .ring-wrap {
        position: relative;
        width: 96px;
        height: 96px;
    }

    .ring-svg {
        transform: rotate(-90deg);
        width: 96px;
        height: 96px;
    }

    .ring-track {
        fill: none;
        stroke: rgba(255,255,255,0.15);
        stroke-width: 7;
    }

    .ring-progress {
        fill: none;
        stroke-width: 7;
        stroke-linecap: round;
        transition: stroke-dashoffset 1.6s cubic-bezier(.4,0,.2,1);
    }

    .ring-inner {
        position: absolute;
        inset: 0;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
    }

    .ring-number {
        font-size: 1.5rem;
        font-weight: 800;
        color: white;
        line-height: 1;
    }

    .ring-icon {
        font-size: 0.65rem;
        color: rgba(255,255,255,0.65);
        margin-top: 1px;
    }

    .counter-label {
        font-size: 0.78rem;
        font-weight: 600;
        color: rgba(255,255,255,0.85);
        text-align: center;
    }

    /* ══════════════════════════════════════
       4. FEED SECTION (putih)
       ══════════════════════════════════════ */
    .feed-outer {
        background: #f0f2f5;
        padding: 2rem 2rem 3rem;
    }

    .feed-section {
        max-width: 680px;
        margin: 0 auto;
    }

    .feed-section-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1rem;
    }

    .feed-title {
        color: #212121;
        font-weight: 700;
        font-size: 1rem;
        display: flex;
        align-items: center;
        gap: 8px;
        margin: 0;
    }

    .feed-lihat-semua {
        color: #2E7D32;
        font-size: 0.8rem;
        font-weight: 600;
        text-decoration: none;
        display: flex;
        align-items: center;
        gap: 5px;
        transition: gap 0.2s;
    }
    .feed-lihat-semua:hover { gap: 8px; color: #1B5E20; }

    .feed-card {
        background: white;
        border-radius: 14px;
        margin-bottom: 1.2rem;
        box-shadow: 0 2px 12px rgba(0,0,0,0.06);
        overflow: hidden;
        transition: transform 0.2s, box-shadow 0.2s;
        cursor: pointer;
    }
    .feed-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 24px rgba(0,0,0,0.12);
    }

    .feed-card-header {
        padding: 1rem 1.2rem 0.5rem;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .feed-avatar {
        width: 44px; height: 44px;
        border-radius: 50%;
        background: linear-gradient(135deg, #1B5E20, #4CAF50);
        display: flex; align-items: center; justify-content: center;
        color: white;
        font-weight: 700;
        font-size: 1rem;
        flex-shrink: 0;
    }
    .feed-avatar.anonim { background: linear-gradient(135deg, #757575, #9e9e9e); }

    .feed-meta { flex: 1; }
    .feed-meta .feed-name  { font-weight: 600; font-size: 0.88rem; color: #212121; margin-bottom: 2px; }
    .feed-meta .feed-time  { font-size: 0.73rem; color: #9e9e9e; }

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
        white-space: nowrap;
    }

    .feed-card-body  { padding: 0.5rem 1.2rem 0.75rem; }
    .feed-judul      { font-weight: 700; font-size: 0.95rem; color: #212121; margin-bottom: 0.5rem; line-height: 1.4; }
    .feed-deskripsi  {
        font-size: 0.83rem; color: #616161; line-height: 1.7; margin-bottom: 0.75rem;
        display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden;
    }

    .feed-tags { display: flex; align-items: center; gap: 0.5rem; flex-wrap: wrap; }
    .feed-tag  {
        font-size: 0.72rem; background: #f5f5f5; color: #757575;
        padding: 0.2rem 0.65rem; border-radius: 20px;
        display: flex; align-items: center; gap: 4px;
    }

    .feed-card-footer {
        padding: 0.65rem 1.2rem;
        border-top: 1px solid #f5f5f5;
        display: flex;
        align-items: center;
        gap: 1.5rem;
    }

    .feed-action {
        font-size: 0.78rem; color: #9e9e9e;
        display: flex; align-items: center; gap: 5px;
        text-decoration: none; transition: color 0.2s;
    }
    .feed-action:hover { color: #2E7D32; }

    .feed-action-detail {
        margin-left: auto;
        font-size: 0.78rem; font-weight: 600; color: #2E7D32;
        text-decoration: none;
        display: flex; align-items: center; gap: 5px;
        transition: all 0.2s;
    }
    .feed-action-detail:hover { color: #1B5E20; gap: 8px; }

    .empty-feed {
        background: white;
        border-radius: 14px;
        padding: 4rem 2rem;
        text-align: center;
        color: #9e9e9e;
    }

    /* ══════════════════════════════════════
       5. INFO KONTAK (hijau gelap)
       ══════════════════════════════════════ */
    .info-section {
        background: #1B5E20;
        padding: 2.5rem 2rem;
    }

    .info-grid {
        display: grid;
        grid-template-columns: repeat(4, minmax(0,1fr));
        gap: 1.5rem;
        max-width: 900px;
        margin: 0 auto;
    }
    @media (max-width: 1024px) { .info-grid { grid-template-columns: repeat(2, minmax(0,1fr)); } }
    @media (max-width: 640px)  { .info-grid { grid-template-columns: 1fr; } }

    .info-card {
        display: flex;
        align-items: flex-start;
        gap: 12px;
    }

    .info-icon-wrap {
        width: 42px; height: 42px;
        border-radius: 10px;
        background: rgba(255,255,255,0.12);
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0;
        font-size: 1.1rem;
        color: #A5D6A7;
        transition: background 0.2s;
    }
    .info-card:hover .info-icon-wrap { background: rgba(255,255,255,0.2); }

    .info-card-label {
        font-size: 0.7rem;
        font-weight: 600;
        letter-spacing: 0.08em;
        text-transform: uppercase;
        color: rgba(255,255,255,0.5);
        margin-bottom: 3px;
    }
    .info-card-value {
        font-size: 0.88rem;
        color: rgba(255,255,255,0.9);
        font-weight: 500;
        line-height: 1.5;
        text-decoration: none;
    }
    a.info-card-value:hover { color: #A5D6A7; }

    .info-divider {
        border: none;
        border-top: 1px solid rgba(255,255,255,0.1);
        margin: 2rem auto 1.5rem;
        max-width: 900px;
    }

    .info-footer {
        text-align: center;
        font-size: 0.75rem;
        color: rgba(255,255,255,0.4);
    }
</style>
@endsection

@section('content')

{{-- ══════════════════════════════════════
     1. HERO
     ══════════════════════════════════════ --}}
<section class="hero-section">
    <div class="hero-bg"></div>
    <div class="hero-overlay"></div>

    <div class="hero-content">
        {{-- Logo Row --}}
        <div class="hero-logos">
            <div class="hero-logo-item">
                <img src="https://kompaspedia.kompas.id/wp-content/uploads/2020/09/LOGO_1271_KOTA-SIBOLGA_thumb.png"
                     alt="Logo Kota Sibolga"
                     onerror="this.parentElement.style.display='none'">
            </div>
            <div class="logo-divider"></div>
            <div class="hero-logo-item">
                <img src="https://www.menpan.go.id/site/images/berita_foto_backup/2021/sipanday_berakhlak_bangga-melayani-bangsa/Logo_BerAKHLAK.png"
                     alt="Logo BerAKHLAK"
                     onerror="this.parentElement.style.display='none'">
            </div>
            <div class="logo-divider"></div>
            <div class="hero-logo-item">
                <img src="https://www.menpan.go.id/site/images/berita_foto_backup/2021/sipanday_berakhlak_bangga-melayani-bangsa/Logo_EVP.png"
                     alt="Logo Bangga Melayani Bangsa"
                     onerror="this.parentElement.style.display='none'">
            </div>
        </div>

        {{-- Text --}}
        <div class="hero-tag">Sistem Pengaduan Masyarakat</div>
        <h1 class="hero-title">
            Selamat Datang di<br>
            <span>Website Pengaduan Kota Sibolga</span>
        </h1>
        <p class="hero-subtitle">
            Layanan Penyampaian Pengaduan Masyarakat Kota Sibolga<br>
            Aspirasi Anda, Prioritas Kami
        </p>
    </div>

    {{-- Wave --}}
    <div class="hero-wave">
        <svg viewBox="0 0 1440 60" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none">
            <path d="M0,40 C360,80 1080,0 1440,40 L1440,60 L0,60 Z" fill="#ffffff"/>
        </svg>
    </div>
</section>

{{-- ══════════════════════════════════════
     2. STATISTIK + GREETING
     ══════════════════════════════════════ --}}
<section class="stats-section">
    <div class="greeting-bar">
        <div>
            <div class="greeting-name">
                Halo, {{ Auth::guard('web')->user()->nama }}!
            </div>
            <div class="greeting-date">
                <i class="fas fa-calendar-alt"></i>
                {{ \Carbon\Carbon::now()->locale('id')->isoFormat('dddd, D MMMM Y') }}
            </div>
        </div>
        <a href="{{ route('user.laporan.create') }}" class="btn-buat-laporan">
            <i class="fas fa-plus"></i> Buat Laporan
        </a>
    </div>

    <p class="stats-section-label">Laporan saya</p>
    <div class="stats-grid-5">

        <div class="stat-card-user s-navy">
            <div class="stat-icon-user">
                <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="#185FA5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414A1 1 0 0119 9.414V19a2 2 0 01-2 2z"/>
                </svg>
            </div>
            <div class="stat-val-user">{{ $totalLaporan }}</div>
            <div class="stat-lbl-user"><span class="stat-dot-user"></span> Total laporan</div>
        </div>

        <div class="stat-card-user s-amber">
            <div class="stat-icon-user">
                <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="#f57f17">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div class="stat-val-user">{{ $menunggu }}</div>
            <div class="stat-lbl-user"><span class="stat-dot-user"></span> Menunggu</div>
        </div>

        <div class="stat-card-user s-orange">
            <div class="stat-icon-user">
                <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="#E65100">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                </svg>
            </div>
            <div class="stat-val-user">{{ $diproses }}</div>
            <div class="stat-lbl-user"><span class="stat-dot-user"></span> Diproses</div>
        </div>

        <div class="stat-card-user s-green">
            <div class="stat-icon-user">
                <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="#3B6D11">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div class="stat-val-user">{{ $selesai }}</div>
            <div class="stat-lbl-user"><span class="stat-dot-user"></span> Selesai</div>
        </div>

        <div class="stat-card-user s-red">
            <div class="stat-icon-user">
                <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="#A32D2D">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div class="stat-val-user">{{ $ditolak }}</div>
            <div class="stat-lbl-user"><span class="stat-dot-user"></span> Ditolak</div>
        </div>

    </div>
</section>

{{-- ══════════════════════════════════════
     3. COUNTER ANIMASI (hijau)
     ══════════════════════════════════════ --}}
<section class="counter-section">
    <p class="counter-title">Rekap Keseluruhan Sistem</p>
    <h2 class="counter-subtitle">Total Laporan Seluruh Masyarakat</h2>

    @php
        $max = max($sistemTotal, 1);
        $counters = [
            ['label' => 'Total Laporan', 'val' => $sistemTotal,    'color' => '#90CAF9', 'pct' => 100],
            ['label' => 'Menunggu',      'val' => $sistemMenunggu,  'color' => '#FFcc80', 'pct' => round(($sistemMenunggu/$max)*100)],
            ['label' => 'Diproses',      'val' => $sistemDiproses,  'color' => '#e67233', 'pct' => round(($sistemDiproses/$max)*100)],
            ['label' => 'Selesai',       'val' => $sistemSelesai,   'color' => '#A5D6A7', 'pct' => round(($sistemSelesai/$max)*100)],
            ['label' => 'Ditolak',       'val' => $sistemDitolak,   'color' => '#d65e5e', 'pct' => round(($sistemDitolak/$max)*100)],
        ];
        $r = 40; $circ = 2 * M_PI * $r;
    @endphp

    <div class="counter-grid">
        @foreach($counters as $idx => $c)
            @php $dash = $circ * ($c['pct'] / 100); @endphp
            <div class="counter-item">
                <div class="ring-wrap">
                    <svg class="ring-svg" viewBox="0 0 96 96">
                        <circle class="ring-track" cx="48" cy="48" r="{{ $r }}"/>
                        <circle class="ring-progress"
                                cx="48" cy="48" r="{{ $r }}"
                                stroke="{{ $c['color'] }}"
                                stroke-dasharray="{{ $circ }}"
                                stroke-dashoffset="{{ $circ }}"
                                data-target-offset="{{ $circ - $dash }}"
                                id="ring-{{ $idx }}"/>
                    </svg>
                    <div class="ring-inner">
                        <div class="ring-number" data-target="{{ $c['val'] }}" id="count-{{ $idx }}">0</div>
                        <div class="ring-icon">laporan</div>
                    </div>
                </div>
                <div class="counter-label">{{ $c['label'] }}</div>
            </div>
        @endforeach
    </div>
</section>

{{-- ══════════════════════════════════════
     4. FEED LAPORAN
     ══════════════════════════════════════ --}}
<section class="feed-outer">
    <div class="feed-section">
        <div class="feed-section-header">
            <div class="feed-title">
                <i class="fas fa-newspaper" style="color:#2E7D32;"></i>
                Feed Laporan Publik
            </div>
            <a href="{{ route('user.feed.index') }}" class="feed-lihat-semua">
                Lihat Semua <i class="fas fa-arrow-right"></i>
            </a>
        </div>

        @if($feeds->count() > 0)
            @foreach($feeds as $feed)
                <div class="feed-card"
                onclick="window.location='{{ route('user.feed.show', $feed->id_hasil) }}'">

                    <div class="feed-card-header">
                        @if($feed->laporan->anonim)
                            <div class="feed-avatar anonim"><i class="fas fa-user-secret"></i></div>
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

                    <div class="feed-card-body">
                        <div class="feed-judul">{{ $feed->laporan->judul_laporan }}</div>
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
        @else
            <div class="empty-feed">
                <i class="fas fa-newspaper fa-3x mb-3 d-block" style="color:#c8e6c9;"></i>
                <p class="fw-bold mb-1">Belum ada laporan publik</p>
                <small>Laporan yang sudah selesai akan muncul di sini</small>
            </div>
        @endif
    </div>
</section>

{{-- ══════════════════════════════════════
     5. INFO KONTAK
     ══════════════════════════════════════ --}}
<section class="info-section">
    <div class="info-grid">

        <div class="info-card">
            <div class="info-icon-wrap">
                <i class="fab fa-instagram"></i>
            </div>
            <div>
                <div class="info-card-label">Instagram</div>
                <a href="https://www.instagram.com/pemko_sibolga?utm_source=ig_web_button_share_sheet&igsh=ZDNlZDc0MzIxNw==" target="_blank" class="info-card-value">
                    @pemko_sibolga
                </a>
            </div>
        </div>

        <div class="info-card">
            <div class="info-icon-wrap">
                <i class="fas fa-globe"></i>
            </div>
            <div>
                <div class="info-card-label">Website Resmi</div>
                <a href="https://sibolgakota.go.id" target="_blank" class="info-card-value">
                    sibolgakota.go.id
                </a>
            </div>
        </div>

        <div class="info-card">
            <div class="info-icon-wrap">
                <i class="fab fa-whatsapp"></i>
            </div>
            <div>
                <div class="info-card-label">WhatsApp</div>
                <a href="https://wa.me/6281112041700" target="_blank" class="info-card-value">
                    +62 811-1204-1700
                </a>
            </div>
        </div>

        <div class="info-card">
            <div class="info-icon-wrap">
                <i class="fas fa-map-marker-alt"></i>
            </div>
            <div>
                <div class="info-card-label">Alamat</div>
                <span class="info-card-value">
                    Jl. Sutomo No.26A, Kota Beringin, Sibolga Kota, Kota Sibolga, Sumatera Utara 22513
                </span>
            </div>
        </div>

    </div>

    <hr class="info-divider">
    <p class="info-footer">
        &copy; {{ date('Y') }} Pemerintah Kota Sibolga — Sistem Pengaduan Masyarakat (OGEK WALI)
    </p>
</section>

@endsection

@section('scripts')
<script>
// ── Animasi ring + counter angka ──
document.addEventListener('DOMContentLoaded', function () {
    const rings    = document.querySelectorAll('.ring-progress');
    const counters = document.querySelectorAll('.ring-number');

    // Intersection Observer — mulai animasi saat masuk viewport
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (!entry.isIntersecting) return;

            // Animasi ring
            rings.forEach(ring => {
                const target = parseFloat(ring.dataset.targetOffset);
                ring.style.strokeDashoffset = target;
            });

            // Animasi angka counter
            counters.forEach(el => {
                const target = parseInt(el.dataset.target);
                let current = 0;
                const step  = Math.ceil(target / 40) || 1;
                const timer = setInterval(() => {
                    current += step;
                    if (current >= target) {
                        el.textContent = target;
                        clearInterval(timer);
                    } else {
                        el.textContent = current;
                    }
                }, 40);
            });

            observer.disconnect();
        });
    }, { threshold: 0.3 });

    const counterSection = document.querySelector('.counter-section');
    if (counterSection) observer.observe(counterSection);
});
</script>
@endsection
