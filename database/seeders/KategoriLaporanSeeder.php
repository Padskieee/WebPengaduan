<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KategoriLaporanSeeder extends Seeder
{
    public function run(): void
    {
        $kategoris = [
            'Agama',
            'Ekonomi dan Keuangan',
            'Kesehatan',
            'Kesetaraan Gender dan Sosial Inklusif',
            'Ketentraman, Ketertiban Umum dan Perlindungan Masyarakat',
            'Lingkungan Hidup dan Kehutanan',
            'Pekerjaan Umum dan Penataan Ruang',
            'Pembangunan Desa, Daerah Tertinggal, dan Transmigrasi',
            'Pendidikan dan Kebudayaan',
            'Pertanian dan Peternakan',
            'Politik dan Hukum',
            'Politisasi ASN',
            'Sosial dan Kesejahteraan',
            'SP4N-LAPOR!',
            'Energi dan Sumber Daya Alam',
            'Kekerasan di Satuan Pendidikan (Sekolah, Kampus, Lembaga Kursus)',
            'Kependudukan',
            'Ketenagakerjaan',
            'Netralitas ASN',
            'Pembangunan Desa, Daerah Tertinggal, Terdepan, Terluar, dan Transmigrasi',
            'Pemulihan Ekonomi Nasional',
            'Pencegahan dan Pemberantasan Penyalahgunaan dan Peredaran Gelap Narkotika dan Prekursor Narkotika (P4GN)',
            'Pendidikan',
            'Perairan',
            'Perhubungan',
            'Perlindungan Konsumen',
            'Program Makan Bergizi Gratis (MBG)',
            'Teknologi Informasi dan Komunikasi',
            'Topik Khusus',
            'Topik Lainnya',
        ];

        foreach ($kategoris as $nama) {
            DB::table('kategori_laporan')->insert([
                'nama_kategori' => $nama,
                'deskripsi'     => null,
                'created_at'    => now(),
            ]);
        }
    }
}
