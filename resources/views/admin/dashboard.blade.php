@extends('layouts.dashboard')
@section('title', 'Dashboard Admin')

@section('content')
<style>
    :root {
        --primary: #4f46e5;
        --bg-soft: #f9fafb;
        --text-dark: #111827;
        --text-muted: #6b7280;
        --radius: 16px;
    }

    .dashboard-container { padding: 15px; }

    /* HEADER */
    .header-modern {
        padding: 28px;
        border-radius: var(--radius);
        background: #ffffff;
        border: 1px solid #e5e7eb;
        margin-bottom: 25px;
    }

    /* STATISTIC CARDS */
    .stat-minimal {
        background: #ffffff;
        padding: 24px;
        border-radius: 14px;
        border: 1px solid #e5e7eb;
        transition: .2s ease;
    }
    .stat-minimal:hover { background: #fafafa; transform: translateY(-2px); }

    .stat-title { font-size:14px; color:#6b7280; margin-bottom:4px; }
    .stat-value { font-size:32px; font-weight:700; color:#111827; margin-bottom:6px; }
    .stat-sub { font-size:12px; color:#9ca3af; font-weight:500; }

    .badge-soft {
        padding: 5px 10px;
        border-radius: 12px;
        font-size: 12px;
        font-weight: 600;
    }
    .bg-success-soft { background:#dcfce7; color:#15803d; }
    .bg-warning-soft { background:#fef9c3; color:#a16207; }
    .bg-danger-soft  { background:#fee2e2; color:#b91c1c; }
    .bg-info-soft    { background:#e0f2fe; color:#0369a1; }

</style>

<div class="dashboard-container">

    <!-- HEADER -->
    <div class="header-modern">
        <h2 class="fw-bold" style="color:var(--primary)">Dashboard Admin</h2>
        <p class="text-muted mb-0">Selamat datang kembali, <strong>{{ Auth::user()->name }}</strong>.</p>
    </div>


    <!-- STATISTIC -->
    <div class="row g-3 mb-3">

        <div class="col-md-6 col-xl-3">
            <div class="stat-minimal">
                <p class="stat-title">Total Pendaftar</p>
                <p class="stat-value">{{ number_format($total_pendaftar ?? 0) }}</p>
                <span class="stat-sub">Semua gelombang</span>
            </div>
        </div>

        <div class="col-md-6 col-xl-3">
            <div class="stat-minimal">
                <p class="stat-title">Terverifikasi</p>
                <p class="stat-value">{{ number_format($total_terverifikasi ?? 0) }}</p>
                <span class="stat-sub text-success">Dokumen sah</span>
            </div>
        </div>

        <div class="col-md-6 col-xl-3">
            <div class="stat-minimal">
                <p class="stat-title">Diterima</p>
                <p class="stat-value">{{ number_format($total_diterima ?? 0) }}</p>
                <span class="stat-sub text-warning">Lolos Seleksi</span>
            </div>
        </div>

        <div class="col-md-6 col-xl-3">
            <div class="stat-minimal">
                <p class="stat-title">Belum Dicek</p>
                <p class="stat-value">{{ number_format($total_belum_dicek ?? 0) }}</p>
                <span class="stat-sub text-danger">Menunggu verifikasi</span>
            </div>
        </div>
    </div>


    <div class="row g-4 mt-2">

        <!-- TABLE SECTION -->
        <div class="col-xl-8">
            <div class="stat-minimal">

                <h5 class="fw-bold mb-3">Pendaftar Terbaru</h5>

                <div class="table-responsive">
                    <table class="table align-middle">
                        <thead class="bg-light">
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Asal Sekolah</th>
                                <th>Status</th>
                                <th class="text-end">Hasil</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($pendaftar_recent ?? [] as $p)
                                @php
                                    $status = strtolower($p->status_verifikasi ?? '');
                                    $badgeClass = $status == 'sah' ? 'bg-success-soft'
                                                : ($status == 'diterima' ? 'bg-warning-soft'
                                                : ($status == 'belum dicek' ? 'bg-danger-soft'
                                                : 'bg-info-soft'));
                                @endphp

                                <tr>
                                    <td>{{ $p->no_pendaftaran }}</td>
                                    <td>{{ $p->nama }}</td>
                                    <td>{{ $p->asal_sekolah }}</td>
                                    <td><span class="badge-soft {{ $badgeClass }}">{{ ucfirst($p->status_verifikasi) }}</span></td>
                                    <td class="text-end">{{ $p->hasil_seleksi ?? '-' }}</td>
                                </tr>

                            @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted">Belum ada pendaftar</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

            </div>
        </div>


        <!-- SIDEBAR SUMMARY -->
        <div class="col-xl-4">
            <div class="stat-minimal">

                <h5 class="fw-bold mb-3">Ringkasan PPDB</h5>

                <ul class="list-group border-0">

                    <li class="list-group-item border-0 d-flex justify-content-between">
                        Total Pendaftar
                        <strong>{{ number_format($total_pendaftar ?? 0) }}</strong>
                    </li>

                    <li class="list-group-item border-0 d-flex justify-content-between">
                        Terverifikasi
                        <strong class="text-success">{{ number_format($total_terverifikasi ?? 0) }}</strong>
                    </li>

                    <li class="list-group-item border-0 d-flex justify-content-between">
                        Diterima
                        <strong class="text-warning">{{ number_format($total_diterima ?? 0) }}</strong>
                    </li>

                    <li class="list-group-item border-0 d-flex justify-content-between">
                        Belum Dicek
                        <strong class="text-danger">{{ number_format($total_belum_dicek ?? 0) }}</strong>
                    </li>

                </ul>

                <hr>

                <p class="text-muted small mt-2">
                    * Data diperbarui otomatis berdasarkan sistem PPDB.
                </p>

            </div>
        </div>

    </div>
</div>

@endsection
