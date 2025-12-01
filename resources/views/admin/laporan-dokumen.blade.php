@extends('layouts.dashboard')
@section('title', 'Laporan Detail - ' . ucfirst($status))
@section('content')
    <div class="pc-content">
        <div class="page-header">
            <div class="page-block">
                <div class="row align-items-center">
                    <div class="col-md-12">
                        <div class="page-header-title">
                            <h4 class="m-b-10">
                                <i class="ti ti-file-check"></i> Detail Laporan Dokumen
                            </h4>
                            <p class="text-muted m-b-0">Status: <strong class="text-primary">{{ ucfirst($status) }}</strong>
                            </p>
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
                                    <i class="ti ti-list"></i> Daftar Dokumen -
                                    {{ ucfirst(str_replace('_', ' ', $status)) }}
                                </h5>
                                <p class="text-muted small mt-2 mb-0">Total: <strong>{{ $dokumens->total() }}
                                        dokumen</strong></p>
                            </div>
                            <a href="{{ route('admin.laporan') }}" class="btn btn-sm btn-outline-secondary">
                                <i class="ti ti-arrow-left"></i> Kembali ke Laporan
                            </a>
                        </div>
                    </div>

                    <div class="card-body">
                        @if($dokumens->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-hover table-modern mb-0">
                                    <thead class="table-header">
                                        <tr>
                                            <th width="5%">No</th>
                                            <th width="15%">Nama Pendaftar</th>
                                            <th width="15%">Email</th>
                                            <th width="15%">Nama Dokumen</th>
                                            <th width="12%">Tipe Dokumen</th>
                                            <th width="12%">Upload</th>
                                            <th width="12%">Verifikasi</th>
                                            <th width="14%">Catatan</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($dokumens as $dokumen)
                                            <tr class="table-row">
                                                <td>
                                                    <span
                                                        class="row-number">{{ $loop->iteration + ($dokumens->currentPage() - 1) * $dokumens->perPage() }}</span>
                                                </td>
                                                <td>
                                                    <strong class="text-dark">{{ $dokumen->user->name ?? 'N/A' }}</strong>
                                                </td>
                                                <td>
                                                    <small class="text-muted">{{ $dokumen->user->email ?? 'N/A' }}</small>
                                                </td>
                                                <td>
                                                    <span class="doc-name">{{ $dokumen->nama_dokumen }}</span>
                                                </td>
                                                <td>
                                                    <span
                                                        class="badge badge-custom {{ strtolower(str_replace(' ', '-', $dokumen->tipe_dokumen)) }}">
                                                        <i class="ti ti-tag"></i>
                                                        {{ ucfirst(str_replace('_', ' ', $dokumen->tipe_dokumen)) }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <small class="date-text">
                                                        <i class="ti ti-calendar"></i>
                                                        {{ $dokumen->created_at->format('d M Y') }}
                                                    </small>
                                                    <br>
                                                    <small class="time-text">{{ $dokumen->created_at->format('H:i') }}</small>
                                                </td>
                                                <td>
                                                    @if($dokumen->tanggal_verifikasi)
                                                        <small class="date-text">
                                                            <i class="ti ti-check"></i>
                                                            {{ $dokumen->tanggal_verifikasi->format('d M Y') }}
                                                        </small>
                                                        <br>
                                                        <small
                                                            class="time-text">{{ $dokumen->tanggal_verifikasi->format('H:i') }}</small>
                                                    @else
                                                        <small class="badge bg-warning text-dark">
                                                            <i class="ti ti-clock"></i> Belum Diverifikasi
                                                        </small>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if($dokumen->catatan_verifikasi)
                                                        <small class="catatan-box" title="{{ $dokumen->catatan_verifikasi }}">
                                                            {{ Str::limit($dokumen->catatan_verifikasi, 20) }}
                                                        </small>
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
                                {{ $dokumens->links() }}
                            </div>
                        @else
                            <!-- Empty State -->
                            <div class="empty-state">
                                <div class="empty-icon">
                                    <i class="ti ti-inbox"></i>
                                </div>
                                <h5>Tidak Ada Data</h5>
                                <p class="text-muted">Tidak ada dokumen dengan status {{ ucfirst($status) }}</p>
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
        }

        .table-row:hover {
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            transform: translateY(-2px);
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

        .doc-name {
            color: var(--text-dark);
            font-weight: 500;
        }

        .badge-custom {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            padding: 4px 8px;
            border-radius: 6px;
            font-size: 12px;
            font-weight: 600;
        }

        .badge-custom.kartu-keluarga {
            background: #dbeafe;
            color: #1e40af;
        }

        .badge-custom.ijazah {
            background: #dcfce7;
            color: #166534;
        }

        .badge-custom.akte-lahir {
            background: #fce7f3;
            color: #831843;
        }

        .badge-custom.rapor {
            background: #fef3c7;
            color: #92400e;
        }

        .badge-custom.foto {
            background: #e0e7ff;
            color: #3730a3;
        }

        .date-text {
            color: var(--text-dark);
            font-weight: 500;
        }

        .time-text {
            color: var(--text-muted);
        }

        .catatan-box {
            background: #f3f4f6;
            padding: 4px 8px;
            border-radius: 4px;
            color: var(--text-muted);
            display: inline-block;
            cursor: help;
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

            .doc-name {
                max-width: 100px;
                white-space: nowrap;
                overflow: hidden;
                text-overflow: ellipsis;
            }
        }
    </style>
@endsection