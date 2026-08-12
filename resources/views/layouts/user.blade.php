<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OGEK WALI - @yield('title')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Pacifico&display=swap" rel="stylesheet">

    <style>
        :root {
            --hijau-tua:   #1B5E20;
            --hijau-sedang:#2E7D32;
            --hijau-muda:  #4CAF50;
        }

        * { font-family: 'Inter', sans-serif; }

        body {
            background-image: url('/images/sibolga.jpg');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            background-repeat: no-repeat;
            min-height: 100vh;
            margin: 0;
            padding-bottom: 70px; /* ruang untuk bottom nav di HP */
        }

        body::before {
            content: '';
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,0.45);
            z-index: 0;
        }

        /* ── NAVBAR ── */
        .navbar {
            background: linear-gradient(135deg, #1B5E20, #2E7D32) !important;
            box-shadow: 0 2px 8px rgba(0,0,0,0.3);
            position: relative;
            z-index: 100;
            overflow: hidden;
            padding: 0.5rem 1rem;
        }

        .navbar-watermark {
            position: absolute;
            right: -15px;
            bottom: -15px;
            font-size: 5rem;
            color: rgba(255,255,255,0.08);
            pointer-events: none;
            line-height: 1;
        }

        .brand-name {
            font-family: 'Pacifico', cursive;
            font-size: 1.3rem;
            color: white !important;
        }

        .navbar-logo {
            width: 28px;
            height: auto;
            object-fit: contain;
            filter: drop-shadow(1px 1px 2px rgba(0,0,0,0.3));
        }

        .toggle-btn {
            background: rgba(255,255,255,0.15);
            border: 1px solid rgba(255,255,255,0.3);
            color: white;
            width: 34px;
            height: 34px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.2s;
            flex-shrink: 0;
        }

        .toggle-btn:hover { background: rgba(255,255,255,0.25); }

        /* nama user di navbar */
        .navbar-user {
            color: rgba(255,255,255,0.85);
            font-size: 0.82rem;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            max-width: 120px;
        }

        .btn-logout-nav {
            background: rgba(255,255,255,0.15);
            border: 1px solid rgba(255,255,255,0.3);
            color: white;
            border-radius: 8px;
            padding: 0.35rem 0.75rem;
            font-size: 0.8rem;
            font-weight: 600;
            white-space: nowrap;
            transition: all 0.2s;
        }

        .btn-logout-nav:hover {
            background: rgba(255,255,255,0.25);
            color: white;
        }

        /* ── PAGE WRAPPER ── */
        .page-wrapper {
            display: flex;
            position: relative;
            z-index: 10;
            min-height: calc(100vh - 60px);
        }

        /* ── SIDEBAR (desktop only) ── */
        #sidebar {
            background: rgba(255,255,255,0.12);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border-right: 1px solid rgba(255,255,255,0.2);
            width: 220px;
            min-width: 220px;
            padding-top: 1.5rem;
            transition: all 0.3s ease;
            overflow: hidden;
            flex-shrink: 0;
            position: relative;
        }

        #sidebar.collapsed {
            width: 0;
            min-width: 0;
            padding: 0;
        }

        .sidebar-nav .nav-link {
            color: rgba(255,255,255,0.9);
            padding: 0.6rem 1.2rem;
            border-radius: 8px;
            margin: 2px 8px;
            font-size: 0.9rem;
            transition: all 0.2s;
            white-space: nowrap;
        }

        .sidebar-nav .nav-link:hover,
        .sidebar-nav .nav-link.active {
            background: rgba(255,255,255,0.2);
            color: white;
            font-weight: 600;
        }

        .sidebar-nav .nav-link i { width: 20px; }

        .sidebar-watermark {
            position: absolute;
            right: -10px;
            bottom: -10px;
            font-size: 7rem;
            color: rgba(255,255,255,0.07);
            pointer-events: none;
            line-height: 1;
        }

        /* ── HOVER ZONE ── */
        #hoverZone {
            position: fixed;
            left: 0;
            top: 60px;
            width: 8px;
            height: calc(100vh - 60px);
            z-index: 999;
        }

        /* ── MAIN CONTENT ── */
        #mainContent {
            flex: 1;
            padding: 1.5rem;
            transition: all 0.3s ease;
            overflow-x: hidden;
            position: relative;
            z-index: 1;
        }

        /* ── CARDS ── */
        .card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 2px 12px rgba(0,0,0,0.1);
            background: rgba(255,255,255,0.95);
        }

        .card-header {
            background-color: var(--hijau-tua);
            color: white;
            border-radius: 12px 12px 0 0 !important;
            font-weight: 600;
        }

        .btn-primary {
            background-color: var(--hijau-sedang);
            border-color: var(--hijau-sedang);
        }

        .btn-primary:hover {
            background-color: var(--hijau-tua);
            border-color: var(--hijau-tua);
        }

        /* ══════════════════════════════
           BOTTOM NAVIGATION (mobile)
        ══════════════════════════════ */
        .bottom-nav {
            display: none; /* hidden di desktop */
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            z-index: 200;
            background: linear-gradient(135deg, #1B5E20, #2E7D32);
            box-shadow: 0 -2px 12px rgba(0,0,0,0.2);
            height: 64px;
            padding: 0 0.5rem;
        }

        .bottom-nav-inner {
            display: flex;
            align-items: center;
            justify-content: space-around;
            height: 100%;
        }

        .bottom-nav-item {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 3px;
            color: rgba(255,255,255,0.7);
            text-decoration: none;
            font-size: 0.62rem;
            font-weight: 600;
            padding: 0.4rem 0.6rem;
            border-radius: 10px;
            transition: all 0.2s;
            min-width: 56px;
        }

        .bottom-nav-item i {
            font-size: 1.2rem;
        }

        .bottom-nav-item.active,
        .bottom-nav-item:hover {
            color: white;
            background: rgba(255,255,255,0.15);
        }

        .bottom-nav-item.active i {
            color: #81C784;
        }

        /* Tombol buat laporan di tengah bottom nav */
        .bottom-nav-center {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 3px;
            text-decoration: none;
            margin-top: -20px;
        }

        .bottom-nav-center-btn {
            width: 52px;
            height: 52px;
            border-radius: 50%;
            background: white;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 12px rgba(0,0,0,0.3);
            transition: all 0.2s;
        }

        .bottom-nav-center-btn i {
            font-size: 1.3rem;
            color: #1B5E20;
        }

        .bottom-nav-center span {
            font-size: 0.6rem;
            font-weight: 600;
            color: rgba(255,255,255,0.85);
        }

        /* ══════════════════════════════
           RESPONSIVE
        ══════════════════════════════ */
        @media (max-width: 768px) {
            /* Sembunyikan sidebar di HP */
            #sidebar { display: none !important; }
            #hoverZone { display: none !important; }
            .toggle-btn { display: none !important; }

            /* Tampilkan bottom nav */
            .bottom-nav { display: block; }

            /* Padding konten */
            #mainContent { padding: 1rem 0.75rem; }

            /* Nama user lebih pendek */
            .navbar-user { max-width: 100px; font-size: 0.75rem; }
        }

        @media (min-width: 769px) {
            /* Sembunyikan bottom nav di desktop */
            .bottom-nav { display: none !important; }
        }

        /* ══════════════════════════════
           PAGE LOADING OVERLAY
        ══════════════════════════════ */
        .page-loader-overlay {
            position: fixed;
            inset: 0;
            z-index: 99999;
            background: rgba(255, 255, 255, 0.92);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            gap: 1rem;
            opacity: 0;
            visibility: hidden;
            transition: opacity 0.18s ease;
        }

        .page-loader-overlay.active {
            opacity: 1;
            visibility: visible;
        }

        .page-loader-text {
            font-size: 0.85rem;
            font-weight: 600;
            color: #1B5E20;
            letter-spacing: 0.02em;
        }

        /* Hopdot loader (menggantikan spinner lingkaran) */
        .hopdot-wrap {
            width: 170px;
            height: 80px;
        }

        .hopdot-wrap svg {
            width: 100%;
            height: 100%;
            visibility: hidden; /* dimunculkan via JS setelah GSAP siap */
        }

        .hopdot-wrap svg #whole {
            fill: #1B5E20;
            stroke: #1B5E20;
        }
    </style>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js"></script>
    @yield('styles')
</head>
<body>

{{-- PAGE LOADING OVERLAY --}}
<div class="page-loader-overlay" id="pageLoader">
    <div class="hopdot-wrap">
        <svg id="mainSVG" xmlns="http://www.w3.org/2000/svg" viewBox="220 230 340 160">
            <g id="whole" fill="#1B5E20" stroke="#1B5E20" stroke-width="2">
                <circle id="leader" cx="328" cy="300" r="13"/>
                <circle class="follower" cx="364" cy="300" r="13"/>
                <circle class="follower" cx="400" cy="300" r="13"/>
                <circle class="follower" cx="436" cy="300" r="13"/>
                <circle class="follower" cx="472" cy="300" r="13"/>
            </g>
        </svg>
    </div>
    <div class="page-loader-text">Memuat halaman...</div>
</div>

{{-- NAVBAR --}}
<nav class="navbar navbar-expand-lg navbar-dark">
    <div class="container-fluid px-3">

        {{-- KIRI: toggle + logo --}}
        <div class="d-flex align-items-center gap-2">
            <div class="toggle-btn" id="sidebarToggle">
                <i class="fas fa-bars" id="toggleIcon"></i>
            </div>
            <a class="navbar-brand d-flex align-items-center gap-2 mb-0" href="{{ route('user.dashboard') }}">
                <img src="/images/logo-ogekwali.png"
                     alt="Logo" class="navbar-logo"
                     onerror="this.style.display='none'">
                <span class="brand-name">Ogek Wali</span>
            </a>
        </div>

        {{-- KANAN: nama user + logout --}}
        <div class="d-flex align-items-center gap-2 ms-auto">
            <span class="navbar-user">
                <i class="fas fa-user-circle me-1"></i>
                {{ Auth::guard('web')->user()->nama ?? 'User' }}
            </span>
            <form action="{{ route('user.logout') }}" method="POST" class="mb-0">
                @csrf
                <button type="submit" class="btn btn-logout-nav">
                    <i class="fas fa-sign-out-alt me-1"></i>
                    <span class="d-none d-sm-inline">Keluar</span>
                </button>
            </form>
        </div>

    </div>

    {{-- WATERMARK NAVBAR --}}
    <div class="navbar-watermark">
        @if(request()->routeIs('user.dashboard'))
            <i class="fas fa-home"></i>
        @elseif(request()->routeIs('user.laporan.create'))
            <i class="fas fa-plus-circle"></i>
        @elseif(request()->routeIs('user.laporan*'))
            <i class="fas fa-list"></i>
        @elseif(request()->routeIs('user.feed*'))
            <i class="fas fa-newspaper"></i>
        @else
            <i class="fas fa-landmark"></i>
        @endif
    </div>
</nav>

{{-- HOVER ZONE (desktop) --}}
<div id="hoverZone"></div>

{{-- PAGE WRAPPER --}}
<div class="page-wrapper">

    {{-- SIDEBAR (desktop) --}}
    <div id="sidebar">
        <ul class="nav flex-column sidebar-nav">
            <li class="nav-item">
                <a href="{{ route('user.dashboard') }}"
                   class="nav-link {{ request()->routeIs('user.dashboard') ? 'active' : '' }}">
                    <i class="fas fa-home me-2"></i> Dashboard
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('user.laporan.create') }}"
                   class="nav-link {{ request()->routeIs('user.laporan.create') ? 'active' : '' }}">
                    <i class="fas fa-plus-circle me-2"></i> Buat Laporan
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('user.laporan.index') }}"
                   class="nav-link {{ request()->routeIs('user.laporan.index') ? 'active' : '' }}">
                    <i class="fas fa-list me-2"></i> Riwayat Laporan
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('user.feed.index') }}"
                   class="nav-link {{ request()->routeIs('user.feed*') ? 'active' : '' }}">
                    <i class="fas fa-newspaper me-2"></i> Feed Laporan
                </a>
            </li>
        </ul>

        {{-- WATERMARK SIDEBAR --}}
        <div class="sidebar-watermark">
            @if(request()->routeIs('user.dashboard'))
                <i class="fas fa-home"></i>
            @elseif(request()->routeIs('user.laporan.create'))
                <i class="fas fa-plus-circle"></i>
            @elseif(request()->routeIs('user.laporan*'))
                <i class="fas fa-list"></i>
            @elseif(request()->routeIs('user.feed*'))
                <i class="fas fa-newspaper"></i>
            @else
                <i class="fas fa-landmark"></i>
            @endif
        </div>

        {{-- LOGOUT SIDEBAR (desktop) --}}
        <div style="position:absolute;bottom:1rem;left:0;right:0;padding:0 8px;">
            <hr style="border-color:rgba(255,255,255,0.15);margin-bottom:0.75rem;">
            <form action="{{ route('user.logout') }}" method="POST">
                @csrf
                <button type="submit"
                    style="width:100%;background:rgba(255,255,255,0.1);
                    border:1.5px solid rgba(255,255,255,0.2);
                    color:rgba(255,255,255,0.85);border-radius:8px;
                    padding:0.55rem 1rem;font-size:0.85rem;font-weight:600;
                    cursor:pointer;transition:all 0.2s;text-align:left;
                    display:flex;align-items:center;gap:8px;">
                    <i class="fas fa-sign-out-alt" style="width:18px;"></i>
                    Keluar
                </button>
            </form>
        </div>
    </div>

    {{-- MAIN CONTENT --}}
    <div id="mainContent">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show">
                <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show">
                <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @yield('content')
    </div>

</div>

{{-- BOTTOM NAVIGATION (mobile only) --}}
<nav class="bottom-nav">
    <div class="bottom-nav-inner">

        {{-- Dashboard --}}
        <a href="{{ route('user.dashboard') }}"
           class="bottom-nav-item {{ request()->routeIs('user.dashboard') ? 'active' : '' }}">
            <i class="fas fa-home"></i>
            <span>Beranda</span>
        </a>

        {{-- Riwayat --}}
        <a href="{{ route('user.laporan.index') }}"
           class="bottom-nav-item {{ request()->routeIs('user.laporan.index') ? 'active' : '' }}">
            <i class="fas fa-list"></i>
            <span>Riwayat</span>
        </a>

        {{-- Buat Laporan (tengah/menonjol) --}}
        <a href="{{ route('user.laporan.create') }}" class="bottom-nav-center">
            <div class="bottom-nav-center-btn">
                <i class="fas fa-plus"></i>
            </div>
            <span>Laporan</span>
        </a>

        {{-- Feed --}}
        <a href="{{ route('user.feed.index') }}"
           class="bottom-nav-item {{ request()->routeIs('user.feed*') ? 'active' : '' }}">
            <i class="fas fa-newspaper"></i>
            <span>Feed</span>
        </a>

        {{-- Logout --}}
        <form action="{{ route('user.logout') }}" method="POST" class="mb-0">
            @csrf
            <button type="submit" class="bottom-nav-item border-0"
                    style="background:transparent;">
                <i class="fas fa-sign-out-alt"></i>
                <span>Keluar</span>
            </button>
        </form>

    </div>
</nav>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    const toggleBtn  = document.getElementById('sidebarToggle');
    const sidebar    = document.getElementById('sidebar');
    const toggleIcon = document.getElementById('toggleIcon');
    const hoverZone  = document.getElementById('hoverZone');

    if (toggleBtn && sidebar) {
        let isCollapsed  = false;
        let hoverTimeout = null;

        function openSidebar() {
            sidebar.classList.remove('collapsed');
            if (toggleIcon) toggleIcon.classList.replace('fa-bars-staggered', 'fa-bars');
            isCollapsed = false;
        }

        function closeSidebar() {
            sidebar.classList.add('collapsed');
            if (toggleIcon) toggleIcon.classList.replace('fa-bars', 'fa-bars-staggered');
            isCollapsed = true;
        }

        toggleBtn.addEventListener('click', function () {
            isCollapsed ? openSidebar() : closeSidebar();
        });

        if (hoverZone) {
            hoverZone.addEventListener('mouseenter', function () {
                if (isCollapsed) hoverTimeout = setTimeout(openSidebar, 200);
            });
        }

        sidebar.addEventListener('mouseleave', function () {
            clearTimeout(hoverTimeout);
            if (!isCollapsed) hoverTimeout = setTimeout(closeSidebar, 500);
        });

        sidebar.addEventListener('mouseenter', function () {
            clearTimeout(hoverTimeout);
        });
    }

    // ══════════════════════════════
    // HOPDOT LOADER ANIMATION (GSAP)
    // Sumber: freefrontend.com/javascript-loaders (Hopdot Loader by Chris Gannon)
    // ══════════════════════════════
    (function () {
        if (typeof gsap === 'undefined') return;

        const blendEases = (startEase, endEase, blender) => {
            const s = gsap.parseEase(startEase);
            const e = gsap.parseEase(endEase);
            const b = gsap.parseEase(blender || 'power3.inOut');
            return function (v) {
                const bl = b(v);
                return s(v) * (1 - bl) + e(v) * bl;
            };
        };

        gsap.set('#mainSVG', { visibility: 'visible' });

        const tl = gsap.timeline({ repeat: -1 });
        tl.to('#leader', {
            duration: 4,
            x: 36 * 3,
            ease: blendEases('circ.in', 'expo')
        })
        .to('.follower', {
            duration: 2,
            svgOrigin: gsap.utils.wrap(['328 300', '364 300', '400 300', '436 300', '472 300']),
            rotation: -180,
            stagger: { amount: 2 },
            ease: blendEases('circ.in', 'expo')
        }, 0)
        .to('#whole', {
            x: 36,
            duration: 5,
            ease: 'linear'
        }, 0)
        .to('.follower', {
            duration: 1.5,
            stagger: { amount: 1, repeat: 1, yoyo: true },
            ease: blendEases('power3.in', 'expo'),
            fillOpacity: 0
        }, 0);

        tl.timeScale(3);
    })();

// ══════════════════════════════
    // PAGE LOADING OVERLAY
    // Muncul setiap pindah halaman: klik menu sidebar/bottom nav,
    // logout, atau link apa saja di dalam mainContent.
    // ══════════════════════════════
    (function () {
        const loader = document.getElementById('pageLoader');
        if (!loader) return;

        const LOADER_DELAY = 700; // ubah durasi (ms) sesuka kamu

        function showLoader() {
            loader.classList.add('active');
        }

        // Tangkap klik semua link internal (bukan link luar/tab baru/anchor)
        document.addEventListener('click', function (e) {
            const link = e.target.closest('a');
            if (!link) return;

            const href = link.getAttribute('href');
            if (!href) return;
            if (href.startsWith('#')) return;               // anchor di halaman yg sama
            if (href.startsWith('javascript:')) return;      // link non-navigasi
            if (link.target === '_blank') return;            // buka tab baru
            if (e.ctrlKey || e.metaKey || e.shiftKey) return; // user buka tab baru manual

            e.preventDefault();
            showLoader();

            setTimeout(function () {
                window.location.href = href;
            }, LOADER_DELAY);
        });

        // Tangkap submit semua form (logout, dsb)
        document.querySelectorAll('form').forEach(function (form) {
            form.addEventListener('submit', function (e) {
                if (form.dataset.delayed) return; // sudah pernah lewat delay, biarkan submit asli
                e.preventDefault();
                showLoader();

                setTimeout(function () {
                    form.dataset.delayed = 'true';
                    form.submit();
                }, LOADER_DELAY);
            });
        });

        // Kalau user menekan tombol "back" browser dan halaman diambil dari
        // bfcache, overlay harus disembunyikan lagi karena tidak ada reload baru.
        window.addEventListener('pageshow', function (e) {
            if (e.persisted) loader.classList.remove('active');
        });
    })();
</script>

@yield('scripts')
</body>
</html>
