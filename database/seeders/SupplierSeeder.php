<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SupplierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data=[
            [
                'supplier_id' => 1,
                'supplier_kode' => 'SUP1',
                'supplier_nama' => 'elektronik jaya',
                'supplier_alamat' => 'malang'
            ],
            [
                'supplier_id' => 2,
                'supplier_kode' => 'SUP2',
                'supplier_nama' => 'perabot maju bersama',
                'supplier_alamat' => 'surabaya'
            ],
            [
                'supplier_id' => 3,
                'supplier_kode' => 'SUP3',
                'supplier_nama' => 'pakaian sejahtera',
                'supplier_alamat' => 'jombang'
            ]
        ];
        DB::table('m_supplier')->insert($data);
    }
}
