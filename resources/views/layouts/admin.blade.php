<!DOCTYPE html>
    <html lang="id">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Admin OGEK WALI - @yield('title')</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Pacifico&display=swap" rel="stylesheet">
        <link href="/css/ogekwali.css" rel="stylesheet">
        <style>
            :root {
                --hijau-tua:   #1B5E20;
                --hijau-sedang:#2E7D32;
                --hijau-muda:  #4CAF50;
            }

            .shape {
                position: fixed;
                z-index: 0;
                pointer-events: none;
                border-radius: 40px;
            }

            .shape-1 { width:550px; height:550px; background:rgba(255,255,255,0.08); top:-180px; right:-120px; transform:rotate(-20deg); border-radius:80px; }
            .shape-2 { width:380px; height:380px; background:rgba(0,0,0,0.15); top:80px; right:120px; transform:rotate(25deg); border-radius:60px; }
            .shape-3 { width:300px; height:300px; background:rgba(255,255,255,0.07); top:300px; right:350px; transform:rotate(-10deg); border-radius:50px; }
            .shape-4 { width:450px; height:450px; background:rgba(0,0,0,0.12); bottom:-150px; left:-100px; transform:rotate(15deg); border-radius:70px; }
            .shape-5 { width:250px; height:250px; background:rgba(255,255,255,0.06); bottom:100px; left:180px; transform:rotate(-25deg); border-radius:40px; }
            .shape-6 { width:650px; height:650px; background:rgba(0,0,0,0.08); top:30%; right:-250px; transform:rotate(10deg); border-radius:90px; }

            * { font-family: 'Inter', sans-serif; }

            body {
                background-color: #1B5E20;
                min-height: 100vh;
                margin: 0;
                position: relative;
                overflow-x: hidden;
            }

            /* NAVBAR */
            .navbar {
                background: linear-gradient(135deg, #1B5E20, #2E7D32) !important;
                box-shadow: 0 2px 8px rgba(0,0,0,0.2);
                position: fixed;
                top: 0;
                left: 0;
                right: 0;
                z-index: 100;
                height: 60px;
                overflow: hidden;
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
                width: 32px;
                height: auto;
                object-fit: contain;
                filter: drop-shadow(1px 1px 2px rgba(0,0,0,0.3));
            }

            .navbar .btn {
                display: flex;
                align-items: center;
                height: 32px;
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
            }

            .toggle-btn:hover { background: rgba(255,255,255,0.25); }

            /* PAGE WRAPPER — mulai di bawah navbar */
            .page-wrapper {
                display: flex;
                min-height: 100vh;
                padding-top: 60px; /* tinggi navbar */
                position: relative;
                z-index: 1;
            }

            /* SIDEBAR — fixed, tidak ikut scroll */
            #sidebar {
                background: #ffffff;
                width: 240px;
                min-width: 240px;
                position: fixed;        /* ← kunci utama */
                top: 60px;              /* tepat di bawah navbar */
                left: 0;
                height: calc(100vh - 60px); /* penuh sampai bawah */
                overflow-y: auto;       /* scroll sendiri kalau konten panjang */
                overflow-x: hidden;
                transition: width 0.3s ease, min-width 0.3s ease;
                box-shadow: 2px 0 8px rgba(0,0,0,0.15);
                border-right: 1px solid #E0E0E0;
                z-index: 99;
            }

            #sidebar.collapsed {
                width: 0;
                min-width: 0;
                padding: 0;
            }

            .sidebar-watermark {
                position: absolute;
                right: -10px;
                bottom: -10px;
                font-size: 7rem;
                color: rgba(137,137,137,0.34);
                pointer-events: none;
                line-height: 1;
            }

            .sidebar-label {
                color: #2E7D32;
                font-size: 0.7rem;
                font-weight: 700;
                letter-spacing: 1.5px;
                text-transform: uppercase;

                padding: 0.6rem 1.2rem 0.3rem;
                line-height: 1;
            }

            .sidebar-nav .nav-link {
                display: flex;
                align-items: center;
                gap: 10px;

                height: 42px;
                padding: 0 1.2rem;

                color: #616161;
                border-radius: 8px;
                margin: 2px 8px;
                font-size: 0.88rem;

                transition: all 0.2s;
                white-space: nowrap;

                .sidebar-nav .nav-link i {
                width: 18px;
                text-align: center;
                font-size: 0.9rem;
                display: flex;
                align-items: center;
                justify-content: center;
                }
            }

            .sidebar-nav .nav-link:hover,
            .sidebar-nav .nav-link.active {
                background: #E8F5E9;
                color: #1B5E20;
                font-weight: 600;
            }

            .sidebar-nav .nav-link.active {
                border-left: 3px solid #2E7D32;
            }

            .sidebar-nav .nav-link i {
                width: 18px;
                text-align: center;
                font-size: 0.9rem;
                display: flex;
                align-items: center;
                justify-content: center;
            }

            /* HOVER ZONE */
            #hoverZone {
                position: fixed;
                left: 0;
                top: 60px;
                width: 8px;
                height: calc(100vh - 60px);
                z-index: 999;
            }

            /* MAIN CONTENT — beri margin kiri sebesar lebar sidebar */
            #mainContent {
                flex: 1;
                margin-left: 240px; /* sama dengan lebar sidebar */
                padding: 2rem;
                overflow-x: hidden;
                position: relative;
                z-index: 1;
                background: #f0f2f5;
                min-height: calc(100vh - 60px);
                transition: margin-left 0.3s ease;
            }

            #mainContent.expanded {
                margin-left: 0;
            }

            /* CARDS */
            .card {
                border: none;
                border-radius: 12px;
                box-shadow: 0 2px 8px rgba(0,0,0,0.08);
            }

            .card-header {
                background-color: var(--hijau-tua);
                color: white;
                border-radius: 12px 12px 0 0 !important;
                font-weight: 600;
                padding: 0.85rem 1.25rem;
            }

            .stat-card {
                border-radius: 12px;
                padding: 1.2rem;
                color: white;
                position: relative;
                overflow: hidden;
            }

            .stat-card .icon-bg {
                position: absolute;
                right: -10px;
                bottom: -10px;
                font-size: 4rem;
                opacity: 0.15;
            }

            .btn-primary {
                background-color: var(--hijau-sedang);
                border-color: var(--hijau-sedang);
            }

            .btn-primary:hover {
                background-color: var(--hijau-tua);
                border-color: var(--hijau-tua);
            }

            .badge-menunggu    { background:#FFC107; color:#000; }
            .badge-diverifikasi{ background:#2196F3; color:#fff; }
            .badge-diproses    { background:#FF9800; color:#fff; }
            .badge-selesai     { background:#4CAF50; color:#fff; }
            .badge-ditolak     { background:#F44336; color:#fff; }

            .navbar .container-fluid {
                height: 100%;
            }

            .navbar .container-fluid > div {
                height: 100%;
                display: flex;
                align-items: center;
            }

            .logout-btn {
                background: rgba(255,255,255,0.15);
                border: 1px solid rgba(255,255,255,0.3);
                color: white;
                border-radius: 8px;
                transition: all 0.2s;
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
        @stack('styles')
        @yield('styles')
        <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js"></script>
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

    <div class="shape shape-1"></div>
    <div class="shape shape-2"></div>
    <div class="shape shape-3"></div>
    <div class="shape shape-4"></div>
    <div class="shape shape-5"></div>
    <div class="shape shape-6"></div>

    {{-- NAVBAR --}}
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container-fluid px-4">
            <div class="d-flex align-items-center gap-3 h-100">
                <div class="toggle-btn" id="sidebarToggle">
                    <i class="fas fa-bars" id="toggleIcon"></i>
                </div>
                <a class="navbar-brand d-flex align-items-center gap-2 mb-0" href="#">
                    <img src="/images/logo-ogekwali.png"
                        alt="Logo" class="navbar-logo"
                        onerror="this.style.display='none'">
                    <span class="brand-name">Ogek Wali</span>
                </a>
                <span class="badge text-bg-warning text-dark fw-600 small">Admin</span>
            </div>
            <div class="d-flex align-items-center gap-3 h-100">
                <span class="text-white-50 small">
                    <i class="fas fa-user-shield me-1"></i>
                    {{ Auth::guard('admin')->user()->nama_admin ?? 'Admin' }}
                </span>
                <form action="{{ route('admin.logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-sm btn-outline-light logout-btn">
                        <i class="fas fa-sign-out-alt me-1"></i> Keluar
                    </button>
                </form>
            </div>
        </div>

        <div class="navbar-watermark">
            @if(request()->routeIs('admin.dashboard'))
                <i class="fas fa-chart-pie"></i>
            @elseif(request()->routeIs('admin.laporan*'))
                <i class="fas fa-inbox"></i>
            @elseif(request()->routeIs('admin.proses*'))
                <i class="fas fa-tasks"></i>
            @elseif(request()->routeIs('admin.hasil*'))
                <i class="fas fa-check-double"></i>
            @elseif(request()->routeIs('admin.kategori*'))
                <i class="fas fa-tags"></i>
            @elseif(request()->routeIs('admin.user*'))
                <i class="fas fa-users"></i>
            @else
                <i class="fas fa-landmark"></i>
            @endif
        </div>
    </nav>

    {{-- HOVER ZONE --}}
    <div id="hoverZone"></div>

    {{-- PAGE WRAPPER --}}
    <div class="page-wrapper">

        {{-- SIDEBAR --}}
        <div id="sidebar">

            <ul class="nav flex-column sidebar-nav">

                <div class="sidebar-label">Menu Utama</div>
                <li class="nav-item">
                    <a href="{{ route('admin.dashboard') }}"
                    class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                        <i class="fas fa-chart-pie"></i> Dashboard
                    </a>
                </li>

                <div class="sidebar-label mt-2">Kelola Laporan</div>
                <li class="nav-item">
                    <a href="{{ route('admin.laporan.index') }}"
                    class="nav-link {{ request()->routeIs('admin.laporan*') ? 'active' : '' }}">
                        <i class="fas fa-inbox"></i> Laporan Masuk
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.hasil.index') }}"
                    class="nav-link {{ request()->routeIs('admin.hasil*') ? 'active' : '' }}">
                        <i class="fas fa-check-double"></i> Hasil Penyelesaian
                    </a>
                </li>

                <div class="sidebar-label mt-2">Master Data</div>
                <li class="nav-item">
                    <a href="{{ route('admin.kategori.index') }}"
                    class="nav-link {{ request()->routeIs('admin.kategori*') ? 'active' : '' }}">
                        <i class="fas fa-tags"></i> Kategori Laporan
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.user.index') }}"
                    class="nav-link {{ request()->routeIs('admin.user*') ? 'active' : '' }}">
                        <i class="fas fa-users"></i> Data User
                    </a>
                </li>

            </ul>

            <div class="sidebar-watermark">
                @if(request()->routeIs('admin.dashboard'))
                    <i class="fas fa-chart-pie"></i>
                @elseif(request()->routeIs('admin.laporan*'))
                    <i class="fas fa-inbox"></i>
                @elseif(request()->routeIs('admin.proses*'))
                    <i class="fas fa-tasks"></i>
                @elseif(request()->routeIs('admin.hasil*'))
                    <i class="fas fa-check-double"></i>
                @elseif(request()->routeIs('admin.kategori*'))
                    <i class="fas fa-tags"></i>
                @elseif(request()->routeIs('admin.user*'))
                    <i class="fas fa-users"></i>
                @else
                    <i class="fas fa-landmark"></i>
                @endif
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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const toggleBtn   = document.getElementById('sidebarToggle');
        const sidebar     = document.getElementById('sidebar');
        const mainContent = document.getElementById('mainContent');
        const toggleIcon  = document.getElementById('toggleIcon');
        const hoverZone   = document.getElementById('hoverZone');

        let isCollapsed  = false;
        let hoverTimeout = null;

        function openSidebar() {
            sidebar.classList.remove('collapsed');
            mainContent.classList.remove('expanded');
            toggleIcon.classList.replace('fa-bars-staggered', 'fa-bars');
            isCollapsed = false;
        }

        function closeSidebar() {
            sidebar.classList.add('collapsed');
            mainContent.classList.add('expanded');
            toggleIcon.classList.replace('fa-bars', 'fa-bars-staggered');
            isCollapsed = true;
        }

        toggleBtn.addEventListener('click', function () {
            isCollapsed ? openSidebar() : closeSidebar();
        });

        hoverZone.addEventListener('mouseenter', function () {
            if (isCollapsed) {
                hoverTimeout = setTimeout(openSidebar, 200);
            }
        });

        sidebar.addEventListener('mouseleave', function () {
            clearTimeout(hoverTimeout);
            if (!isCollapsed) {
                hoverTimeout = setTimeout(closeSidebar, 500);
            }
        });

        sidebar.addEventListener('mouseenter', function () {
            clearTimeout(hoverTimeout);
        });

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
        // Muncul setiap pindah halaman: klik menu sidebar, logout,
        // atau link apa saja di dalam mainContent.
        // ══════════════════════════════
        (function () {
            const loader = document.getElementById('pageLoader');
            if (!loader) return;

            const LOADER_DELAY = 700; // durasi delay buatan (ms)

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
                    if (form.dataset.delayed) return; // sudah lewat delay, biarkan submit asli
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
    @stack('scripts')
    @yield('scripts')
    </body>
    </html>
