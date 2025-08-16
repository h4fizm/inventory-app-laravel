<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kategori;

class KategoriController extends Controller
{
    // Hapus metode __construct() di sini

    public function index()
    {
        $data_kategori = Kategori::all();

        return view('menu.tambah-kategori', compact('data_kategori'));
    }
}