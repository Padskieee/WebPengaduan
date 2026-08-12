# OGEK WALI

**Sistem Pengaduan Masyarakat Kota Sibolga**

OGEK WALI adalah aplikasi web berbasis Laravel yang memfasilitasi masyarakat Kota Sibolga untuk menyampaikan pengaduan/laporan secara online, serta memudahkan pihak admin/Kominfo dalam mengelola, memverifikasi, dan menindaklanjuti laporan yang masuk.

## Daftar Isi

- [Fitur](#fitur)
- [Teknologi yang Digunakan](#teknologi-yang-digunakan)
- [Persyaratan Sistem](#persyaratan-sistem)
- [Instalasi](#instalasi)
- [Akun Default](#akun-default)
- [Struktur Role](#struktur-role)
- [Struktur Folder](#struktur-folder)
- [Kontribusi](#kontribusi)
- [Lisensi](#lisensi)

## Fitur

### Portal User (Masyarakat)
- Registrasi & login akun masyarakat
- Membuat laporan/pengaduan baru
- Melihat riwayat & status laporan yang pernah dibuat
- Melihat feed laporan publik dari masyarakat lain
- Notifikasi status laporan (menunggu, diverifikasi, diproses, selesai, ditolak)

### Portal Admin
- Login khusus admin (terpisah dari akun user)
- Dashboard ringkasan statistik laporan
- Kelola laporan masuk (verifikasi, proses, tolak)
- Kelola hasil penyelesaian laporan
- Kelola kategori laporan
- Kelola data user/masyarakat

## Teknologi yang Digunakan

- **Backend:** Laravel (PHP)
- **Frontend:** Blade Template, Bootstrap 5, Font Awesome 6
- **Animasi:** GSAP (loading overlay)
- **Database:** MySQL
- **Build Tool:** Vite

## Persyaratan Sistem

Pastikan sudah terinstall di komputer/server sebelum instalasi:

- PHP >= 8.1
- Composer
- Node.js & NPM
- MySQL / MariaDB
- Web server (XAMPP/Laragon, atau server lain yang mendukung PHP)

## Instalasi

1. **Clone repository**
   ```bash
   git clone https://github.com/Padskieee/WebPengaduan.git
   cd WebPengaduan
   ```

2. **Install dependency PHP**
   ```bash
   composer install
   ```

3. **Install dependency frontend**
   ```bash
   npm install
   ```

4. **Salin file environment**
   ```bash
   cp .env.example .env
   ```
   Buka file `.env`, sesuaikan konfigurasi berikut dengan environment kamu:
   - `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD` — koneksi database
   - `MAIL_MAILER`, `MAIL_HOST`, `MAIL_USERNAME`, `MAIL_PASSWORD`, dst — konfigurasi email untuk fitur autentikasi/notifikasi

5. **Generate application key**
   ```bash
   php artisan key:generate
   ```

6. **Buat database**
   Buat database baru (misalnya `ogekwali`) melalui phpMyAdmin atau command line MySQL, sesuaikan namanya dengan `DB_DATABASE` di `.env`.

7. **Jalankan migrasi & seeder**
   ```bash
   php artisan migrate --seed
   ```
   Perintah ini akan membuat seluruh tabel database sekaligus mengisi data awal (kategori laporan & akun admin default).

8. **Build asset frontend**
   ```bash
   npm run build
   ```

9. **Jalankan server lokal**
   ```bash
   php artisan serve
   ```
   Aplikasi dapat diakses melalui `http://localhost:8000`.

## Akun Default

Setelah menjalankan seeder, tersedia akun admin default untuk pengujian awal:

| Role  | Email                  | Password  |
|-------|-------------------------|-----------|
| Admin | admin@ogekwali.com      | admin123  |

> ⚠️ **Penting:** Segera ganti password akun default ini setelah login pertama kali, terutama sebelum aplikasi digunakan di lingkungan production. Jangan biarkan kredensial default tetap aktif pada server yang dapat diakses publik.

## Struktur Role

Aplikasi memiliki dua jenis pengguna dengan guard terpisah:

- **User (masyarakat)** — mendaftar mandiri melalui halaman registrasi, mengakses portal pelaporan.
- **Admin** — dikelola melalui seeder/database, mengakses portal pengelolaan laporan.

## Struktur Folder

```
├── app/                  # Controller, Model, Middleware
├── database/
│   ├── migrations/       # Struktur tabel database
│   └── seeders/          # Data awal (admin, kategori laporan)
├── resources/
│   └── views/            # Blade template (layout, user, admin)
├── routes/               # Definisi routing web
├── public/               # Asset publik & entry point aplikasi
```

## Kontribusi

Kontribusi, saran, dan laporan bug dapat diajukan melalui menu **Issues** pada repository ini.

## Lisensi

Project ini dikembangkan untuk keperluan Pemerintah Kota Sibolga.
