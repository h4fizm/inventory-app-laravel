<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KategoriSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $kategori = [
            'Elektronik',
            'Pakaian',
            'Alat Dapur',
            'Alat Olahraga',
            'Buku',
            'Mainan',
            'Kecantikan',
            'Otomotif',
            'Perkakas',
            'Furnitur',
        ];

        foreach ($kategori as $nama_kategori) {
            DB::table('kategori')->insert([
                'nama_kategori' => $nama_kategori,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}