<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OrangtuaController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        return view('user.orangtua', compact('user'));
    }

    public function store(Request $request)
    {
        // Validasi data orang tua
        $request->validate([
            'nama_ayah' => 'required|string|max:255',
            'nik_ayah' => 'required|numeric|digits_between:1,16',
            'pekerjaan_ayah' => 'required|string|max:255',
            'telepon_ayah' => 'required|numeric|digits_between:6,20',

            'nama_ibu' => 'required|string|max:255',
            'nik_ibu' => 'required|numeric|digits_between:1,16',
            'pekerjaan_ibu' => 'required|string|max:255',
            'telepon_ibu' => 'required|numeric|digits_between:6,20',

            'alamat_ortu' => 'required|string',
            'rt' => 'nullable|numeric|digits_between:1,3',
            'rw' => 'nullable|numeric|digits_between:1,3',
            'kelurahan' => 'nullable|string|max:100',
            'kecamatan' => 'nullable|string|max:100',
            'kabupaten' => 'nullable|string|max:100',
            'provinsi' => 'nullable|string|max:100',
            'kode_pos' => 'nullable|digits:5',
        ], [
            'nama_ayah.required' => 'Nama ayah wajib diisi.',
            'nik_ayah.required' => 'NIK ayah wajib diisi.',
            'nik_ayah.digits_between' => 'NIK ayah harus berupa angka dan maksimal 16 digit.',
            'pekerjaan_ayah.required' => 'Pekerjaan ayah wajib diisi.',
            'telepon_ayah.required' => 'Telepon ayah wajib diisi.',
            'telepon_ayah.numeric' => 'Telepon ayah harus berupa angka.',
            'telepon_ayah.digits_between' => 'Telepon ayah harus antara 6 sampai 20 digit.',
            'nama_ibu.required' => 'Nama ibu wajib diisi.',
            'nik_ibu.required' => 'NIK ibu wajib diisi.',
            'nik_ibu.digits_between' => 'NIK ibu harus berupa angka dan maksimal 16 digit.',
            'pekerjaan_ibu.required' => 'Pekerjaan ibu wajib diisi.',
            'telepon_ibu.required' => 'Telepon ibu wajib diisi.',
            'telepon_ibu.numeric' => 'Telepon ibu harus berupa angka.',
            'telepon_ibu.digits_between' => 'Telepon ibu harus antara 6 sampai 20 digit.',
            'alamat_ortu.required' => 'Alamat orang tua wajib diisi.',
            'rt.numeric' => 'RT harus berupa angka.',
            'rw.numeric' => 'RW harus berupa angka.',
            'rt.digits_between' => 'RT maksimal 3 digit.',
            'rw.digits_between' => 'RW maksimal 3 digit.',
            'kode_pos.digits' => 'Kode pos harus 5 digit.',
        ]);

        $user = auth()->user();

        // Simpan data ke user atau ke biodata sesuai struktur
        $user->update([
            'nama_ayah' => $request->nama_ayah,
            'nik_ayah' => $request->nik_ayah,
            'pekerjaan_ayah' => $request->pekerjaan_ayah,
            'telepon_ayah' => $request->telepon_ayah,

            'nama_ibu' => $request->nama_ibu,
            'nik_ibu' => $request->nik_ibu,
            'pekerjaan_ibu' => $request->pekerjaan_ibu,
            'telepon_ibu' => $request->telepon_ibu,

            'alamat_ortu' => $request->alamat_ortu,
            'rt_ortu' => $request->rt,
            'rw_ortu' => $request->rw,
            'kelurahan_ortu' => $request->kelurahan,
            'kecamatan_ortu' => $request->kecamatan,
            'kabupaten_ortu' => $request->kabupaten,
            'provinsi_ortu' => $request->provinsi,
            'kode_pos_ortu' => $request->kode_pos,
        ]);

        // Simpan data dan biarkan user tetap di halaman user.
        // Data sudah tersimpan dan akan terlihat pada halaman admin untuk verifikasi.
        return redirect()->back()->with('success', 'Data orang tua berhasil disimpan! Admin akan segera memverifikasi.');
    }
}
