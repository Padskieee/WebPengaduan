<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi Email - Ogek Wali</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Segoe UI', Arial, sans-serif;
            background-color: #f0f4f0;
            padding: 40px 16px;
            color: #333;
        }

        .wrapper {
            max-width: 520px;
            margin: 0 auto;
        }

        .header {
            border-radius: 14px 14px 0 0;
            overflow: hidden;
            line-height: 0;
        }

        .header img {
            width: 100%;
            height: auto;
            display: block;
        }

        .body {
            background: #ffffff;
            padding: 36px 36px 28px;
        }

        .greeting {
            font-size: 16px;
            font-weight: 600;
            color: #1a1a1a;
            margin-bottom: 12px;
        }

        .body p {
            font-size: 14px;
            color: #555;
            line-height: 1.7;
            margin-bottom: 14px;
        }

        .btn-wrap {
            text-align: center;
            margin: 28px 0;
        }

        .btn-verify {
            display: inline-block;
            background: linear-gradient(135deg, #1B5E20, #2E7D32);
            color: #ffffff !important;
            text-decoration: none;
            padding: 14px 40px;
            border-radius: 10px;
            font-size: 15px;
            font-weight: 600;
            letter-spacing: 0.3px;
        }

        .info-box {
            background: #f8f9f8;
            border-left: 3px solid #2E7D32;
            border-radius: 0 8px 8px 0;
            padding: 12px 16px;
            font-size: 13px;
            color: #666;
            margin-bottom: 20px;
            line-height: 1.6;
        }

        .fallback {
            font-size: 12px;
            color: #999;
            line-height: 1.6;
            word-break: break-all;
        }

        .fallback a { color: #2E7D32; }

        .divider {
            border: none;
            border-top: 1px solid #eee;
            margin: 24px 0 20px;
        }

        .footer {
            background: #f0f4f0;
            border-radius: 0 0 14px 14px;
            padding: 20px 32px;
            text-align: center;
            font-size: 12px;
            color: #999;
            line-height: 1.7;
        }

        .footer strong { color: #2E7D32; }
    </style>
</head>
<body>
<div class="wrapper">

    {{-- Header --}}
    <div class="header">
        <img src="https://i.imgur.com/QeWVhql.png" alt="Ogek Wali">
    </div>

    {{-- Body --}}
    <div class="body">
        <p class="greeting">Halo, {{ $nama }}!</p>

        <p>
            Terima kasih telah mendaftar di <strong>Ogek Wali</strong> —
            platform pengaduan masyarakat Kota Sibolga.
        </p>

        <p>
            Untuk mengaktifkan akun kamu dan mulai menggunakan layanan ini,
            silakan klik tombol di bawah ini untuk memverifikasi alamat email kamu.
        </p>

        <div class="btn-wrap">
            <a href="{{ $url }}" class="btn-verify">
                ✅ Verifikasi Email Saya
            </a>
        </div>

        <div class="info-box">
            ⏱ Link verifikasi ini akan <strong>kedaluwarsa dalam 60 menit</strong>.
            Jika sudah lewat, kamu bisa meminta link baru dari halaman verifikasi.
        </div>

        <p>
            Jika kamu tidak merasa mendaftar akun di Ogek Wali,
            abaikan saja email ini — tidak ada tindakan lebih lanjut yang diperlukan.
        </p>

        <hr class="divider">

        <p class="fallback">
            Jika tombol di atas tidak berfungsi, salin dan tempel link berikut ke browser kamu:<br>
            <a href="{{ $url }}">{{ $url }}</a>
        </p>
    </div>

    {{-- Footer --}}
    <div class="footer">
        <strong>Ogek Wali</strong> &mdash; Sistem Pengaduan Masyarakat Kota Sibolga<br>
        Email ini dikirim secara otomatis, mohon tidak membalas email ini.
    </div>

</div>
</body>
</html>
