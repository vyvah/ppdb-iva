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
        // VALIDASI BENAR
        $request->validate([
            'nik'                => 'required|numeric',
            'nama_ayah'          => 'required|string',
            'pekerjaan_ayah'     => 'required|string',
            'nama_ibu'           => 'required|string',
            'pekerjaan_ibu'      => 'required|string',
            'alamat_ortu'        => 'required|string',

            // Validasi file (max:2048, bukan max=2048)
            'kk'                => 'nullable|mimes:jpg,jpeg,png,pdf|max:2048',
            'surat_pernyataan'  => 'nullable|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        $user = auth()->user();

        // PROSES UPLOAD
        $dokumen = [];

        // list nama input file
        $fileList = ['kk', 'surat_pernyataan'];

        foreach ($fileList as $file) {
            if ($request->hasFile($file)) {

                // nama file unik
                $filename = $file . '_' . time() . '.' . $request->file($file)->extension();

                // simpan ke storage/app/public/dokumen
                $request->file($file)->storeAs('public/dokumen', $filename);

                // simpan nama file ke array
                $dokumen[$file] = $filename;
            }
        }

        // SIMPAN KE DATABASE (TABLE: users)
        $user->update([
            'nik'              => $request->nik,
            'nama_ayah'        => $request->nama_ayah,
            'pekerjaan_ayah'   => $request->pekerjaan_ayah,
            'nama_ibu'         => $request->nama_ibu,
            'pekerjaan_ibu'    => $request->pekerjaan_ibu,
            'alamat_ortu'      => $request->alamat_ortu,

            // jika tidak upload → tidak menimpa data lama
            'kk'               => $dokumen['kk'] ?? $user->kk,
            'surat_pernyataan' => $dokumen['surat_pernyataan'] ?? $user->surat_pernyataan,
        ]);

        return redirect()
            ->back()
            ->with('success', 'Form daftar ulang berhasil disimpan.');
    }
}
