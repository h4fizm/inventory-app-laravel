<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class BarangController extends Controller
{
    /**
     * Menampilkan daftar barang.
     */
    public function index()
    {
        // Mengambil data barang dan mengurutkannya dari yang terbaru
        $data_barang = Barang::with('kategori')->latest()->get();
        $unique_categories = Kategori::all();

        return view('menu.data-barang', compact('data_barang', 'unique_categories'));
    }

    /**
     * Menampilkan form untuk menambah barang.
     */
    public function create()
    {
        // Mengambil semua kategori untuk ditampilkan di dropdown
        $unique_categories = Kategori::all();
        return view('menu.tambah-barang', compact('unique_categories'));
    }

    /**
     * Menyimpan data barang baru ke database.
     */
    public function store(Request $request)
    {
        // Validasi input dari form
        $validatedData = $request->validate([
            'nama_barang' => 'required|string|max:255',
            'kode_barang' => 'required|string|max:255|unique:barang,kode_barang',
            'jumlah_barang' => 'required|integer|min:0',
            'category_id' => 'required|exists:kategori,id',
            'lokasi_barang' => 'required|string',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
        ]);

        $validatedData['lokasi_barang'] = $request->input('lokasi_barang');

        // Menyimpan data ke model Barang
        Barang::create($validatedData);

        return redirect()->route('data-barang')->with('success', 'Data barang berhasil ditambahkan.');
    }

    /**
     * Memperbarui data barang.
     */
    public function update(Request $request, Barang $barang)
    {
        // Validasi input
        $validatedData = $request->validate([
            'nama_barang' => 'sometimes|required|string|max:255',
            'kode_barang' => [
                'sometimes',
                'required',
                'string',
                'max:255',
                Rule::unique('barang')->ignore($barang->id),
            ],
            'jumlah_barang' => 'sometimes|required|integer|min:0',
            'category_id' => 'sometimes|required|exists:kategori,id',
            'lokasi_barang' => 'sometimes|required|string',
            'latitude' => 'sometimes|required|numeric',
            'longitude' => 'sometimes|required|numeric',
        ]);

        // Perbarui data hanya jika ada di request
        // Eloquent secara otomatis akan mengabaikan data yang tidak ada
        $barang->update($validatedData);

        return redirect()->route('data-barang')->with('success', 'Data barang berhasil diperbarui.');
    }

    /**
     * Menghapus data barang.
     */
    public function destroy(Barang $barang)
    {
        $barang->delete();
        return redirect()->route('data-barang')->with('success', 'Data barang berhasil dihapus.');
    }
}