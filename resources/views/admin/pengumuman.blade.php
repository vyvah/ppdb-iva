@extends('layouts.dashboard')
@section('title', 'Pengumuman')
@section('content')
    <div class="pc-content">
        <div class="page-header">
            <div class="page-block">
                <div class="row align-items-center">
                    <div class="col-md-12">
                        <div class="page-header-title">
                            <h4 class="m-b-10">Pengumuman Hasil Seleksi</h4>
                            <p class="text-muted m-b-0">Kelola dan publikasikan hasil seleksi PPDB</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="pc-content">
        <!-- Statistik Ringkas -->
        <div class="row mb-3">
            <div class="col-md-3 col-sm-6 col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1">
                                <p class="text-muted mb-0">Total Hasil</p>
                                <h4 class="mb-0">{{ $statistik['total'] }}</h4>
                            </div>
                            <i class="ti ti-users text-primary" style="font-size: 32px; opacity: 0.5;"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1">
                                <p class="text-muted mb-0">Diterima</p>
                                <h4 class="mb-0 text-success">{{ $statistik['diterima'] }}</h4>
                            </div>
                            <i class="ti ti-check-circle text-success" style="font-size: 32px; opacity: 0.5;"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1">
                                <p class="text-muted mb-0">Tidak Diterima</p>
                                <h4 class="mb-0 text-danger">{{ $statistik['tidak_diterima'] }}</h4>
                            </div>
                            <i class="ti ti-circle-x text-danger" style="font-size: 32px; opacity: 0.5;"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1">
                                <p class="text-muted mb-0">Cadangan</p>
                                <h4 class="mb-0 text-warning">{{ $statistik['cadangan'] }}</h4>
                            </div>
                            <i class="ti ti-clock text-warning" style="font-size: 32px; opacity: 0.5;"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tabel Pengumuman -->
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header pb-3 d-flex align-items-center justify-content-between">
                        <h5>Daftar Hasil Seleksi</h5>
                        <div>
                            <button type="button" class="btn btn-primary me-2" data-bs-toggle="modal" data-bs-target="#tambahPengumumanModal">
                                <i class="ti ti-plus"></i> Tambah Hasil
                            </button>
                            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#importModal">
                                <i class="ti ti-upload"></i> Import CSV
                            </button>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>No. Pendaftaran</th>
                                        <th>Nama Peserta</th>
                                        <th>Status Hasil</th>
                                        <th>Nilai Akhir</th>
                                        <th>Dipublikasikan</th>
                                        <th>Tanggal Pengumuman</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($pengumans as $penguman)
                                        <tr>
                                            <td>{{ $loop->iteration + ($pengumans->currentPage() - 1) * $pengumans->perPage() }}</td>
                                            <td><strong>{{ $penguman->nomor_pendaftaran }}</strong></td>
                                            <td>{{ $penguman->nama_peserta }}</td>
                                            <td>
                                                @if($penguman->status_hasil === 'diterima')
                                                    <span class="badge bg-success">Diterima</span>
                                                @elseif($penguman->status_hasil === 'tidak_diterima')
                                                    <span class="badge bg-danger">Tidak Diterima</span>
                                                @else
                                                    <span class="badge bg-warning text-dark">Cadangan</span>
                                                @endif
                                            </td>
                                            <td>{{ $penguman->nilai_akhir ?? '-' }}</td>
                                            <td>
                                                <form action="{{ route('admin.pengumuman.publikasikan', $penguman->id) }}"
                                                    method="POST" style="display: inline;">
                                                    @csrf
                                                    <div class="form-check form-switch">
                                                        <input class="form-check-input" type="checkbox"
                                                            id="switch{{ $penguman->id }}"
                                                            {{ $penguman->di_publikasikan ? 'checked' : '' }}
                                                            onchange="this.form.submit()">
                                                        <label class="form-check-label" for="switch{{ $penguman->id }}">
                                                            {{ $penguman->di_publikasikan ? 'Ya' : 'Tidak' }}
                                                        </label>
                                                    </div>
                                                </form>
                                            </td>
                                            <td>{{ $penguman->tanggal_pengumuman ? $penguman->tanggal_pengumuman->format('d M Y') : '-' }}</td>
                                            <td>
                                                <div class="btn-group btn-group-sm" role="group">
                                                    <button type="button" class="btn btn-info"
                                                        onclick="editPengumuman({{ $penguman->id }}, '{{ $penguman->status_hasil }}', {{ $penguman->nilai_akhir ?? 'null' }}, '{{ addslashes($penguman->pesan_pengumuman) }}')">
                                                        <i class="ti ti-edit"></i> Edit
                                                    </button>
                                                    <button type="button" class="btn btn-danger"
                                                        onclick="hapusPengumuman({{ $penguman->id }})">
                                                        <i class="ti ti-trash"></i> Hapus
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="8" class="text-center text-muted py-4">
                                                <i class="ti ti-inbox"></i>
                                                <p class="m-0 mt-2">Tidak ada data pengumuman</p>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        <div class="mt-4">
                            {{ $pengumans->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Tambah/Edit Pengumuman -->
    <div class="modal fade" id="tambahPengumumanModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah/Edit Hasil Seleksi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="formPengumuman">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="biodataId" class="form-label">Pilih Peserta</label>
                            <select class="form-select" id="biodataId" name="biodata_id" required>
                                <option value="">-- Pilih Peserta --</option>
                                <!-- Options akan diisi dengan JavaScript -->
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="statusHasil" class="form-label">Status Hasil</label>
                            <select class="form-select" id="statusHasil" name="status_hasil" required>
                                <option value="">-- Pilih Status --</option>
                                <option value="diterima">Diterima</option>
                                <option value="tidak_diterima">Tidak Diterima</option>
                                <option value="cadangan">Cadangan</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="nilaiAkhir" class="form-label">Nilai Akhir</label>
                            <input type="number" class="form-control" id="nilaiAkhir" name="nilai_akhir"
                                step="0.01" min="0" max="100" placeholder="Contoh: 85.50">
                        </div>
                        <div class="mb-3">
                            <label for="pesanPengumuman" class="form-label">Pesan Pengumuman</label>
                            <textarea class="form-control" id="pesanPengumuman" name="pesan_pengumuman"
                                rows="3" placeholder="Masukkan pesan pengumuman (opsional)"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Import CSV -->
    <div class="modal fade" id="importModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Import Data Pengumuman</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="formImport">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="fileImport" class="form-label">Pilih File CSV</label>
                            <input type="file" class="form-control" id="fileImport" name="file" accept=".csv,.txt" required>
                            <small class="text-muted d-block mt-2">
                                Format CSV: nomor_pendaftaran, nama_peserta, status_hasil, nilai_akhir
                            </small>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Import</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        let currentPengumumanId = null;

        // Load biodata options
        document.addEventListener('DOMContentLoaded', function() {
            loadBiodataOptions();
        });

        function loadBiodataOptions() {
            fetch('/admin/biodata-list')
                .then(response => response.json())
                .then(data => {
                    const select = document.getElementById('biodataId');
                    select.innerHTML = '<option value="">-- Pilih Peserta --</option>';
                    data.forEach(biodata => {
                        const option = document.createElement('option');
                        option.value = biodata.id;
                        option.textContent = `${biodata.nomor_pendaftaran} - ${biodata.nama_lengkap}`;
                        select.appendChild(option);
                    });
                })
                .catch(error => console.error('Error loading biodata:', error));
        }

        function editPengumuman(id, status, nilai, pesan) {
            currentPengumumanId = id;
            document.getElementById('statusHasil').value = status;
            document.getElementById('nilaiAkhir').value = nilai || '';
            document.getElementById('pesanPengumuman').value = pesan || '';

            const modal = new bootstrap.Modal(document.getElementById('tambahPengumumanModal'));
            modal.show();
        }

        function hapusPengumuman(id) {
            if (confirm('Apakah Anda yakin ingin menghapus pengumuman ini?')) {
                fetch(`/admin/pengumuman/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    },
                })
                .then(response => response.json())
                .then(data => {
                    alert(data.message);
                    location.reload();
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Terjadi kesalahan saat menghapus pengumuman');
                });
            }
        }

        // Handle form submission
        document.getElementById('formPengumuman').addEventListener('submit', function(e) {
            e.preventDefault();

            const formData = {
                biodata_id: document.getElementById('biodataId').value,
                status_hasil: document.getElementById('statusHasil').value,
                nilai_akhir: document.getElementById('nilaiAkhir').value || null,
                pesan_pengumuman: document.getElementById('pesanPengumuman').value || null,
            };

            fetch('/admin/pengumuman', {
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
                bootstrap.Modal.getInstance(document.getElementById('tambahPengumumanModal')).hide();
                location.reload();
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Terjadi kesalahan saat menyimpan pengumuman');
            });
        });

        // Handle import CSV
        document.getElementById('formImport').addEventListener('submit', function(e) {
            e.preventDefault();

            const formData = new FormData();
            formData.append('file', document.getElementById('fileImport').files[0]);

            fetch('/admin/pengumuman/import', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                },
                body: formData,
            })
            .then(response => response.json())
            .then(data => {
                alert(data.message);
                bootstrap.Modal.getInstance(document.getElementById('importModal')).hide();
                location.reload();
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Terjadi kesalahan saat import data');
            });
        });
    </script>
@endsection
