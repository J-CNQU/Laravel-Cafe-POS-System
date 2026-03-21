<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Menampilkan daftar produk (READ)
     */
    public function index()
    {
        // Ambil semua data produk, urutkan berdasarkan kategori agar rapi
        $products = Product::orderBy('category')->get();

        return view('products.index', compact('products'));
    }

    /**
     * Menampilkan form tambah produk (Create Page - opsional jika pakai modal)
     */
    public function create()
    {
        return view('products.create');
    }

    /**
     * Menyimpan produk baru ke database (STORE/CREATE)
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|in:makanan,minuman,dessert',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
        ]);

        Product::create($request->all());

        return redirect()->route('products.index')->with('success', 'Menu baru berhasil ditambah!');
    }

    /**
     * Menampilkan form edit (Opsional jika pakai Modal)
     */
    public function edit($id)
    {
        $product = Product::findOrFail($id);
        return view('products.edit', compact('product'));
    }

    /**
     * Update data produk di database (UPDATE)
     */
    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|in:makanan,minuman,dessert',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
        ]);

        $product->update($request->all());

        return redirect()->route('products.index')->with('success', 'Menu berhasil diperbarui!');
    }

    /**
     * Menghapus produk (DELETE)
     */
    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();

        return redirect()->route('products.index')->with('success', 'Produk berhasil dihapus!');
    }
}