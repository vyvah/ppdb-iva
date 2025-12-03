@extends('layouts.dashboard')
@section('title', 'Seleksi Admin')

@section('content')

<div class="container-modern" style="padding:20px">

    <div class="header-modern" style="padding:20px;margin-bottom:20px">
        <h2>Seleksi Peserta (Admin)</h2>
        <p class="text-muted mb-0">Gunakan halaman ini untuk menetapkan hasil seleksi peserta yang telah melengkapi data.</p>
    </div>

    <div class="card-modern" style="padding:18px; border:1px solid #ececec;">

        <div class="d-flex justify-content-between mb-3">
            <div>
                <input id="search" class="form-control" placeholder="Cari nama atau nomor pendaftaran" style="min-width:320px">
            </div>
            <div>
                <button id="refreshBtn" class="btn btn-secondary">Refresh</button>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-striped" id="biodataTable">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nomor Pendaftaran</th>
                        <th>Nama Lengkap</th>
                        <th>Status Data</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td colspan="5">Memuat data...</td></tr>
                </tbody>
            </table>
        </div>

    </div>

</div>

<!-- Modal Detail Peserta & Seleksi -->
<div class="modal fade" id="seleksiModal" tabindex="-1" aria-labelledby="seleksiModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="seleksiForm">
                @csrf
                <input type="hidden" name="biodata_id" id="biodata_id">
                <div class="modal-header">
                    <h5 class="modal-title" id="seleksiModalLabel">Seleksi & Detail Peserta</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    
                    <!-- Tab Navigation -->
                    <ul class="nav nav-tabs mb-3" id="detailTabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="biodata-tab" data-bs-toggle="tab" data-bs-target="#biodata-content" type="button" role="tab">Biodata</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="orangtua-tab" data-bs-toggle="tab" data-bs-target="#orangtua-content" type="button" role="tab">Data Orang Tua</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="dokumen-tab" data-bs-toggle="tab" data-bs-target="#dokumen-content" type="button" role="tab">Dokumen</button>
                        </li>
                    </ul>

                    <!-- Tab Content -->
                    <div class="tab-content" id="detailTabsContent">
                        <!-- Biodata Tab -->
                        <div class="tab-pane fade show active" id="biodata-content" role="tabpanel">
                            <div id="biodataContent" class="mb-3">
                                <p class="text-muted">Memuat data biodata...</p>
                            </div>
                        </div>

                        <!-- Orangtua Tab -->
                        <div class="tab-pane fade" id="orangtua-content" role="tabpanel">
                            <div id="orangtuaContent" class="mb-3">
                                <p class="text-muted">Memuat data orang tua...</p>
                            </div>
                        </div>

                        <!-- Dokumen Tab -->
                        <div class="tab-pane fade" id="dokumen-content" role="tabpanel">
                            <div id="dokumenContent" class="mb-3">
                                <p class="text-muted">Memuat data dokumen...</p>
                            </div>
                        </div>
                    </div>

                    <hr class="my-4">

                    <!-- Seleksi Section -->
                    <h6 class="mb-3">Tentukan Hasil Seleksi</h6>

                    <div class="mb-3">
                        <label class="form-label">Status Hasil</label>
                        <div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="status_hasil" id="status_diterima" value="diterima" required>
                                <label class="form-check-label" for="status_diterima">Diterima</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="status_hasil" id="status_cadangan" value="cadangan" required>
                                <label class="form-check-label" for="status_cadangan">Cadangan</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="status_hasil" id="status_tidak" value="tidak_diterima" required>
                                <label class="form-check-label" for="status_tidak">Tidak Diterima</label>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Nilai Akhir (opsional)</label>
                        <input type="number" step="0.01" min="0" max="100" name="nilai_akhir" class="form-control" id="nilai_akhir">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Pesan Pengumuman (opsional)</label>
                        <textarea name="pesan_pengumuman" id="pesan_pengumuman" rows="4" class="form-control"></textarea>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan Hasil Seleksi</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    (function(){
        const biodataUrl = '{{ url('/admin/biodata-list') }}';
        const storeUrl = '{{ route('admin.pengumuman.store') }}';  // PengumumanController@store

        const tableBody = document.querySelector('#biodataTable tbody');
        const searchInput = document.getElementById('search');
        const refreshBtn = document.getElementById('refreshBtn');

        let biodatas = [];

        function fetchBiodata(){
            tableBody.innerHTML = '<tr><td colspan="5">Memuat data...</td></tr>';
            fetch(biodataUrl, {headers: {'X-Requested-With':'XMLHttpRequest'}})
                .then(r => r.json())
                .then(data => {
                    biodatas = data;
                    renderTable(data);
                })
                .catch(err => {
                    tableBody.innerHTML = '<tr><td colspan="5" class="text-danger">Gagal memuat data.</td></tr>';
                    console.error(err);
                });
        }

        function getStatusData(user) {
            let statuses = [];
            
            // Check biodata
            if (user.nomor_pendaftaran) statuses.push('✓ Biodata');
            
            // Check orangtua
            if (user.nama_ayah || user.nama_ibu) statuses.push('✓ Orang Tua');
            
            // Check dokumen
            if (user.kk || user.akte || user.bukti_transfer) statuses.push('✓ Dokumen');
            
            return statuses.length > 0 ? statuses.join(', ') : '<span class="text-warning">Belum lengkap</span>';
        }

        function renderTable(list){
            if(!list || list.length === 0){
                tableBody.innerHTML = '<tr><td colspan="5">Tidak ada data.</td></tr>';
                return;
            }

            const rows = list.map((b, idx) => {
                // Get user data with additional info
                let statusData = getStatusData(b.user || {});
                
                return `
                    <tr>
                        <td>${idx + 1}</td>
                        <td>${b.nomor_pendaftaran}</td>
                        <td>${b.nama_lengkap}</td>
                        <td>${statusData}</td>
                        <td>
                            <button class="btn btn-sm btn-primary btn-seleksi" data-id="${b.id}" data-user-id="${b.user_id}" data-nomor="${b.nomor_pendaftaran}" data-nama="${b.nama_lengkap}">Seleksi</button>
                        </td>
                    </tr>
                `;
            }).join('');

            tableBody.innerHTML = rows;

            document.querySelectorAll('.btn-seleksi').forEach(btn => {
                btn.addEventListener('click', (e) => {
                    const id = btn.dataset.id;
                    const userId = btn.dataset.userId;
                    const nama = btn.dataset.nama;
                    const nomor = btn.dataset.nomor;
                    openModal(id, userId, nama, nomor);
                });
            });
        }

        function openModal(biodataId, userId, nama, nomor){
            document.getElementById('biodata_id').value = biodataId;
            document.getElementById('nilai_akhir').value = '';
            document.getElementById('pesan_pengumuman').value = '';
            document.querySelectorAll('#seleksiForm input[name="status_hasil"]').forEach(i => i.checked = false);
            
            // Load detail data
            loadDetailData(userId);
            
            var modal = new bootstrap.Modal(document.getElementById('seleksiModal'));
            modal.show();
        }

        function loadDetailData(userId) {
            // Fetch user detail data from the server
            fetch(`/admin/user-detail/${userId}`, {headers: {'X-Requested-With':'XMLHttpRequest'}})
                .then(r => {
                    if (!r.ok) {
                        throw new Error(`HTTP error! status: ${r.status}`);
                    }
                    return r.json();
                })
                .then(data => {
                    const user = data.user;
                    
                    // Populate biodata
                    let biodataHtml = `
                        <p><strong>Nomor Pendaftaran:</strong> ${user.biodata?.nomor_pendaftaran || '-'}</p>
                        <p><strong>Nama Lengkap:</strong> ${user.biodata?.nama_lengkap || '-'}</p>
                        <p><strong>Tempat Lahir:</strong> ${user.biodata?.tempat_lahir || '-'}</p>
                        <p><strong>Tanggal Lahir:</strong> ${user.biodata?.tanggal_lahir || '-'}</p>
                        <p><strong>Jenis Kelamin:</strong> ${user.biodata?.jenis_kelamin || '-'}</p>
                        <p><strong>Agama:</strong> ${user.biodata?.agama || '-'}</p>
                    `;
                    document.getElementById('biodataContent').innerHTML = biodataHtml;
                    
                    // Populate orangtua
                    let orangtuaHtml = `
                        <h6>Data Ayah</h6>
                        <p><strong>Nama:</strong> ${user.nama_ayah || '-'}</p>
                        <p><strong>NIK:</strong> ${user.nik_ayah || '-'}</p>
                        <p><strong>Pekerjaan:</strong> ${user.pekerjaan_ayah || '-'}</p>
                        <p><strong>Telepon:</strong> ${user.telepon_ayah || '-'}</p>
                        
                        <h6 class="mt-3">Data Ibu</h6>
                        <p><strong>Nama:</strong> ${user.nama_ibu || '-'}</p>
                        <p><strong>NIK:</strong> ${user.nik_ibu || '-'}</p>
                        <p><strong>Pekerjaan:</strong> ${user.pekerjaan_ibu || '-'}</p>
                        <p><strong>Telepon:</strong> ${user.telepon_ibu || '-'}</p>
                        
                        <h6 class="mt-3">Alamat Orang Tua</h6>
                        <p><strong>Alamat:</strong> ${user.alamat_ortu || '-'}</p>
                        <p><strong>RT/RW:</strong> ${user.rt_ortu || '-'} / ${user.rw_ortu || '-'}</p>
                        <p><strong>Kelurahan:</strong> ${user.kelurahan_ortu || '-'}</p>
                        <p><strong>Kecamatan:</strong> ${user.kecamatan_ortu || '-'}</p>
                        <p><strong>Kabupaten:</strong> ${user.kabupaten_ortu || '-'}</p>
                        <p><strong>Provinsi:</strong> ${user.provinsi_ortu || '-'}</p>
                        <p><strong>Kode Pos:</strong> ${user.kode_pos_ortu || '-'}</p>
                    `;
                    document.getElementById('orangtuaContent').innerHTML = orangtuaHtml;
                    
                    // Populate dokumen
                    let dokumenHtml = '<div class="list-group">';
                    if (user.kk) {
                        dokumenHtml += `<div class="list-group-item"><strong>Kartu Keluarga:</strong> Ada <a href="/storage/dokumen/${user.kk}" target="_blank" class="ms-2">Lihat</a></div>`;
                    } else {
                        dokumenHtml += `<div class="list-group-item"><strong>Kartu Keluarga:</strong> Belum diunggah</div>`;
                    }
                    
                    if (user.akte) {
                        dokumenHtml += `<div class="list-group-item"><strong>Akte Kelahiran:</strong> Ada <a href="/storage/dokumen/${user.akte}" target="_blank" class="ms-2">Lihat</a></div>`;
                    } else {
                        dokumenHtml += `<div class="list-group-item"><strong>Akte Kelahiran:</strong> Belum diunggah</div>`;
                    }
                    
                    if (user.bukti_transfer) {
                        dokumenHtml += `<div class="list-group-item"><strong>Bukti Transfer:</strong> Ada <a href="/storage/dokumen/${user.bukti_transfer}" target="_blank" class="ms-2">Lihat</a></div>`;
                    } else {
                        dokumenHtml += `<div class="list-group-item"><strong>Bukti Transfer:</strong> Belum diunggah</div>`;
                    }
                    dokumenHtml += '</div>';
                    document.getElementById('dokumenContent').innerHTML = dokumenHtml;
                })
                .catch(err => {
                    console.error('Error loading user detail:', err);
                    document.getElementById('biodataContent').innerHTML = '<p class="text-danger">Gagal memuat data biodata: ' + err.message + '</p>';
                    document.getElementById('orangtuaContent').innerHTML = '<p class="text-danger">Gagal memuat data orang tua: ' + err.message + '</p>';
                    document.getElementById('dokumenContent').innerHTML = '<p class="text-danger">Gagal memuat data dokumen: ' + err.message + '</p>';
                });
        }

        // Search
        searchInput.addEventListener('input', (e) => {
            const q = e.target.value.trim().toLowerCase();
            const filtered = biodatas.filter(b => (b.nama_lengkap || '').toLowerCase().includes(q) || (b.nomor_pendaftaran || '').toLowerCase().includes(q));
            renderTable(filtered);
        });

        refreshBtn.addEventListener('click', fetchBiodata);

        // Submit seleksi
        document.getElementById('seleksiForm').addEventListener('submit', function(e){
            e.preventDefault();
            const form = e.target;
            const formData = new FormData(form);

            fetch(storeUrl, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: formData
            })
            .then(r => r.json())
            .then(resp => {
                if(resp && resp.message){
                    alert(resp.message);
                } else {
                    alert('Hasil seleksi tersimpan.');
                }
                var modalEl = document.getElementById('seleksiModal');
                var modal = bootstrap.Modal.getInstance(modalEl);
                modal.hide();
                fetchBiodata();
            })
            .catch(err => {
                console.error(err);
                alert('Gagal menyimpan hasil seleksi.');
            });
        });

        // initial load
        fetchBiodata();
    })();
</script>

@endsection

