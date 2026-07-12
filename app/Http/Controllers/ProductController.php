<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    // 1. Menampilkan daftar produk milik UMKM yang sedang login
    public function index()
    {
        $umkm = Auth::user()->umkm;
        
        // Cegah masuk jika belum isi profil UMKM
        if (!$umkm) {
            return redirect()->route('umkm.dashboard')->with('error', 'Silakan isi profil usaha Anda terlebih dahulu.');
        }

        $products = Product::where('umkm_id', $umkm->id)->latest()->get();
        return view('umkm.product.index', compact('products'));
    }

    // 2. Menampilkan form tambah produk
    public function create()
    {
        if (!Auth::user()->umkm) {
            return redirect()->route('umkm.dashboard')->with('error', 'Silakan isi profil usaha Anda terlebih dahulu.');
        }
        return view('umkm.product.create');
    }

    // 3. Memproses penyimpanan produk dan gambar
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'image' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048', // Wajib gambar, maksimal 2MB
        ]);

        // Simpan gambar ke folder 'products'
        $imagePath = $request->file('image')->store('products', 'public');

        Product::create([
            'umkm_id' => Auth::user()->umkm->id,
            'name' => $request->name,
            'price' => $request->price,
            'description' => $request->description,
            'image_path' => $imagePath,
        ]);

        return redirect()->route('umkm.product.index')->with('success', 'Produk berhasil ditambahkan ke etalase!');
    }

    // 4. Menampilkan form edit produk
    public function edit($id)
    {
        $product = Product::findOrFail($id);

        // Keamanan: Pastikan UMKM tidak bisa mengedit produk milik UMKM lain
        if ($product->umkm_id != Auth::user()->umkm->id) {
            abort(403, 'Anda tidak memiliki akses ke produk ini.');
        }

        return view('umkm.product.edit', compact('product'));
    }

    // 5. Memproses pembaruan data produk
    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        if ($product->umkm_id != Auth::user()->umkm->id) {
            abort(403, 'Anda tidak memiliki akses ke produk ini.');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048', // Image boleh kosong saat edit
        ]);

        $data = [
            'name' => $request->name,
            'price' => $request->price,
            'description' => $request->description,
        ];

        // Jika user mengunggah gambar baru
        if ($request->hasFile('image')) {
            // Hapus gambar lama dari storage jika ada
            if ($product->image_path && Storage::disk('public')->exists($product->image_path)) {
                Storage::disk('public')->delete($product->image_path);
            }
            // Simpan gambar baru
            $data['image_path'] = $request->file('image')->store('products', 'public');
        }

        $product->update($data);

        return redirect()->route('umkm.product.index')->with('success', 'Produk berhasil diperbarui!');
    }

    // 6. Memproses penghapusan produk
    public function destroy($id)
    {
        $product = Product::findOrFail($id);

        if ($product->umkm_id != Auth::user()->umkm->id) {
            abort(403, 'Anda tidak memiliki akses ke produk ini.');
        }

        // Hapus file gambar dari storage
        if ($product->image_path && Storage::disk('public')->exists($product->image_path)) {
            Storage::disk('public')->delete($product->image_path);
        }

        // Hapus data dari database
        $product->delete();

        return redirect()->route('umkm.product.index')->with('success', 'Produk berhasil dihapus dari etalase!');
    }
}
