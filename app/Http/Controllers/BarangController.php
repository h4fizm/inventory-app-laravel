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
        $data_barang = Barang::with('kategori')->get();
        $unique_categories = Kategori::all();

        return view('menu.data-barang', compact('data_barang', 'unique_categories'));
    }

    /**
     * Memperbarui data barang.
     */
    public function update(Request $request, Barang $barang)
    {
        // Perbaikan di sini: Menggunakan Rule::unique dengan pengecualian ID.
        // Nama tabel 'barang' harus sesuai dengan protected $table di model Barang.php.
        $validatedData = $request->validate([
            'nama_barang' => 'required|string|max:255',
            'kode_barang' => [
                'required',
                'string',
                'max:255',
                Rule::unique('barang')->ignore($barang->id),
            ],
            'jumlah_barang' => 'required|integer|min:0',
            'category_id' => 'required|exists:kategori,id',
        ]);

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