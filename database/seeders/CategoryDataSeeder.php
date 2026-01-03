<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoryDataSeeder extends Seeder
{
    public function run(): void
    {
        $driver = DB::getDriverName();

        if ($driver === 'mysql') {
            DB::statement('SET FOREIGN_KEY_CHECKS=0');
        } elseif ($driver === 'sqlite') {
            DB::statement('PRAGMA foreign_keys=OFF');
        }

        DB::table('categories')->truncate();

        DB::table('categories')->insert([
            [
                'id' => 10,
                'name' => 'Papan Rustic',
                'deskripsi' => 'Koleksi papan bunga kayu bergaya rustic yang estetik.',
                'slug' => 'papan-rustic',
                'warna' => null,
                'ikon' => null,
                'is_active' => 1,
                'created_at' => '2026-01-03 08:10:10',
                'updated_at' => '2026-01-03 08:10:10',
            ],
            [
                'id' => 11,
                'name' => 'Akrilik',
                'deskripsi' => 'Papan ucapan modern dengan bahan akrilik mewah.',
                'slug' => 'akrilik',
                'warna' => null,
                'ikon' => null,
                'is_active' => 1,
                'created_at' => '2026-01-03 08:10:10',
                'updated_at' => '2026-01-03 08:10:10',
            ],
            [
                'id' => 12,
                'name' => 'Box Bunga',
                'deskripsi' => 'Rangkaian bunga eksklusif dalam kotak premium.',
                'slug' => 'box-bunga',
                'warna' => null,
                'ikon' => null,
                'is_active' => 1,
                'created_at' => '2026-01-03 08:10:10',
                'updated_at' => '2026-01-03 08:10:10',
            ],
        ]);

        if ($driver === 'mysql') {
            DB::statement('SET FOREIGN_KEY_CHECKS=1');
        } elseif ($driver === 'sqlite') {
            DB::statement('PRAGMA foreign_keys=ON');
        }
    }
}
