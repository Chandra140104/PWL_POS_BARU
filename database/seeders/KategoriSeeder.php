<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\db;

class KategoriSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data=[
            [
                'kategori_id' => 1,
                'kategori_kode' => 'ELK',
                'kategori_nama' => 'elektronik',
            ],
            [
                'kategori_id' => 2,
                'kategori_kode' => 'RMH',
                'kategori_nama' => 'perabot rumah',
            ],
            [
                'kategori_id' => 3,
                'kategori_kode' => 'PAKAIAN',
                'kategori_nama' => 'pakaian',
            ],
            [
                'kategori_id' => 4,
                'kategori_kode' => 'ATK',
                'kategori_nama' => 'alat tulis kerja',
            ],
            [
                'kategori_id' => 5,
                'kategori_kode' => 'MAMI',
                'kategori_nama' => 'makanan minuman',
            ],
        ];
        DB::table('m_kategori')->insert($data);
    }
}
