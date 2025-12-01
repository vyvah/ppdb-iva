<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DokumenController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        return view('user.daftar_ulang', compact('user'));
    }

    public function store(Request $request)
    {
        // Validasi sesuai form Upload Dokumen pada user/dokumen
        $request->validate([
            'nama' => 'required|string|max:255',
            'telepon' => 'required|string|max:20',
            'jurusan' => 'nullable|string|max:10',

            // fields orangtua tetap diterima jika ada
            'nik' => 'nullable|numeric',
            'nama_ayah' => 'nullable|string|max:255',
            'pekerjaan_ayah' => 'nullable|string|max:255',
            'nama_ibu' => 'nullable|string|max:255',
            'pekerjaan_ibu' => 'nullable|string|max:255',
            'alamat_ortu' => 'nullable|string',

            // file uploads sesuai nama input di form
            'kk' => 'nullable|mimes:jpg,jpeg,png,pdf|max:2048',
            'akte' => 'nullable|mimes:jpg,jpeg,png,pdf|max:2048',
            'bukti_transfer' => 'nullable|mimes:jpg,jpeg,png,pdf|max:2048',
        ], [
            // custom pesan sederhana Bahasa Indonesia
            'nama.required' => 'Nama lengkap wajib diisi.',
            'telepon.required' => 'Nomor telepon wajib diisi.',
            'kk.mimes' => 'File KK harus berformat jpg, jpeg, png, atau pdf.',
            'akte.mimes' => 'File Akte harus berformat jpg, jpeg, png, atau pdf.',
            'bukti_transfer.mimes' => 'File bukti transfer harus berformat jpg, jpeg, png, atau pdf.',
        ]);

        $user = auth()->user();

        // PROSES UPLOAD — simpan file ke storage/app/public/dokumen
        $dokumen = [];
        $fileList = ['kk', 'akte', 'bukti_transfer'];

        foreach ($fileList as $file) {
            if ($request->hasFile($file)) {
                $fileObj = $request->file($file);
                $filename = $file . '_' . time() . '.' . $fileObj->extension();
                $fileObj->storeAs('public/dokumen', $filename);
                $dokumen[$file] = $filename;
            }
        }

        // Update data user (hanya field yang sesuai dengan form)
        $user->update([
            'name' => $request->nama,
            'telepon' => $request->telepon,
            'jurusan' => $request->jurusan,

            // jika orangtua diisi, simpan juga
            'nik' => $request->nik ?? $user->nik,
            'nama_ayah' => $request->nama_ayah ?? $user->nama_ayah,
            'pekerjaan_ayah' => $request->pekerjaan_ayah ?? $user->pekerjaan_ayah,
            'nama_ibu' => $request->nama_ibu ?? $user->nama_ibu,
            'pekerjaan_ibu' => $request->pekerjaan_ibu ?? $user->pekerjaan_ibu,
            'alamat_ortu' => $request->alamat_ortu ?? $user->alamat_ortu,

            // file fields — hanya timpa jika ada upload baru
            'kk' => $dokumen['kk'] ?? $user->kk,
            'akte' => $dokumen['akte'] ?? $user->akte,
            'bukti_transfer' => $dokumen['bukti_transfer'] ?? $user->bukti_transfer,
        ]);

        // Simpan data dan biarkan user tetap di halaman user.
        // Data sudah tersimpan dan akan terlihat pada halaman admin untuk verifikasi.
        return redirect()->back()->with('success', 'Dokumen berhasil diunggah! Admin akan segera memverifikasi.');
    }
}
