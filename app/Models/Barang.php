<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    protected $table = 'barang'; // Pastikan nama tabel di sini sudah benar

    protected $fillable = [
        'nama_barang',
        'kode_barang',
        'jumlah_barang',
        'lokasi_barang',
        'latitude',
        'longitude',
        'category_id',
    ];

    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'category_id');
    }
}