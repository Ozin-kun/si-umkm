<?php

namespace App\Http\Controllers;

use App\Models\Umkm;
use Illuminate\Http\Request;

class PublicController extends Controller
{
    public function index(\Illuminate\Http\Request $request)
    {
        // 1. Ambil semua kategori untuk ditampilkan di pilihan dropdown filter
        $categories = \App\Models\Category::all();

        // 2. Siapkan query dasar: Ambil UMKM yang disetujui
        $query = Umkm::with(['category', 'placePhotos'])->where('status', 'Disetujui');

        // 3. Jika pengunjung mengetikkan sesuatu di kotak pencarian
        if ($request->filled('cari')) {
            $query->where('name', 'like', '%' . $request->cari . '%');
        }

        // 4. Jika pengunjung memilih filter kategori tertentu
        if ($request->filled('kategori')) {
            $query->where('category_id', $request->kategori);
        }

        // 5. Eksekusi pencarian dan urutkan dari yang terbaru
        $umkms = $query->latest()->get();

        return view('welcome', compact('umkms', 'categories'));
    }

    public function show($id)
    {
        // Cari UMKM berdasarkan ID, pastikan statusnya 'Disetujui'
        // Sekalian bawa data relasi 'category' dan 'products' agar tidak bolak-balik ke database
        $umkm = Umkm::with(['category', 'products', 'placePhotos'])->where('status', 'Disetujui')->findOrFail($id);

        return view('umkm-detail', compact('umkm'));
    }
}
