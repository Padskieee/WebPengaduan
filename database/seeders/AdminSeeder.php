<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        // Hapus data lama agar tidak duplikat
        DB::table('admin')->truncate();

        DB::table('admin')->insert([
            // Admin 1 - existing
            [
                'nama_admin' => 'Administrator',
                'email'      => 'admin@ogekwali.com',
                'password'   => Hash::make('admin123'),
                'no_hp'      => '081100000000',
                'created_at' => now(),
            ],
            // Admin 2 - baru (sesuaikan datanya)
            [
                'nama_admin' => 'Petugas Kominfo',
                'email'      => 'kominfo@ogekwali.com',
                'password'   => Hash::make('kominfo123'),
                'no_hp'      => '081200000000',
                'created_at' => now(),
            ],
        ]);
    }
}
