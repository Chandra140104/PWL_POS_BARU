<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BarangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data=[
            [
                'barang_id' => 1,
                'kategori_id' => 1,
                'barang_kode' => 'LMP',
                'barang_nama' => 'lampu',
                'harga_beli' => 20000,
                'harga_jual' => 25000
            ],
            [
                'barang_id' => 2,
                'kategori_id' => 1,
                'barang_kode' => 'HP',
                'barang_nama' => 'handphone',
                'harga_beli' => 5000000,
                'harga_jual' => 5500000
            ],
            [
                'barang_id' => 3,
                'kategori_id' => 1,
                'barang_kode' => 'LAPTOP',
                'barang_nama' => 'laptop',
                'harga_beli' => 7000000,
                'harga_jual' => 8000000
            ],
            [
                'barang_id' => 4,
                'kategori_id' => 1,
                'barang_kode' => 'MOUSE',
                'barang_nama' => 'mouse',
                'harga_beli' => 100000,
                'harga_jual' => 120000
            ],
            [
                'barang_id' => 5,
                'kategori_id' => 1,
                'barang_kode' => 'KB',
                'barang_nama' => 'keyboard',
                'harga_beli' => 100000,
                'harga_jual' => 130000
            ],
            [
                'barang_id' => 6,
                'kategori_id' => 2,
                'barang_kode' => 'GYG',
                'barang_nama' => 'gayung',
                'harga_beli' => 5000,
                'harga_jual' => 8000
            ],
            [
                'barang_id' => 7,
                'kategori_id' => 2,
                'barang_kode' => 'SP',
                'barang_nama' => 'sapu',
                'harga_beli' => 20000,
                'harga_jual' => 25000
            ],
            [
                'barang_id' => 8,
                'kategori_id' => 2,
                'barang_kode' => 'PEL',
                'barang_nama' => 'pel',
                'harga_beli' => 20000,
                'harga_jual' => 25000
            ],
            [
                'barang_id' => 9,
                'kategori_id' => 2,
                'barang_kode' => 'CIKRAK',
                'barang_nama' => 'cikrak',
                'harga_beli' => 15000,
                'harga_jual' => 20000
            ],
            [
                'barang_id' => 10,
                'kategori_id' => 2,
                'barang_kode' => 'KBL',
                'barang_nama' => 'kabel',
                'harga_beli' => 20000,
                'harga_jual' => 30000
            ],
            [
                'barang_id' => 11,
                'kategori_id' => 3,
                'barang_kode' => 'CLN',
                'barang_nama' => 'celana',
                'harga_beli' => 100000,
                'harga_jual' => 110000
            ],
            [
                'barang_id' => 12,
                'kategori_id' => 3,
                'barang_kode' => 'KMJ',
                'barang_nama' => 'kemeja',
                'harga_beli' => 120000,
                'harga_jual' => 130000
            ],
            [
                'barang_id' => 13,
                'kategori_id' => 3,
                'barang_kode' => 'TP',
                'barang_nama' => 'topi',
                'harga_beli' => 50000,
                'harga_jual' => 55000
            ],
            [
                'barang_id' => 14,
                'kategori_id' => 3,
                'barang_kode' => 'JKT',
                'barang_nama' => 'jaket',
                'harga_beli' => 200000,
                'harga_jual' => 250000
            ],
            [
                'barang_id' => 15,
                'kategori_id' => 3,
                'barang_kode' => 'DS',
                'barang_nama' => 'dasi',
                'harga_beli' => 20000,
                'harga_jual' => 25000
            ]
        ];
        DB::table('m_barang')->insert($data);
    }
}
