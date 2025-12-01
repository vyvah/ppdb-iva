@extends('layouts.dashboard')
@section('title', 'Laporan PPDB')
@section('content')
    <div class="pc-content">
        <!-- Page Header -->
        <div class="page-header">
            <div class="page-block">
                <div class="row align-items-center">
                    <div class="col-md-12">
                        <div class="page-header-title">
                            <h4 class="m-b-10">
                                <i class="ti ti-report-2"></i> Laporan PPDB
                            </h4>
                            <p class="text-muted m-b-0">Rekapitulasi data, statistik, dan analisis proses seleksi PPDB</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="pc-content">
        <!-- Summary Cards -->
        <div class="row mb-4">
            <div class="col-lg-3 col-md-6 col-sm-12">
                <div class="card summary-card summary-card-primary">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <p class="card-label">Total Pendaftar</p>
                                <h2 class="card-value">{{ $statistik['total_pendaftar'] ?? 0 }}</h2>
                                <p class="card-info">Peserta didik baru</p>
                            </div>
                            <div class="card-icon">
                                <i class="ti ti-users"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6 col-sm-12">
                <div class="card summary-card summary-card-warning">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <p class="card-label">Dokumen Menunggu</p>
                                <h2 class="card-value">{{ $statistik['dokumen_menunggu'] ?? 0 }}</h2>
                                <p class="card-info">Verifikasi dokumen</p>
                            </div>
                            <div class="card-icon">
                                <i class="ti ti-file-check"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6 col-sm-12">
                <div class="card summary-card summary-card-success">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <p class="card-label">Hasil Diterima</p>
                                <h2 class="card-value">{{ $statistik['hasil_diterima'] ?? 0 }}</h2>
                                <p class="card-info">Peserta lulus seleksi</p>
                            </div>
                            <div class="card-icon">
                                <i class="ti ti-check-circle"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6 col-sm-12">
                <div class="card summary-card summary-card-info">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <p class="card-label">Hasil Cadangan</p>
                                <h2 class="card-value">{{ $statistik['hasil_cadangan'] ?? 0 }}</h2>
                                <p class="card-info">Peserta cadangan</p>
                            </div>
                            <div class="card-icon">
                                <i class="ti ti-list"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Charts Section -->
        <div class="row mb-4">
            <!-- Verifikasi Dokumen Chart -->
            <div class="col-lg-6 col-md-12">
                <div class="card">
                    <div class="card-header pb-3 border-bottom">
                        <div class="d-flex align-items-center justify-content-between">
                            <h5 class="mb-0">
                                <i class="ti ti-file-text"></i> Distribusi Verifikasi Dokumen
                            </h5>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="chart-container">
                            <canvas id="dokumenChart" height="300"></canvas>
                        </div>
                        <div class="mt-4">
                            <div class="row text-center">
                                <div class="col-4">
                                    <div class="stat-box">
                                        <p class="stat-value warning">{{ $statistik['dokumen_menunggu'] ?? 0 }}</p>
                                        <p class="stat-label">Menunggu</p>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="stat-box">
                                        <p class="stat-value success">{{ $statistik['dokumen_disetujui'] ?? 0 }}</p>
                                        <p class="stat-label">Disetujui</p>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="stat-box">
                                        <p class="stat-value danger">{{ $statistik['dokumen_ditolak'] ?? 0 }}</p>
                                        <p class="stat-label">Ditolak</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Hasil Seleksi Chart -->
            <div class="col-lg-6 col-md-12">
                <div class="card">
                    <div class="card-header pb-3 border-bottom">
                        <div class="d-flex align-items-center justify-content-between">
                            <h5 class="mb-0">
                                <i class="ti ti-chart-bar"></i> Distribusi Hasil Seleksi
                            </h5>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="chart-container">
                            <canvas id="hasilChart" height="300"></canvas>
                        </div>
                        <div class="mt-4">
                            <div class="row text-center">
                                <div class="col-4">
                                    <div class="stat-box">
                                        <p class="stat-value success">{{ $statistik['hasil_diterima'] ?? 0 }}</p>
                                        <p class="stat-label">Diterima</p>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="stat-box">
                                        <p class="stat-value danger">{{ $statistik['hasil_tidak_diterima'] ?? 0 }}</p>
                                        <p class="stat-label">Tidak Diterima</p>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="stat-box">
                                        <p class="stat-value warning">{{ $statistik['hasil_cadangan'] ?? 0 }}</p>
                                        <p class="stat-label">Cadangan</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Action Cards -->
        <div class="row mb-4">
            <!-- Verifikasi Dokumen -->
            <div class="col-lg-4 col-md-6 col-sm-12">
                <div class="card action-card">
                    <div class="card-header pb-3 border-bottom">
                        <h5 class="mb-0">
                            <i class="ti ti-file-check"></i> Verifikasi Dokumen
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="progress-item mb-3">
                            <div class="d-flex justify-content-between mb-2">
                                <span class="progress-label">Menunggu Verifikasi</span>
                                <span class="progress-value warning">{{ $statistik['dokumen_menunggu'] ?? 0 }}</span>
                            </div>
                            <div class="progress-bar"
                                style="--progress: {{ ($statistik['dokumen_menunggu'] ?? 0) / max(1, ($statistik['dokumen_menunggu'] ?? 0) + ($statistik['dokumen_disetujui'] ?? 0) + ($statistik['dokumen_ditolak'] ?? 0)) * 100 }}%">
                            </div>
                        </div>

                        <div class="progress-item mb-3">
                            <div class="d-flex justify-content-between mb-2">
                                <span class="progress-label">Disetujui</span>
                                <span class="progress-value success">{{ $statistik['dokumen_disetujui'] ?? 0 }}</span>
                            </div>
                            <div class="progress-bar success"
                                style="--progress: {{ ($statistik['dokumen_disetujui'] ?? 0) / max(1, ($statistik['dokumen_menunggu'] ?? 0) + ($statistik['dokumen_disetujui'] ?? 0) + ($statistik['dokumen_ditolak'] ?? 0)) * 100 }}%">
                            </div>
                        </div>

                        <div class="progress-item">
                            <div class="d-flex justify-content-between mb-2">
                                <span class="progress-label">Ditolak</span>
                                <span class="progress-value danger">{{ $statistik['dokumen_ditolak'] ?? 0 }}</span>
                            </div>
                            <div class="progress-bar danger"
                                style="--progress: {{ ($statistik['dokumen_ditolak'] ?? 0) / max(1, ($statistik['dokumen_menunggu'] ?? 0) + ($statistik['dokumen_disetujui'] ?? 0) + ($statistik['dokumen_ditolak'] ?? 0)) * 100 }}%">
                            </div>
                        </div>

                        <div class="btn-group-vertical mt-4 w-100">
                            <a href="{{ route('admin.laporan.dokumen-status', 'menunggu') }}"
                                class="btn btn-sm btn-outline-warning">
                                <i class="ti ti-clock"></i> Lihat Menunggu
                            </a>
                            <a href="{{ route('admin.laporan.dokumen-status', 'disetujui') }}"
                                class="btn btn-sm btn-outline-success">
                                <i class="ti ti-check"></i> Lihat Disetujui
                            </a>
                            <a href="{{ route('admin.laporan.dokumen-status', 'ditolak') }}"
                                class="btn btn-sm btn-outline-danger">
                                <i class="ti ti-x"></i> Lihat Ditolak
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Hasil Seleksi -->
            <div class="col-lg-4 col-md-6 col-sm-12">
                <div class="card action-card">
                    <div class="card-header pb-3 border-bottom">
                        <h5 class="mb-0">
                            <i class="ti ti-badge-check"></i> Hasil Seleksi
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="progress-item mb-3">
                            <div class="d-flex justify-content-between mb-2">
                                <span class="progress-label">Diterima</span>
                                <span class="progress-value success">{{ $statistik['hasil_diterima'] ?? 0 }}</span>
                            </div>
                            <div class="progress-bar success"
                                style="--progress: {{ ($statistik['hasil_diterima'] ?? 0) / max(1, ($statistik['hasil_diterima'] ?? 0) + ($statistik['hasil_tidak_diterima'] ?? 0) + ($statistik['hasil_cadangan'] ?? 0)) * 100 }}%">
                            </div>
                        </div>

                        <div class="progress-item mb-3">
                            <div class="d-flex justify-content-between mb-2">
                                <span class="progress-label">Tidak Diterima</span>
                                <span class="progress-value danger">{{ $statistik['hasil_tidak_diterima'] ?? 0 }}</span>
                            </div>
                            <div class="progress-bar danger"
                                style="--progress: {{ ($statistik['hasil_tidak_diterima'] ?? 0) / max(1, ($statistik['hasil_diterima'] ?? 0) + ($statistik['hasil_tidak_diterima'] ?? 0) + ($statistik['hasil_cadangan'] ?? 0)) * 100 }}%">
                            </div>
                        </div>

                        <div class="progress-item">
                            <div class="d-flex justify-content-between mb-2">
                                <span class="progress-label">Cadangan</span>
                                <span class="progress-value warning">{{ $statistik['hasil_cadangan'] ?? 0 }}</span>
                            </div>
                            <div class="progress-bar warning"
                                style="--progress: {{ ($statistik['hasil_cadangan'] ?? 0) / max(1, ($statistik['hasil_diterima'] ?? 0) + ($statistik['hasil_tidak_diterima'] ?? 0) + ($statistik['hasil_cadangan'] ?? 0)) * 100 }}%">
                            </div>
                        </div>

                        <div class="btn-group-vertical mt-4 w-100">
                            <a href="{{ route('admin.laporan.hasil-status', 'diterima') }}"
                                class="btn btn-sm btn-outline-success">
                                <i class="ti ti-check-circle"></i> Lihat Diterima
                            </a>
                            <a href="{{ route('admin.laporan.hasil-status', 'tidak_diterima') }}"
                                class="btn btn-sm btn-outline-danger">
                                <i class="ti ti-circle-x"></i> Lihat Tidak Diterima
                            </a>
                            <a href="{{ route('admin.laporan.hasil-status', 'cadangan') }}"
                                class="btn btn-sm btn-outline-warning">
                                <i class="ti ti-alert-circle"></i> Lihat Cadangan
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Export & Publikasi -->
            <div class="col-lg-4 col-md-12 col-sm-12">
                <div class="card action-card">
                    <div class="card-header pb-3 border-bottom">
                        <h5 class="mb-0">
                            <i class="ti ti-download"></i> Export & Publikasi
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="publikasi-info mb-4">
                            <p class="label-text">Status Publikasi Hasil</p>
                            <div class="publikasi-box">
                                <div class="publikasi-icon">
                                    <i class="ti ti-world"></i>
                                </div>
                                <div>
                                    <p class="publikasi-value">{{ $statistik['hasil_dipublikasikan'] ?? 0 }}</p>
                                    <p class="publikasi-label">Hasil Dipublikasikan</p>
                                </div>
                            </div>
                        </div>

                        <hr>

                        <p class="label-text">Unduh Laporan</p>
                        <div class="btn-group-vertical w-100">
                            <a href="{{ route('admin.laporan.export-dokumen') }}" class="btn btn-sm btn-primary">
                                <i class="ti ti-file-export"></i> Laporan Dokumen (CSV)
                            </a>
                            <a href="{{ route('admin.laporan.export-hasil') }}" class="btn btn-sm btn-success">
                                <i class="ti ti-file-export"></i> Laporan Hasil (CSV)
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Summary Info -->
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header pb-3 border-bottom">
                        <h5 class="mb-0">
                            <i class="ti ti-info-circle"></i> Ringkasan Laporan
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="summary-section">
                                    <h6 class="summary-title">📋 Verifikasi Dokumen</h6>
                                    <ul class="summary-list">
                                        <li>
                                            <span>Total Dokumen</span>
                                            <strong class="badge bg-primary">
                                                {{ ($statistik['dokumen_menunggu'] ?? 0) + ($statistik['dokumen_disetujui'] ?? 0) + ($statistik['dokumen_ditolak'] ?? 0) }}
                                            </strong>
                                        </li>
                                        <li>
                                            <span>Persentase Disetujui</span>
                                            <strong class="badge bg-success">
                                                @php
                                                    $total_dokumen = ($statistik['dokumen_menunggu'] ?? 0) + ($statistik['dokumen_disetujui'] ?? 0) + ($statistik['dokumen_ditolak'] ?? 0);
                                                    $persentase = $total_dokumen > 0 ? round((($statistik['dokumen_disetujui'] ?? 0) / $total_dokumen) * 100, 1) : 0;
                                                @endphp
                                                {{ $persentase }}%
                                            </strong>
                                        </li>
                                        <li>
                                            <span>Persentase Ditolak</span>
                                            <strong class="badge bg-danger">
                                                @php
                                                    $persentase_ditolak = $total_dokumen > 0 ? round((($statistik['dokumen_ditolak'] ?? 0) / $total_dokumen) * 100, 1) : 0;
                                                @endphp
                                                {{ $persentase_ditolak }}%
                                            </strong>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="summary-section">
                                    <h6 class="summary-title">🏆 Hasil Seleksi</h6>
                                    <ul class="summary-list">
                                        <li>
                                            <span>Total Hasil</span>
                                            <strong class="badge bg-primary">
                                                {{ ($statistik['hasil_diterima'] ?? 0) + ($statistik['hasil_tidak_diterima'] ?? 0) + ($statistik['hasil_cadangan'] ?? 0) }}
                                            </strong>
                                        </li>
                                        <li>
                                            <span>Persentase Diterima</span>
                                            <strong class="badge bg-success">
                                                @php
                                                    $total_hasil = ($statistik['hasil_diterima'] ?? 0) + ($statistik['hasil_tidak_diterima'] ?? 0) + ($statistik['hasil_cadangan'] ?? 0);
                                                    $persentase_diterima = $total_hasil > 0 ? round((($statistik['hasil_diterima'] ?? 0) / $total_hasil) * 100, 1) : 0;
                                                @endphp
                                                {{ $persentase_diterima }}%
                                            </strong>
                                        </li>
                                        <li>
                                            <span>Persentase Cadangan</span>
                                            <strong class="badge bg-warning">
                                                @php
                                                    $persentase_cadangan = $total_hasil > 0 ? round((($statistik['hasil_cadangan'] ?? 0) / $total_hasil) * 100, 1) : 0;
                                                @endphp
                                                {{ $persentase_cadangan }}%
                                            </strong>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        :root {
            --primary: #4f46e5;
            --primary-dark: #4338ca;
            --success: #10b981;
            --warning: #f59e0b;
            --danger: #ef4444;
            --info: #06b6d4;
            --text-dark: #111827;
            --text-muted: #6b7280;
            --border-light: #e5e7eb;
            --shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1);
            --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }

        /* Summary Cards */
        .summary-card {
            border: none;
            border-radius: 12px;
            box-shadow: var(--shadow-md);
            transition: all 0.3s ease;
            overflow: hidden;
        }

        .summary-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }

        .summary-card-primary {
            background: linear-gradient(135deg, #eef2ff 0%, #f3e8ff 100%);
            border-left: 4px solid var(--primary);
        }

        .summary-card-warning {
            background: linear-gradient(135deg, #fef3c7 0%, #fcd34d 100%);
            border-left: 4px solid var(--warning);
        }

        .summary-card-success {
            background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%);
            border-left: 4px solid var(--success);
        }

        .summary-card-info {
            background: linear-gradient(135deg, #cffafe 0%, #a5f3fc 100%);
            border-left: 4px solid var(--info);
        }

        .card-label {
            font-size: 12px;
            font-weight: 600;
            color: var(--text-muted);
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 8px;
        }

        .card-value {
            font-size: 28px;
            font-weight: 700;
            color: var(--text-dark);
            margin-bottom: 4px;
        }

        .card-info {
            font-size: 13px;
            color: var(--text-muted);
            margin: 0;
        }

        .card-icon {
            font-size: 48px;
            opacity: 0.2;
            color: var(--text-dark);
        }

        /* Progress Items */
        .progress-item {
            margin-bottom: 16px;
        }

        .progress-label {
            font-size: 13px;
            font-weight: 500;
            color: var(--text-dark);
        }

        .progress-value {
            font-size: 13px;
            font-weight: 700;
            padding: 2px 8px;
            border-radius: 4px;
            background-color: rgba(0, 0, 0, 0.05);
        }

        .progress-value.warning {
            color: #d97706;
        }

        .progress-value.success {
            color: #059669;
        }

        .progress-value.danger {
            color: #dc2626;
        }

        .progress-bar {
            height: 8px;
            border-radius: 4px;
            background: linear-gradient(90deg, #fcd34d, #f59e0b);
            width: calc(var(--progress, 0) * 1%);
            transition: width 0.5s ease;
        }

        .progress-bar.success {
            background: linear-gradient(90deg, #6ee7b7, #10b981);
        }

        .progress-bar.danger {
            background: linear-gradient(90deg, #f87171, #ef4444);
        }

        /* Stat Boxes */
        .stat-box {
            padding: 12px 0;
        }

        .stat-value {
            font-size: 20px;
            font-weight: 700;
            margin-bottom: 4px;
        }

        .stat-value.warning {
            color: #d97706;
        }

        .stat-value.success {
            color: #059669;
        }

        .stat-value.danger {
            color: #dc2626;
        }

        .stat-label {
            font-size: 12px;
            font-weight: 600;
            color: var(--text-muted);
            text-transform: uppercase;
        }

        /* Action Cards */
        .action-card {
            border: none;
            border-radius: 12px;
            box-shadow: var(--shadow-md);
        }

        .btn-group-vertical {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .btn-group-vertical .btn {
            border-radius: 8px;
            font-size: 13px;
            font-weight: 600;
            padding: 8px 12px;
            transition: all 0.3s ease;
        }

        .btn-group-vertical .btn:hover {
            transform: translateX(4px);
        }

        /* Publikasi Info */
        .publikasi-info {
            padding: 16px;
            background: linear-gradient(135deg, #e0e7ff 0%, #f3e8ff 100%);
            border-radius: 8px;
        }

        .label-text {
            font-size: 12px;
            font-weight: 700;
            color: var(--text-muted);
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 12px;
            display: block;
        }

        .publikasi-box {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .publikasi-icon {
            width: 48px;
            height: 48px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: white;
            border-radius: 8px;
            font-size: 24px;
            color: var(--primary);
        }

        .publikasi-value {
            font-size: 20px;
            font-weight: 700;
            color: var(--text-dark);
            margin-bottom: 2px;
        }

        .publikasi-label {
            font-size: 12px;
            color: var(--text-muted);
            margin: 0;
        }

        /* Summary Sections */
        .summary-section {
            padding: 0;
        }

        .summary-title {
            font-size: 14px;
            font-weight: 700;
            color: var(--text-dark);
            margin-bottom: 12px;
        }

        .summary-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .summary-list li {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 0;
            border-bottom: 1px solid var(--border-light);
            font-size: 13px;
        }

        .summary-list li:last-child {
            border-bottom: none;
        }

        .summary-list span {
            color: var(--text-muted);
        }

        .summary-list strong {
            font-weight: 600;
        }

        /* Chart Container */
        .chart-container {
            position: relative;
            height: 300px;
            margin-bottom: 16px;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .card-value {
                font-size: 24px;
            }

            .card-icon {
                font-size: 36px;
            }

            .summary-card {
                margin-bottom: 12px;
            }
        }
    </style>

    <!-- Chart.js Library -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Dokumen Verification Chart
        const dokumenCtx = document.getElementById('dokumenChart').getContext('2d');
        new Chart(dokumenCtx, {
            type: 'doughnut',
            data: {
                labels: @json($dokumen_chart['labels'] ?? ['Menunggu', 'Disetujui', 'Ditolak']),
                datasets: [{
                    data: @json($dokumen_chart['data'] ?? [0, 0, 0]),
                    backgroundColor: ['#fbbf24', '#10b981', '#ef4444'],
                    borderColor: ['#fff', '#fff', '#fff'],
                    borderWidth: 3,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            font: { size: 12, weight: 600 },
                            padding: 12,
                            usePointStyle: true
                        }
                    }
                }
            }
        });

        // Hasil Selection Chart
        const hasilCtx = document.getElementById('hasilChart').getContext('2d');
        new Chart(hasilCtx, {
            type: 'doughnut',
            data: {
                labels: @json($hasil_chart['labels'] ?? ['Diterima', 'Tidak Diterima', 'Cadangan']),
                datasets: [{
                    data: @json($hasil_chart['data'] ?? [0, 0, 0]),
                    backgroundColor: ['#10b981', '#ef4444', '#fbbf24'],
                    borderColor: ['#fff', '#fff', '#fff'],
                    borderWidth: 3,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            font: { size: 12, weight: 600 },
                            padding: 12,
                            usePointStyle: true
                        }
                    }
                }
            }
        });
    </script>
@endsection