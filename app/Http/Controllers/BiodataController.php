<?php

namespace App\Http\Controllers;

use App\Models\Biodata;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BiodataController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $is_verified_user = Auth::user()->is_verified ?? false;

        return view('user.biodata', compact('is_verified_user'));
    }

    /**
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required',
            'nisn' => 'required',
            'tempat_lahir' => 'required',
            'tanggal_lahir' => 'required',
            'jenis_kelamin' => 'required',
            'telepon' => 'required',
            'alamat' => 'required',
            'foto' => 'nullable|image|max:2048',
        ]);

        $user = auth()->user();

        if ($request->hasFile('foto')) {
            $validated['foto'] = $request->file('foto')->store('foto', 'public');
        }

        $user->update($validated);

        // Create or update Biodata record
        Biodata::updateOrCreate(
            ['user_id' => $user->id],
            [
                'nomor_pendaftaran' => $validated['nisn'] ?? null,
                'nama_lengkap' => $validated['nama'] ?? null,
                'tempat_lahir' => $validated['tempat_lahir'] ?? null,
                'tanggal_lahir' => $validated['tanggal_lahir'] ?? null,
                'jenis_kelamin' => $validated['jenis_kelamin'] ?? null,
            ]
        );

        // Simpan data dan biarkan user tetap di halaman user.
        // Data sudah tersimpan dan akan terlihat pada halaman admin untuk verifikasi.
        return redirect()->back()->with('success', 'Biodata berhasil diperbarui! Admin akan segera memverifikasi.');
    }
}
