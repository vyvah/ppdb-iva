@extends('layouts.dashboard')
@section('title', 'Verifikasi Berkas')
@section('content')
    <div class="pc-content">
        <div class="page-header">
            <div class="page-block">
                <div class="row align-items-center">
                    <div class="col-md-12">
                        <div class="page-header-title">
                            <h4 class="m-b-10">Verifikasi Berkas</h4>
                            <p class="text-muted m-b-0">Kelola dan verifikasi dokumen pendaftar PPDB</p>
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
                    <div class="card-header pb-3">
                        <h5>Daftar Dokumen Pendaftar</h5>
                        <span class="text-muted d-block mt-2">
                            Total dokumen menunggu verifikasi:
                            <strong class="text-primary">{{ $dokumens->total() }}</strong>
                        </span>
                    </div>

                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Pendaftar</th>
                                        <th>Email</th>
                                        <th>Dokumen</th>
                                        <th>Tipe Dokumen</th>
                                        <th>Status</th>
                                        <th>Tanggal Upload</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($dokumens as $dokumen)
                                        <tr>
                                            <td>{{ $loop->iteration + ($dokumens->currentPage() - 1) * $dokumens->perPage() }}
                                            </td>
                                            <td>
                                                <strong>{{ $dokumen->user->name ?? 'N/A' }}</strong>
                                            </td>
                                            <td>{{ $dokumen->user->email ?? 'N/A' }}</td>
                                            <td>{{ $dokumen->nama_dokumen }}</td>
                                            <td>
                                                <span class="badge bg-light text-dark">
                                                    {{ ucfirst(str_replace('_', ' ', $dokumen->tipe_dokumen)) }}
                                                </span>
                                            </td>
                                            <td>
                                                @if($dokumen->status_verifikasi === 'disetujui')
                                                    <span class="badge bg-success">Disetujui</span>
                                                @elseif($dokumen->status_verifikasi === 'ditolak')
                                                    <span class="badge bg-danger">Ditolak</span>
                                                @else
                                                    <span class="badge bg-warning text-dark">Menunggu</span>
                                                @endif
                                            </td>
                                            <td>{{ $dokumen->created_at->format('d M Y H:i') }}</td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <button type="button" class="btn btn-sm btn-info" data-bs-toggle="modal"
                                                        data-bs-target="#detailModal" data-dokumen-id="{{ $dokumen->id }}">
                                                        <i class="ti ti-eye"></i> Detail
                                                    </button>
                                                    <a href="{{ route('admin.verifikasi.download', $dokumen->id) }}"
                                                        class="btn btn-sm btn-secondary">
                                                        <i class="ti ti-download"></i> Download
                                                    </a>
                                                    <button type="button" class="btn btn-sm btn-success"
                                                        onclick="verifikasiDokumen({{ $dokumen->id }}, 'disetujui')">
                                                        <i class="ti ti-check"></i> Setujui
                                                    </button>
                                                    <button type="button" class="btn btn-sm btn-danger"
                                                        onclick="verifikasiDokumen({{ $dokumen->id }}, 'ditolak')">
                                                        <i class="ti ti-x"></i> Tolak
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="8" class="text-center text-muted py-4">
                                                <i class="ti ti-inbox"></i>
                                                <p class="m-0 mt-2">Tidak ada dokumen untuk diverifikasi</p>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        <div class="mt-4">
                            {{ $dokumens->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Detail Dokumen -->
    <div class="modal fade" id="detailModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Detail Dokumen</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="detailContent">
                    <div class="text-center">
                        <div class="spinner-border" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Verifikasi -->
    <div class="modal fade" id="verifikasiModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Verifikasi Dokumen</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="verifikasiForm">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="statusVerifikasi" class="form-label">Status Verifikasi</label>
                            <select class="form-select" id="statusVerifikasi" name="status_verifikasi" required>
                                <option value="">Pilih Status...</option>
                                <option value="disetujui">Disetujui</option>
                                <option value="ditolak">Ditolak</option>
                                <option value="menunggu">Menunggu</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="catatanVerifikasi" class="form-label">Catatan Verifikasi</label>
                            <textarea class="form-control" id="catatanVerifikasi" name="catatan_verifikasi" rows="3"
                                placeholder="Masukkan catatan verifikasi..."></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan Verifikasi</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        let currentDokumenId = null;

        // Handle detail modal
        document.getElementById('detailModal').addEventListener('show.bs.modal', function (e) {
            const button = e.relatedTarget;
            const dokumenId = button.dataset.dokumenId;
            currentDokumenId = dokumenId;

            // Fetch dokumen detail
            fetch(`/admin/dokumen/${dokumenId}`)
                .then(response => response.json())
                .then(data => {
                    const dokumen = data.dokumen;
                    let html = `
                            <div class="row">
                                <div class="col-md-6">
                                    <p><strong>Nama Pendaftar:</strong><br>${dokumen.user.name}</p>
                                    <p><strong>Email:</strong><br>${dokumen.user.email}</p>
                                    <p><strong>Dokumen:</strong><br>${dokumen.nama_dokumen}</p>
                                </div>
                                <div class="col-md-6">
                                    <p><strong>Tipe Dokumen:</strong><br>${dokumen.tipe_dokumen}</p>
                                    <p><strong>Tanggal Upload:</strong><br>${new Date(dokumen.created_at).toLocaleDateString('id-ID')}</p>
                                    <p><strong>Status:</strong><br>
                                        <span class="badge bg-${dokumen.status_verifikasi === 'disetujui' ? 'success' : dokumen.status_verifikasi === 'ditolak' ? 'danger' : 'warning'}">
                                            ${dokumen.status_verifikasi}
                                        </span>
                                    </p>
                                </div>
                            </div>
                        `;

                    if (dokumen.catatan_verifikasi) {
                        html += `<div class="mt-3"><strong>Catatan Verifikasi:</strong><p class="text-muted">${dokumen.catatan_verifikasi}</p></div>`;
                    }

                    document.getElementById('detailContent').innerHTML = html;
                });
        });

        function verifikasiDokumen(dokumenId, status) {
            currentDokumenId = dokumenId;
            document.getElementById('statusVerifikasi').value = status;

            const verifikasiModal = new bootstrap.Modal(document.getElementById('verifikasiModal'));
            verifikasiModal.show();
        }

        // Handle verifikasi form submission
        document.getElementById('verifikasiForm').addEventListener('submit', function (e) {
            e.preventDefault();

            const formData = {
                status_verifikasi: document.getElementById('statusVerifikasi').value,
                catatan_verifikasi: document.getElementById('catatanVerifikasi').value,
            };

            fetch(`/admin/dokumen/${currentDokumenId}/update-status`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                },
                body: JSON.stringify(formData),
            })
                .then(response => response.json())
                .then(data => {
                    alert(data.message);
                    bootstrap.Modal.getInstance(document.getElementById('verifikasiModal')).hide();
                    location.reload();
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Terjadi kesalahan saat memproses verifikasi');
                });
        });
    </script>
@endsection