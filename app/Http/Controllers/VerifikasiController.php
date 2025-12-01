<?php

namespace App\Http\Controllers;

use App\Models\Dokumen;
use App\Models\Biodata;
use App\Models\User;
use Illuminate\Http\Request;

class VerifikasiController extends Controller
{
    /**
     * Tampilkan halaman verifikasi dokumen
     */
    public function index()
    {
        $dokumens = Dokumen::with(['user', 'biodata'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('admin.verifikasi', compact('dokumens'));
    }

    /**
     * Update status verifikasi dokumen
     */
    public function updateStatus(Request $request, Dokumen $dokumen)
    {
        $validated = $request->validate([
            'status_verifikasi' => 'required|in:menunggu,disetujui,ditolak',
            'catatan_verifikasi' => 'nullable|string',
        ]);

        $dokumen->update([
            'status_verifikasi' => $validated['status_verifikasi'],
            'catatan_verifikasi' => $validated['catatan_verifikasi'] ?? null,
            'diverifikasi_oleh' => auth()->id(),
            'tanggal_verifikasi' => now(),
        ]);

        return response()->json([
            'message' => 'Status verifikasi berhasil diperbarui',
            'status' => $dokumen->status_verifikasi,
        ]);
    }

    /**
     * Download dokumen
     */
    public function download(Dokumen $dokumen)
    {
        $filePath = storage_path('app/' . $dokumen->file_path);

        if (!file_exists($filePath)) {
            abort(404, 'File tidak ditemukan');
        }

        return response()->download($filePath);
    }

    /**
     * Tampilkan detail dokumen
     */
    public function show(Dokumen $dokumen)
    {
        return response()->json([
            'dokumen' => $dokumen->load(['user', 'biodata']),
        ]);
    }
}
