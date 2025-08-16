<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Kategori;
use App\Models\Barang;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Menampilkan dashboard dengan data ringkasan.
     */
    public function index()
    {
        // Menghitung total data
        $totalUsers = User::count();
        $totalKategori = Kategori::count();
        $totalBarang = Barang::count();

        // Mengambil data barang dengan stok kritis (kurang dari 5)
        $barangKritis = Barang::with('kategori')
            ->where('jumlah_barang', '<', 5)
            ->latest()
            ->get();

        $jumlahBarangKritis = $barangKritis->count();

        return view('menu.dashboard', compact('totalUsers', 'totalKategori', 'totalBarang', 'barangKritis', 'jumlahBarangKritis'));
    }

    /**
     * Menampilkan detail preview barang.
     */
    public function preview(Barang $barang)
    {
        return view('menu.preview-barang', compact('barang'));
    }
}