<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB; // Tambahkan ini

class GeoDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Nonaktifkan pemeriksaan foreign key constraints sementara
        DB::statement('SET FOREIGN_KEY_CHECKS=0');

        // Pastikan tabel kosong sebelum seeding
        DB::table('districts')->truncate();
        DB::table('regencies')->truncate();
        DB::table('provinces')->truncate();

        // Data Contoh Provinsi
        $provinsiSumateraBarat = DB::table('provinces')->insertGetId([
            'name' => 'Sumatera Barat',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $provinsiJawaBarat = DB::table('provinces')->insertGetId([
            'name' => 'Jawa Barat',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Data Contoh Kota/Kabupaten
        $kotaPadang = DB::table('regencies')->insertGetId([
            'province_id' => $provinsiSumateraBarat,
            'name' => 'Kota Padang',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $kotaBukittinggi = DB::table('regencies')->insertGetId([
            'province_id' => $provinsiSumateraBarat,
            'name' => 'Kota Bukittinggi',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $kotaBandung = DB::table('regencies')->insertGetId([
            'province_id' => $provinsiJawaBarat,
            'name' => 'Kota Bandung',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Data Contoh Kecamatan
        DB::table('districts')->insert([
            [
                'regency_id' => $kotaPadang,
                'name' => 'Padang Barat',
                'postal_code' => '25112',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'regency_id' => $kotaPadang,
                'name' => 'Kuranji',
                'postal_code' => '25152',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'regency_id' => $kotaBukittinggi,
                'name' => 'Guguk Panjang',
                'postal_code' => '26136',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'regency_id' => $kotaBandung,
                'name' => 'Coblong',
                'postal_code' => '40132',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        // Aktifkan kembali pemeriksaan foreign key constraints
        DB::statement('SET FOREIGN_KEY_CHECKS=1');
    }
}
