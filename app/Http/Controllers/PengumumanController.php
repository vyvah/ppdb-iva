<?php

namespace App\Http\Controllers;

use App\Models\Pengumuman;
use App\Models\Biodata;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PengumumanController extends Controller
{
    /**
     * Tampilkan halaman pengumuman hasil seleksi
     */
    public function index()
    {
        $pengumans = Pengumuman::with(['user', 'biodata'])
            ->orderBy('tanggal_pengumuman', 'desc')
            ->paginate(15);

        $statistik = [
            'total' => Pengumuman::count(),
            'diterima' => Pengumuman::where('status_hasil', 'diterima')->count(),
            'tidak_diterima' => Pengumuman::where('status_hasil', 'tidak_diterima')->count(),
            'cadangan' => Pengumuman::where('status_hasil', 'cadangan')->count(),
            'di_publikasikan' => Pengumuman::where('di_publikasikan', true)->count(),
        ];

        return view('admin.pengumuman', compact('pengumans', 'statistik'));
    }

    /**
     * Tampilkan halaman pengumuman untuk area user
     */
    public function userIndex()
    {
        $pengumans = Pengumuman::where('di_publikasikan', true)
            ->orderBy('tanggal_pengumuman', 'desc')
            ->paginate(10);

        $userPengumuman = null;
        if (Auth::check()) {
            $userPengumuman = Pengumuman::where('user_id', Auth::id())->latest()->first();
        }

        return view('user.pengumuman', compact('pengumans', 'userPengumuman'));
    }

    /**
     * Simpan atau update pengumuman hasil
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'biodata_id' => 'required|exists:biodatas,id',
            'status_hasil' => 'required|in:diterima,tidak_diterima,cadangan',
            'nilai_akhir' => 'nullable|numeric|min:0|max:100',
            'pesan_pengumuman' => 'nullable|string',
        ]);

        $biodata = Biodata::find($validated['biodata_id']);

        $pengumuman = Pengumuman::updateOrCreate(
            ['biodata_id' => $validated['biodata_id']],
            [
                'user_id' => $biodata->user_id,
                'nomor_pendaftaran' => $biodata->nomor_pendaftaran ?? 'N/A',
                'nama_peserta' => $biodata->nama_lengkap ?? 'N/A',
                'status_hasil' => $validated['status_hasil'],
                'nilai_akhir' => $validated['nilai_akhir'],
                'pesan_pengumuman' => $validated['pesan_pengumuman'],
                'tanggal_pengumuman' => now(),
            ]
        );

        return response()->json([
            'message' => 'Pengumuman berhasil disimpan',
            'pengumuman' => $pengumuman,
        ]);
    }

    /**
     * Publikasikan hasil seleksi
     */
    public function publikasikan(Request $request, Pengumuman $pengumuman)
    {
        $pengumuman->update([
            'di_publikasikan' => !$pengumuman->di_publikasikan,
        ]);

        $status = $pengumuman->di_publikasikan ? 'dipublikasikan' : 'disembunyikan';

        return response()->json([
            'message' => "Pengumuman berhasil {$status}",
            'di_publikasikan' => $pengumuman->di_publikasikan,
        ]);
    }

    /**
     * Hapus pengumuman
     */
    public function destroy(Pengumuman $pengumuman)
    {
        $pengumuman->delete();

        return response()->json([
            'message' => 'Pengumuman berhasil dihapus',
        ]);
    }

    /**
     * Tampilkan form import hasil dari CSV
     */
    public function showImportForm()
    {
        return view('admin.import-pengumuman');
    }

    /**
     * Import data pengumuman dari CSV
     */
    public function importCsv(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:csv,txt',
        ]);

        $file = $request->file('file');
        $path = $file->store('temp');
        $fullPath = storage_path('app/' . $path);

        $count = 0;
        if (($handle = fopen($fullPath, 'r')) !== false) {
            fgetcsv($handle); // Skip header

            while (($data = fgetcsv($handle, 1000, ',')) !== false) {
                if (count($data) >= 4) {
                    $biodata = Biodata::where('nomor_pendaftaran', trim($data[0]))->first();

                    if ($biodata) {
                        Pengumuman::updateOrCreate(
                            ['biodata_id' => $biodata->id],
                            [
                                'user_id' => $biodata->user_id,
                                'nomor_pendaftaran' => $data[0],
                                'nama_peserta' => $data[1],
                                'status_hasil' => strtolower(trim($data[2])),
                                'nilai_akhir' => floatval($data[3]) ?? null,
                                'tanggal_pengumuman' => now(),
                            ]
                        );
                        $count++;
                    }
                }
            }
            fclose($handle);
        }

        unlink($fullPath);

        return response()->json([
            'message' => "{$count} pengumuman berhasil diimport",
            'count' => $count,
        ]);
    }
}
