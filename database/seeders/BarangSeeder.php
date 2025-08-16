<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BarangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $barang = [
            ['nama_barang' => 'Laptop ASUS', 'kode_barang' => 'BRG001', 'jumlah_barang' => 10, 'lokasi_barang' => 'Gudang A', 'latitude' => -6.200000, 'longitude' => 106.816666, 'category_id' => 1],
            ['nama_barang' => 'Kaos Polos', 'kode_barang' => 'BRG002', 'jumlah_barang' => 50, 'lokasi_barang' => 'Gudang B', 'latitude' => -6.210000, 'longitude' => 106.820000, 'category_id' => 2],
            ['nama_barang' => 'Panci Stainless', 'kode_barang' => 'BRG003', 'jumlah_barang' => 20, 'lokasi_barang' => 'Gudang C', 'latitude' => -6.220000, 'longitude' => 106.825000, 'category_id' => 3],
            ['nama_barang' => 'Bola Sepak', 'kode_barang' => 'BRG004', 'jumlah_barang' => 15, 'lokasi_barang' => 'Gudang D', 'latitude' => -6.230000, 'longitude' => 106.830000, 'category_id' => 4],
            ['nama_barang' => 'Novel Fiksi', 'kode_barang' => 'BRG005', 'jumlah_barang' => 30, 'lokasi_barang' => 'Gudang E', 'latitude' => -6.240000, 'longitude' => 106.835000, 'category_id' => 5],
            ['nama_barang' => 'Mainan Robot', 'kode_barang' => 'BRG006', 'jumlah_barang' => 25, 'lokasi_barang' => 'Gudang F', 'latitude' => -6.250000, 'longitude' => 106.840000, 'category_id' => 6],
            ['nama_barang' => 'Lipstik Merah', 'kode_barang' => 'BRG007', 'jumlah_barang' => 40, 'lokasi_barang' => 'Gudang G', 'latitude' => -6.260000, 'longitude' => 106.845000, 'category_id' => 7],
            ['nama_barang' => 'Ban Motor', 'kode_barang' => 'BRG008', 'jumlah_barang' => 12, 'lokasi_barang' => 'Gudang H', 'latitude' => -6.270000, 'longitude' => 106.850000, 'category_id' => 8],
            ['nama_barang' => 'Obeng Set', 'kode_barang' => 'BRG009', 'jumlah_barang' => 18, 'lokasi_barang' => 'Gudang I', 'latitude' => -6.280000, 'longitude' => 106.855000, 'category_id' => 9],
            ['nama_barang' => 'Obeng Set', 'kode_barang' => 'BRG010', 'jumlah_barang' => 18, 'lokasi_barang' => 'Gudang I', 'latitude' => -6.280000, 'longitude' => 106.855000, 'category_id' => 9],
            ['nama_barang' => 'Obeng Set', 'kode_barang' => 'BRG011', 'jumlah_barang' => 18, 'lokasi_barang' => 'Gudang I', 'latitude' => -6.280000, 'longitude' => 106.855000, 'category_id' => 9],
            ['nama_barang' => 'Obeng Set', 'kode_barang' => 'BRG012', 'jumlah_barang' => 18, 'lokasi_barang' => 'Gudang I', 'latitude' => -6.280000, 'longitude' => 106.855000, 'category_id' => 9],
            ['nama_barang' => 'Obeng Set', 'kode_barang' => 'BRG013', 'jumlah_barang' => 18, 'lokasi_barang' => 'Gudang I', 'latitude' => -6.280000, 'longitude' => 106.855000, 'category_id' => 9],
            ['nama_barang' => 'Obeng Set', 'kode_barang' => 'BRG014', 'jumlah_barang' => 18, 'lokasi_barang' => 'Gudang I', 'latitude' => -6.280000, 'longitude' => 106.855000, 'category_id' => 9],
            ['nama_barang' => 'Obeng Set', 'kode_barang' => 'BRG015', 'jumlah_barang' => 18, 'lokasi_barang' => 'Gudang I', 'latitude' => -6.280000, 'longitude' => 106.855000, 'category_id' => 9],
            ['nama_barang' => 'Obeng Set', 'kode_barang' => 'BRG016', 'jumlah_barang' => 18, 'lokasi_barang' => 'Gudang I', 'latitude' => -6.280000, 'longitude' => 106.855000, 'category_id' => 9],
            ['nama_barang' => 'Obeng Set', 'kode_barang' => 'BRG017', 'jumlah_barang' => 18, 'lokasi_barang' => 'Gudang I', 'latitude' => -6.280000, 'longitude' => 106.855000, 'category_id' => 9],
            ['nama_barang' => 'Meja Kayu', 'kode_barang' => 'BRG018', 'jumlah_barang' => 5, 'lokasi_barang' => 'Gudang J', 'latitude' => -6.290000, 'longitude' => 106.860000, 'category_id' => 10],
        ];

        foreach ($barang as $data) {
            DB::table('barang')->insert(array_merge($data, [
                'created_at' => now(),
                'updated_at' => now(),
            ]));
        }
    }
}
