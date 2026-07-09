<?php

namespace App\Http\Controllers;

use App\Models\Umkm;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UmkmController extends Controller
{
    // menampilkan halaman dashboard dan form profil
    public function index()
    {
        $user = Auth::user();
        $umkm = $user->umkm; // Mengambil data umkm jika sudah ada
        $categories = Category::all(); // Mengambil semua pilihan kategori

        return view('umkm.dashboard', compact('umkm', 'categories'));
    }

    // Memproses penyimpanan atau pembaruan profil
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'address' => 'required|string',
            'contact' => 'required|string|max:50',
            'description' => 'nullable|string',
        ]);

        // Cari profil UMKM milik user yang login, jika tidak ada, buat baru
        Umkm::updateOrCreate(
            ['user_id' => Auth::id()], // Kondisi pencarian
            [
                'category_id' => $request->category_id,
                'name' => $request->name,
                'address' => $request->address,
                'contact' => $request->contact,
                'description' => $request->description,
                // Jika data diedit, statusnya kembali menjadi pending sesuai Business Rule (BR-04)
                'status' => 'Menunggu Verifikasi'
            ]
        );

        return redirect()->route('umkm.dashboard')->with('success', 'Profil UMKM berhasil disimpan dan sedang menunggu verifikasi Admin.');
    }
}
