<?php

namespace App\Http\Controllers;

use App\Models\Dokumen;
use App\Models\Biodata;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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

        // Users yang mengunggah dokumen (kolom pada tabel users seperti kk/akte/bukti_transfer)
        $uploadedUsers = User::whereNotNull('kk')
            ->orWhereNotNull('akte')
            ->orWhereNotNull('bukti_transfer')
            ->orWhereNotNull('nama_ayah')
            ->orWhereNotNull('nama_ibu')
            ->orderBy('updated_at', 'desc')
            ->paginate(10, ['*'], 'users_page');

        return view('admin.verifikasi', compact('dokumens', 'uploadedUsers'));
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

    /**
     * Tampilkan detail data user (biodata + orangtua + file names)
     */
    public function showUser(User $user)
    {
        return response()->json([
            'user' => $user,
        ]);
    }

    /**
     * Update atau buat Dokumen record untuk file user dan set status verifikasi
     */
    public function updateUserFileStatus(Request $request, User $user, $file)
    {
        $allowed = ['kk', 'akte', 'bukti_transfer'];
        if (!in_array($file, $allowed)) {
            return response()->json(['message' => 'Tipe file tidak valid'], 404);
        }

        $validated = $request->validate([
            'status_verifikasi' => 'required|in:menunggu,disetujui,ditolak',
            'catatan_verifikasi' => 'nullable|string',
        ]);

        $filename = $user->{$file} ?? null;
        if (!$filename) {
            return response()->json(['message' => 'File tidak ditemukan pada pengguna ini.'], 404);
        }

        $filePath = 'public/dokumen/' . $filename;

        $dokumen = Dokumen::updateOrCreate(
            [
                'user_id' => $user->id,
                'tipe_dokumen' => $file,
            ],
            [
                'user_id' => $user->id,
                'biodata_id' => null,
                'nama_dokumen' => $file === 'kk' ? 'Kartu Keluarga' : ($file === 'akte' ? 'Akte Kelahiran' : 'Bukti Transfer'),
                'tipe_dokumen' => $file,
                'file_path' => $filePath,
                'status_verifikasi' => $validated['status_verifikasi'],
                'catatan_verifikasi' => $validated['catatan_verifikasi'] ?? null,
                'diverifikasi_oleh' => auth()->id(),
                'tanggal_verifikasi' => now(),
            ]
        );

        return response()->json([
            'message' => 'Status verifikasi file pengguna berhasil diperbarui',
            'dokumen' => $dokumen,
        ]);
    }

    /**
     * Download file yang tersimpan di user (kk/akte/bukti_transfer)
     */
    public function downloadUserFile(User $user, $file)
    {
        $allowed = ['kk', 'akte', 'bukti_transfer'];
        if (!in_array($file, $allowed)) {
            abort(404);
        }

        $filename = $user->{$file} ?? null;
        if (!$filename) {
            abort(404, 'File tidak ditemukan');
        }

        $path = 'public/dokumen/' . $filename;

        if (!Storage::exists($path)) {
            abort(404, 'File tidak ditemukan');
        }

        return Storage::download($path);
    }

    /**
     * Get user detail untuk modal seleksi admin
     */
    public function getUserDetail(User $user)
    {
        $user->load('biodata');
        
        return response()->json([
            'user' => $user,
        ]);
    }
}
