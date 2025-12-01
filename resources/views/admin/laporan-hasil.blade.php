@extends('layouts.dashboard')
@section('title', 'Laporan Detail - ' . ucfirst(str_replace('_', ' ', $status)))
@section('content')
    <div class="pc-content">
        <div class="page-header">
            <div class="page-block">
                <div class="row align-items-center">
                    <div class="col-md-12">
                        <div class="page-header-title">
                            <h4 class="m-b-10">
                                <i class="ti ti-badge-check"></i> Detail Laporan Hasil Seleksi
                            </h4>
                            <p class="text-muted m-b-0">Status: <strong
                                    class="text-primary">{{ ucfirst(str_replace('_', ' ', $status)) }}</strong></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="pc-content">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header pb-3 border-bottom">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h5 class="mb-0">
                                    <i class="ti ti-list"></i> Daftar Hasil - {{ ucfirst(str_replace('_', ' ', $status)) }}
                                </h5>
                                <p class="text-muted small mt-2 mb-0">Total: <strong>{{ $pengumans->total() }}
                                        peserta</strong></p>
                            </div>
                            <a href="{{ route('admin.laporan') }}" class="btn btn-sm btn-outline-secondary">
                                <i class="ti ti-arrow-left"></i> Kembali ke Laporan
                            </a>
                        </div>
                    </div>

                    <div class="card-body">
                        @if($pengumans->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-hover table-modern mb-0">
                                    <thead class="table-header">
                                        <tr>
                                            <th width="5%">No</th>
                                            <th width="12%">No. Pendaftaran</th>
                                            <th width="18%">Nama Peserta</th>
                                            <th width="10%">Nilai Akhir</th>
                                            <th width="12%">Status Hasil</th>
                                            <th width="14%">Tanggal Pengumuman</th>
                                            <th width="29%">Pesan</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($pengumans as $penguman)
                                            <tr class="table-row status-{{ strtolower($penguman->status_hasil ?? 'unknown') }}">
                                                <td>
                                                    <span
                                                        class="row-number">{{ $loop->iteration + ($pengumans->currentPage() - 1) * $pengumans->perPage() }}</span>
                                                </td>
                                                <td>
                                                    <strong class="text-dark">{{ $penguman->nomor_pendaftaran }}</strong>
                                                </td>
                                                <td>
                                                    <div class="peserta-info">
                                                        <p class="peserta-name">{{ $penguman->nama_peserta }}</p>
                                                    </div>
                                                </td>
                                                <td>
                                                    @if($penguman->nilai_akhir)
                                                        <span class="nilai-badge">
                                                            {{ number_format($penguman->nilai_akhir, 2) }}
                                                        </span>
                                                    @else
                                                        <small class="text-muted">-</small>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if($penguman->status_hasil === 'diterima')
                                                        <span class="status-badge status-diterima">
                                                            <i class="ti ti-check-circle"></i> Diterima
                                                        </span>
                                                    @elseif($penguman->status_hasil === 'tidak_diterima')
                                                        <span class="status-badge status-tolak">
                                                            <i class="ti ti-circle-x"></i> Tidak Diterima
                                                        </span>
                                                    @else
                                                        <span class="status-badge status-cadangan">
                                                            <i class="ti ti-alert-circle"></i> Cadangan
                                                        </span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if($penguman->tanggal_pengumuman)
                                                        <small class="date-text">
                                                            <i class="ti ti-calendar"></i>
                                                            {{ $penguman->tanggal_pengumuman->format('d M Y') }}
                                                        </small>
                                                    @else
                                                        <small class="badge bg-secondary">
                                                            <i class="ti ti-clock"></i> Belum Diumumkan
                                                        </small>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if($penguman->pesan_pengumuman)
                                                        <div class="pesan-box" title="{{ $penguman->pesan_pengumuman }}">
                                                            <small>{{ Str::limit($penguman->pesan_pengumuman, 40) }}</small>
                                                        </div>
                                                    @else
                                                        <small class="text-muted">-</small>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <!-- Pagination -->
                            <div class="mt-4 d-flex justify-content-center">
                                {{ $pengumans->links() }}
                            </div>
                        @else
                            <!-- Empty State -->
                            <div class="empty-state">
                                <div class="empty-icon">
                                    <i class="ti ti-inbox"></i>
                                </div>
                                <h5>Tidak Ada Data</h5>
                                <p class="text-muted">Tidak ada hasil dengan status
                                    {{ ucfirst(str_replace('_', ' ', $status)) }}</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        :root {
            --primary: #4f46e5;
            --success: #10b981;
            --warning: #f59e0b;
            --danger: #ef4444;
            --text-dark: #111827;
            --text-muted: #6b7280;
            --border-light: #e5e7eb;
            --shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1);
        }

        .table-modern {
            border-collapse: separate;
            border-spacing: 0 8px;
        }

        .table-header {
            background: linear-gradient(135deg, #f3f4f6 0%, #e5e7eb 100%);
        }

        .table-header th {
            font-weight: 700;
            color: var(--text-dark);
            border: none;
            padding: 12px 16px;
            font-size: 13px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .table-row {
            background: white;
            border-radius: 8px;
            box-shadow: var(--shadow);
            transition: all 0.3s ease;
            border-left: 4px solid transparent;
        }

        .table-row:hover {
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            transform: translateY(-2px);
        }

        .table-row.status-diterima {
            border-left-color: var(--success);
        }

        .table-row.status-tidak_diterima {
            border-left-color: var(--danger);
        }

        .table-row.status-cadangan {
            border-left-color: var(--warning);
        }

        .table-row td {
            padding: 14px 16px;
            border: none;
            vertical-align: middle;
        }

        .table-row td:first-child {
            border-radius: 8px 0 0 8px;
        }

        .table-row td:last-child {
            border-radius: 0 8px 8px 0;
        }

        .row-number {
            display: inline-block;
            width: 24px;
            height: 24px;
            background: linear-gradient(135deg, var(--primary), #06b6d4);
            color: white;
            border-radius: 50%;
            text-align: center;
            line-height: 24px;
            font-size: 12px;
            font-weight: 700;
        }

        .peserta-info {
            margin: 0;
        }

        .peserta-name {
            font-weight: 600;
            color: var(--text-dark);
            margin: 0;
        }

        .nilai-badge {
            display: inline-block;
            background: linear-gradient(135deg, var(--primary), #06b6d4);
            color: white;
            padding: 4px 12px;
            border-radius: 20px;
            font-weight: 700;
            font-size: 12px;
        }

        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            padding: 6px 12px;
            border-radius: 6px;
            font-size: 12px;
            font-weight: 700;
        }

        .status-diterima {
            background: #dcfce7;
            color: #166534;
        }

        .status-tolak {
            background: #fee2e2;
            color: #991b1b;
        }

        .status-cadangan {
            background: #fef3c7;
            color: #92400e;
        }

        .date-text {
            color: var(--text-dark);
            font-weight: 500;
        }

        .pesan-box {
            background: #f3f4f6;
            padding: 6px 10px;
            border-radius: 4px;
            color: var(--text-muted);
            display: inline-block;
            cursor: help;
            border-left: 2px solid var(--primary);
        }

        .empty-state {
            text-align: center;
            padding: 60px 20px;
        }

        .empty-icon {
            font-size: 64px;
            color: var(--text-muted);
            opacity: 0.3;
            margin-bottom: 16px;
        }

        .empty-state h5 {
            color: var(--text-dark);
            margin-bottom: 8px;
        }

        .empty-state p {
            margin: 0;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .table-modern {
                border-spacing: 0 4px;
            }

            .table-header th {
                font-size: 12px;
                padding: 10px 12px;
            }

            .table-row td {
                padding: 10px 12px;
                font-size: 12px;
            }

            .peserta-name {
                max-width: 120px;
                white-space: nowrap;
                overflow: hidden;
                text-overflow: ellipsis;
            }

            .pesan-box small {
                display: block;
                overflow: hidden;
                text-overflow: ellipsis;
                white-space: nowrap;
                max-width: 100px;
            }
        }
    </style>
@endsection