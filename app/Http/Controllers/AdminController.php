<?php

namespace App\Http\Controllers;

use App\Models\Umkm;
use App\Models\VerificationLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    // Menampilkan daftar UMKM di dashboard Admin
    public function index()
    {
        // Menghitung statistik pendaftaran
        $totalUmkm = Umkm::count();
        $pendingUmkm = Umkm::where('status', 'Menunggu Verifikasi')->count();
        $approvedUmkm = Umkm::where('status', 'Disetujui')->count();
        $rejectedUmkm = Umkm::whereIn('status', ['Ditolak', 'Revisi', 'Direvisi', 'Nonaktif'])->count();

        // Mengambil semua data UMKM beserta relasi user dan kategorinya, diurutkan dari yang terbaru
        $umkms = Umkm::with(['user', 'category', 'placePhotos'])->orderBy('created_at', 'desc')->get();
        $verificationLogs = VerificationLog::with(['umkm.user', 'admin'])->latest()->limit(10)->get();

        return view('admin.dashboard', compact('umkms','totalUmkm','pendingUmkm','approvedUmkm','rejectedUmkm','verificationLogs'));
    }

    // Memproses perubahan status verifikasi
    public function verify(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:Disetujui,Ditolak,Revisi,Nonaktif',
            'reason' => 'nullable|string|max:255',
        ]);

        if (in_array($request->status, ['Ditolak', 'Revisi'], true) && blank($request->reason)) {
            return back()->withErrors([
                'reason' => 'Alasan wajib diisi saat status ditolak atau direvisi.',
            ])->withInput();
        }

        $umkm = Umkm::findOrFail($id);
        $umkmStatus = $request->status === 'Revisi' ? 'Direvisi' : $request->status;
        $umkm->update([
            'status' => $umkmStatus
        ]);

        // Catat riwayat perubahan ke tabel verification_logs
        VerificationLog::create([
            'umkm_id' => $umkm->id,
            'admin_id' => Auth::id(),
            'status' => $request->status,
            'reason' => $request->reason
        ]);

        return redirect()->route('admin.dashboard')->with('success', 'Status UMKM "' . $umkm->name . '" berhasil diperbarui!');
    }
}
