<?php

namespace App\Http\Controllers;

use App\Models\Dokumen;
use App\Models\Pengumuman;
use App\Models\User;
use App\Models\Biodata;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    /**
     * Tampilkan halaman laporan
     */
    public function index()
    {
        $statistik = [
            'total_pendaftar' => User::where('role', 'user')->count(),
            'dokumen_menunggu' => Dokumen::where('status_verifikasi', 'menunggu')->count(),
            'dokumen_disetujui' => Dokumen::where('status_verifikasi', 'disetujui')->count(),
            'dokumen_ditolak' => Dokumen::where('status_verifikasi', 'ditolak')->count(),
            'hasil_diterima' => Pengumuman::where('status_hasil', 'diterima')->count(),
            'hasil_tidak_diterima' => Pengumuman::where('status_hasil', 'tidak_diterima')->count(),
            'hasil_cadangan' => Pengumuman::where('status_hasil', 'cadangan')->count(),
            'hasil_dipublikasikan' => Pengumuman::where('di_publikasikan', true)->count(),
        ];

        $dokumen_chart = [
            'labels' => ['Menunggu', 'Disetujui', 'Ditolak'],
            'data' => [
                $statistik['dokumen_menunggu'],
                $statistik['dokumen_disetujui'],
                $statistik['dokumen_ditolak'],
            ],
        ];

        $hasil_chart = [
            'labels' => ['Diterima', 'Tidak Diterima', 'Cadangan'],
            'data' => [
                $statistik['hasil_diterima'],
                $statistik['hasil_tidak_diterima'],
                $statistik['hasil_cadangan'],
            ],
        ];

        return view('admin.laporan', compact('statistik', 'dokumen_chart', 'hasil_chart'));
    }

    /**
     * Export laporan ke Excel
     */
    public function exportExcel()
    {
        $dokumens = Dokumen::with(['user', 'biodata'])
            ->orderBy('created_at', 'desc')
            ->get();

        $filename = 'laporan_dokumen_' . date('Y-m-d_His') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv; charset=utf-8',
            'Content-Disposition' => "attachment; filename=$filename",
        ];

        $callback = function () use ($dokumens) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['No', 'Nama User', 'Email', 'Dokumen', 'Tipe', 'Status', 'Tanggal Upload', 'Tanggal Verifikasi']);

            $no = 1;
            foreach ($dokumens as $dokumen) {
                fputcsv($file, [
                    $no++,
                    $dokumen->user->name,
                    $dokumen->user->email,
                    $dokumen->nama_dokumen,
                    $dokumen->tipe_dokumen,
                    ucfirst($dokumen->status_verifikasi),
                    $dokumen->created_at->format('Y-m-d H:i:s'),
                    $dokumen->tanggal_verifikasi ? $dokumen->tanggal_verifikasi->format('Y-m-d H:i:s') : '-',
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Export laporan hasil seleksi ke Excel
     */
    public function exportHasil()
    {
        $pengumans = Pengumuman::with(['user', 'biodata'])
            ->orderBy('status_hasil', 'asc')
            ->get();

        $filename = 'laporan_hasil_seleksi_' . date('Y-m-d_His') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv; charset=utf-8',
            'Content-Disposition' => "attachment; filename=$filename",
        ];

        $callback = function () use ($pengumans) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['No', 'Nomor Pendaftaran', 'Nama Peserta', 'Status Hasil', 'Nilai Akhir', 'Dipublikasikan', 'Tanggal Pengumuman']);

            $no = 1;
            foreach ($pengumans as $penguman) {
                fputcsv($file, [
                    $no++,
                    $penguman->nomor_pendaftaran,
                    $penguman->nama_peserta,
                    ucfirst(str_replace('_', ' ', $penguman->status_hasil)),
                    $penguman->nilai_akhir ?? '-',
                    $penguman->di_publikasikan ? 'Ya' : 'Tidak',
                    $penguman->tanggal_pengumuman ? $penguman->tanggal_pengumuman->format('Y-m-d') : '-',
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Laporan detail dokumen berdasarkan status
     */
    public function dokumenByStatus($status)
    {
        $dokumens = Dokumen::with(['user', 'biodata'])
            ->where('status_verifikasi', $status)
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('admin.laporan-dokumen', compact('dokumens', 'status'));
    }

    /**
     * Laporan detail hasil berdasarkan status
     */
    public function hasilByStatus($status)
    {
        $pengumans = Pengumuman::with(['user', 'biodata'])
            ->where('status_hasil', $status)
            ->orderBy('nilai_akhir', 'desc')
            ->paginate(20);

        return view('admin.laporan-hasil', compact('pengumans', 'status'));
    }
}
