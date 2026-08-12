<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - OGEK WALI</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Pacifico&display=swap" rel="stylesheet">

    <style>

    .logo-img {
        width: 60px;
        height: auto;
        object-fit: contain;
        border-radius: 0;
        border: none;
        margin: 0 auto 0.5rem;
        display: block;
        filter: drop-shadow(2px 2px 4px rgba(0,0,0,0.2));
        }

    .brand-name {
        font-family: 'Pacifico', cursive;
        font-size: 2.8rem;
        font-weight: 400;
        margin-bottom: 0.25rem;
        text-shadow: 2px 2px 4px rgba(0,0,0,0.2);
        }
        :root {
            --hijau-tua:    #1B5E20;
            --hijau-sedang: #2E7D32;
            --hijau-muda:   #4CAF50;
        }

        * { font-family: 'Inter', sans-serif; }

        body {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background-image: url('/images/sibolga.jpg');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
        }

        /* Overlay gelap di atas foto */
        body::before {
            content: '';
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.55);
            z-index: 0;
        }

        .login-wrapper {
            position: relative;
            z-index: 1;
            width: 200%;
            max-width: 520px;
            padding: 1rem;
        }

        .login-card {
            background: white;
            border-radius: 16px;
            box-shadow: 0 24px 64px rgba(0,0,0,0.35);
            overflow: hidden;
        }

        .login-header {
            background: linear-gradient(135deg, #1B5E20, #2E7D32);
            padding: 2.5rem 2rem;
            text-align: center;
            color: white;
        }

        .login-header p {
            font-size: 0.85rem;
            opacity: 0.85;
            margin: 0;
            margin-top: 0.8rem;
        }

        .login-body { padding: 2.5rem; }

        .form-label {
            font-size: 0.85rem;
            font-weight: 600;
            color: #424242;
        }

        .input-group-text {
            background: #f5f5f5;
            border: 1.5px solid #e0e0e0;
            border-right: none;
            color: #757575;
        }

        .form-control {
            border: 1.5px solid #e0e0e0;
            border-left: none;
            padding: 0.65rem 1rem;
            font-size: 0.9rem;
            transition: all 0.2s;
            cursor: text;
        }

        .form-control:focus {
            border-color: #2E7D32;
            box-shadow: 0 0 0 3px rgba(46,125,50,0.15);
        }

        .form-control:focus + .input-group-text,
        .input-group:focus-within .input-group-text {
            border-color: #2E7D32;
        }

        .input-group {
            border-radius: 8px;
            overflow: hidden;
        }

        .btn-login {
            background: linear-gradient(135deg, #1B5E20, #2E7D32);
            color: white;
            border: none;
            border-radius: 8px;
            padding: 0.8rem;
            font-weight: 600;
            font-size: 1rem;
            width: 100%;
            transition: all 0.2s;
            margin-top: 0.5rem;
        }

        .btn-login:hover {
            background: linear-gradient(135deg, #2E7D32, #4CAF50);
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(27,94,32,0.35);
        }

        .btn-login:disabled {
            opacity: 0.75;
            cursor: not-allowed;
            transform: none;
            box-shadow: none;
        }

        .divider {
            text-align: center;
            position: relative;
            margin: 1.5rem 0;
        }

        .divider::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 0; right: 0;
            height: 1px;
            background: #e0e0e0;
        }

        .divider span {
            background: white;
            padding: 0 0.75rem;
            font-size: 0.8rem;
            color: #9e9e9e;
            position: relative;
        }

        .link-register {
            color: #2E7D32;
            font-weight: 600;
            text-decoration: none;
            font-size: 0.95rem;
        }

        .link-register:hover { color: #1B5E20; text-decoration: underline; }

        .footer-note {
            text-align: center;
            font-size: 0.78rem;
            color: #9e9e9e;
            padding: 1rem 2rem;
            border-top: 1px solid #f0f0f0;
        }

        .btn-switch-admin {
            border-radius: 8px;
            font-size: 0.88rem;
            font-weight: 600;
            padding: 0.7rem;
            border: 1.5px solid #e0e0e0;
            color: #616161;
            width: 100%;
            background: white;
            transition: all 0.2s;
        }

        .btn-switch-admin:hover {
            border-color: #2E7D32;
            color: #1B5E20;
            background: #f1f8f1;
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

        .page-loader-text {
            font-size: 0.85rem;
            font-weight: 600;
            color: #1B5E20;
            letter-spacing: 0.02em;
        }
    </style>
</head>
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js"></script>
<script>
    function togglePassword(inputId, eyeId) {
        const input = document.getElementById(inputId);
        const eye   = document.getElementById(eyeId);
        if (input.type === 'password') {
            input.type = 'text';
            eye.classList.replace('fa-eye', 'fa-eye-slash');
        } else {
            input.type = 'password';
            eye.classList.replace('fa-eye-slash', 'fa-eye');
        }
    }
</script>
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
    <div class="page-loader-text" id="pageLoaderText">Memuat halaman...</div>
</div>

<div class="login-wrapper">
    <div class="login-card">

        {{-- HEADER --}}
        <div class="login-header">
            <img src="/images/logo-ogekwali.png"
                alt="Logo Ogek Wali"
                class="logo-img"
                onerror="this.style.display='none'">
            <h4 class="brand-name">Ogek Wali</h4>
            <p>Sistem Pengaduan Masyarakat Kota Sibolga</p>
        </div>

        {{-- FORM --}}
        <div class="login-body">
            <h6 class="fw-bold mb-4" style="color:#1B5E20;">
                <i class="fas fa-sign-in-alt me-2"></i>Masuk ke Akun Anda
            </h6>

            @if($errors->any())
                <div class="alert alert-danger py-2 px-3 rounded-3 mb-3">
                    <i class="fas fa-exclamation-circle me-2"></i>{{ $errors->first() }}
                </div>
            @endif

            @if(session('success'))
                <div class="alert alert-success py-2 px-3 rounded-3 mb-3">
                    <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                </div>
            @endif

            <form action="{{ route('user.login') }}" method="POST" id="loginForm">
                @csrf

                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <div class="input-group">
                        <span class="input-group-text">
                            <i class="fas fa-envelope fa-sm"></i>
                        </span>
                        <input type="email" name="email"
                            class="form-control @error('email') is-invalid @enderror"
                            placeholder="Masukkan email anda"
                            value="{{ old('email') }}" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Password</label>
                    <div class="input-group">
                        <span class="input-group-text">
                            <i class="fas fa-lock fa-sm"></i>
                        </span>
                        <input type="password" name="password" id="passwordLogin"
                            class="form-control @error('password') is-invalid @enderror"
                            placeholder="Masukkan password anda" required>
                        <span class="input-group-text" onclick="togglePassword('passwordLogin', 'eyeLogin')"
                            style="cursor:pointer; border-left:none; border:1.5px solid #e0e0e0;">
                            <i class="fas fa-eye fa-sm" id="eyeLogin"></i>
                        </span>
                    </div>
                </div>

                <button type="submit" class="btn-login" id="loginSubmitBtn">
                    <i class="fas fa-sign-in-alt me-2"></i>Masuk
                </button>
            </form>

            {{-- DAFTAR --}}
            <div class="divider"><span>belum punya akun?</span></div>
            <div class="text-center mb-4">
                <a href="{{ route('user.register') }}" class="link-register">
                    <i class="fas fa-user-plus me-1"></i>Daftar Sekarang
                </a>
            </div>

            {{-- SWITCH TO ADMIN --}}
            <div style="padding: 0 2.5rem 1.5rem;">
            <a href="{{ route('admin.login') }}"
                class="btn btn-outline-secondary w-100"
                style="border-radius:8px; font-size:0.88rem; font-weight:600; padding:0.7rem; border:1.5px solid #e0e0e0; color:#616161;">
                <i class="fas fa-user me-2"></i>Masuk sebagai Admin
            </a>
        </div>

        </div>

        <div class="footer-note">
            &copy; {{ date('Y') }} OGEK WALI — Pemerintah Kota Sibolga
        </div>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
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
    // Muncul saat submit form login, atau saat klik link
    // "Daftar Sekarang" / "Masuk sebagai Admin" (berpindah halaman).
    // ══════════════════════════════
    (function () {
        const loader     = document.getElementById('pageLoader');
        const loaderText = document.getElementById('pageLoaderText');
        const loginForm  = document.getElementById('loginForm');
        const submitBtn  = document.getElementById('loginSubmitBtn');
        if (!loader) return;

        function showLoader(text) {
            if (text && loaderText) loaderText.textContent = text;
            loader.classList.add('active');
        }

        const LOADER_DELAY = 700; // ubah durasi (ms) sesuka kamu

        // Submit form login
        if (loginForm) {
            loginForm.addEventListener('submit', function (e) {
                if (loginForm.dataset.delayed) return; // sudah lewat delay, biarkan submit asli
                e.preventDefault();
                if (submitBtn) submitBtn.disabled = true;
                showLoader('Memproses login...');

                setTimeout(function () {
                    loginForm.dataset.delayed = 'true';
                    loginForm.submit();
                }, LOADER_DELAY);
            });
        }

        // Klik link navigasi lain di halaman ini (Daftar, Masuk sebagai Admin)
        document.addEventListener('click', function (e) {
            const link = e.target.closest('a');
            if (!link) return;

            const href = link.getAttribute('href');
            if (!href) return;
            if (href.startsWith('#')) return;
            if (href.startsWith('javascript:')) return;
            if (link.target === '_blank') return;
            if (e.ctrlKey || e.metaKey || e.shiftKey) return;

            e.preventDefault();
            showLoader('Memuat halaman...');

            setTimeout(function () {
                window.location.href = href;
            }, LOADER_DELAY);
        });

        // Kalau halaman diambil dari bfcache (tombol back browser), sembunyikan lagi
        window.addEventListener('pageshow', function (e) {
            if (e.persisted) {
                loader.classList.remove('active');
                if (submitBtn) submitBtn.disabled = false;
            }
        });
    })();
</script>
</body>
</html>
