<!DOCTYPE html>
<html lang="id">
<head>
    <link href="https://fonts.googleapis.com/css2?family=Pacifico&display=swap" rel="stylesheet">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi Email - OGEK WALI</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Segoe UI', sans-serif;
            min-height: 100vh;
            background: #f0f4f0;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .card {
            background: white;
            border-radius: 16px;
            overflow: hidden;
            width: 100%;
            max-width: 480px;
            box-shadow: 0 8px 32px rgba(0,0,0,0.10);
        }


        .login-header {
            background: #2d7a2d;
            padding: 32px 32px 28px;
            text-align: center;
            color: white;
        }

        .login-header .logo-img {
        height: auto;
        width: 55px;
        margin-bottom: 0.5rem;
        object-fit: contain;
        border-radius: 0;
        border: none;
        filter: drop-shadow(2px 2px 4px rgba(0,0,0,0.2));
        }

        .login-header .brand-name {
        font-family: 'Pacifico', cursive;
        font-size: 2.5rem;
        font-weight: 400;
        margin-bottom: 4px;
        text-shadow: 2px 2px 4px rgba(0,0,0,0.2);
        }

        .login-header p {
            font-size: 13px;
            opacity: 0.85;
            margin-bottom: 10px;
        }

        /* ===== BODY ===== */
        .card-body {
            padding: 36px 32px 32px;
            text-align: center;
        }

        .email-icon-wrap {
            width: 80px;
            height: 80px;
            background: #eaf5ea;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            animation: pulse 2.5s ease-in-out infinite;
        }

        .email-icon-wrap i { font-size: 34px; color: #2d7a2d; }

        @keyframes pulse {
            0%, 100% { box-shadow: 0 0 0 0 rgba(45,122,45,0.25); }
            50%       { box-shadow: 0 0 0 12px rgba(45,122,45,0); }
        }

        .card-body h2 {
            font-size: 20px;
            color: #1a1a1a;
            font-weight: 600;
            margin-bottom: 8px;
        }

        .card-body .desc {
            font-size: 14px;
            color: #666;
            line-height: 1.7;
        }

        .email-highlight {
            display: inline-block;
            background: #eaf5ea;
            color: #2d7a2d;
            font-weight: 600;
            font-size: 14px;
            padding: 6px 18px;
            border-radius: 20px;
            margin: 10px 0 18px;
        }

        .steps {
            background: #f8f9f8;
            border-radius: 10px;
            padding: 16px 20px;
            text-align: left;
            margin-bottom: 22px;
        }

        .steps .steps-label {
            font-size: 11px;
            color: #999;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            margin-bottom: 10px;
        }

        .steps ol { padding-left: 18px; }
        .steps ol li {
            font-size: 13px;
            color: #444;
            margin-bottom: 6px;
            line-height: 1.5;
        }

        .alert-success {
            background: #eaf5ea;
            border: 1px solid #b2d8b2;
            color: #276427;
            border-radius: 8px;
            padding: 12px 16px;
            font-size: 13px;
            margin-bottom: 16px;
            display: flex;
            align-items: center;
            gap: 8px;
            text-align: left;
        }

        .btn-resend {
            width: 100%;
            background: #2d7a2d;
            color: white;
            border: none;
            padding: 14px;
            border-radius: 10px;
            font-size: 15px;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.2s, opacity 0.2s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            margin-bottom: 12px;
        }

        .btn-resend:hover:not(:disabled) { background: #245f24; }
        .btn-resend:disabled { background: #aaa; cursor: not-allowed; }

        .resend-timer {
            font-size: 12px;
            color: #aaa;
            margin-bottom: 16px;
        }

        #countdown { font-weight: 600; color: #2d7a2d; }

        .divider {
            border: none;
            border-top: 1px solid #eee;
            margin: 4px 0 14px;
        }

        .btn-logout {
            background: none;
            border: none;
            color: #aaa;
            font-size: 13px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 5px;
            width: 100%;
            padding: 4px;
            transition: color 0.2s;
        }

        .btn-logout:hover { color: #666; }
    </style>
</head>
<body>

<div class="card">

    {{-- Header --}}
    <div class="login-header">
        <img src="/images/logo-ogekwali.png"
            alt="Logo Ogek Wali"
            class="logo-img"
            onerror="this.style.display='none'">
        <h4 class="brand-name">Ogek Wali</h4>
        <p>Sistem Pengaduan Masyarakat Kota Sibolga</p>
    </div>

    {{-- Body --}}
    <div class="card-body">

        <div class="email-icon-wrap">
            <i class="fas fa-envelope-open-text"></i>
        </div>

        <h2>Verifikasi Email Kamu</h2>
        <p class="desc">Kami telah mengirimkan link verifikasi ke:</p>

        <div class="email-highlight">{{ Auth::user()->email }}</div>

        <p class="desc" style="margin-bottom: 18px;">
            Klik link di email tersebut untuk mengaktifkan akun dan mulai menggunakan Ogek Wali.
        </p>

        <div class="steps">
            <div class="steps-label">Cara verifikasi</div>
            <ol>
                <li>Buka Gmail atau aplikasi email kamu</li>
                <li>Cari email dari <strong>{{ config('mail.from.name') }}</strong> (jika tidak ada bisa cek di folder spam)</li>
                <li>Klik tombol <strong>"Verify Email Address"</strong></li>
                <li>Kamu akan langsung masuk ke dashboard</li>
            </ol>
        </div>

        @if (session('success'))
            <div class="alert-success">
                <i class="fas fa-check-circle"></i>
                {{ session('success') }}
            </div>
        @endif

        <form method="POST" action="{{ route('user.verification.send') }}">
            @csrf
            <button type="submit" class="btn-resend" id="resend-btn">
                <i class="fas fa-paper-plane"></i>
                Kirim Ulang Email Verifikasi
            </button>
        </form>

        <div class="resend-timer" id="timer-wrap" style="display:none">
            Kirim ulang lagi dalam <span id="countdown">60</span> detik
        </div>

        <hr class="divider">

        <form method="POST" action="{{ route('user.logout') }}">
            @csrf
            <button type="submit" class="btn-logout">
                <i class="fas fa-sign-out-alt"></i>
                Gunakan akun lain
            </button>
        </form>

    </div>
</div>

<script>
    // Aktifkan countdown hanya setelah kirim ulang (ada session success)
    @if(session('success'))
    (function () {
        const btn = document.getElementById('resend-btn');
        const wrap = document.getElementById('timer-wrap');
        const tick = document.getElementById('countdown');
        let sisa = 60;

        btn.disabled = true;
        wrap.style.display = 'block';

        const timer = setInterval(() => {
            sisa--;
            tick.textContent = sisa;
            if (sisa <= 0) {
                clearInterval(timer);
                btn.disabled = false;
                wrap.style.display = 'none';
            }
        }, 1000);
    })();
    @endif
</script>

</body>
</html>
