@extends('layouts.dashboard')
@section('title', 'Seleksi Admin')

@section('content')

<div class="container-modern" style="padding:20px">

    <div class="header-modern" style="padding:20px;margin-bottom:20px">
        <h2>Seleksi Peserta (Admin)</h2>
        <p class="text-muted mb-0">Gunakan halaman ini untuk menetapkan hasil seleksi peserta.</p>
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
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td colspan="4">Memuat data...</td></tr>
                </tbody>
            </table>
        </div>

    </div>

</div>

<!-- Modal Seleksi -->
<div class="modal fade" id="seleksiModal" tabindex="-1" aria-labelledby="seleksiModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="seleksiForm">
                @csrf
                <input type="hidden" name="biodata_id" id="biodata_id">
                <div class="modal-header">
                    <h5 class="modal-title" id="seleksiModalLabel">Set Hasil Seleksi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Nama</label>
                        <div id="modalNama" class="fw-bold"></div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Nomor Pendaftaran</label>
                        <div id="modalNomor" class="fw-bold"></div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Hasil</label>
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
                    <button type="submit" class="btn btn-primary">Simpan Hasil</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    (function(){
        const biodataUrl = '{{ url('/admin/biodata-list') }}';
        const storeUrl = '{{ route('admin.pengumuman.store') }}';

        const tableBody = document.querySelector('#biodataTable tbody');
        const searchInput = document.getElementById('search');
        const refreshBtn = document.getElementById('refreshBtn');

        let biodatas = [];

        function fetchBiodata(){
            tableBody.innerHTML = '<tr><td colspan="4">Memuat data...</td></tr>';
            fetch(biodataUrl, {headers: {'X-Requested-With':'XMLHttpRequest'}})
                .then(r => r.json())
                .then(data => {
                    biodatas = data;
                    renderTable(data);
                })
                .catch(err => {
                    tableBody.innerHTML = '<tr><td colspan="4" class="text-danger">Gagal memuat data.</td></tr>';
                    console.error(err);
                });
        }

        function renderTable(list){
            if(!list || list.length === 0){
                tableBody.innerHTML = '<tr><td colspan="4">Tidak ada data.</td></tr>';
                return;
            }

            const rows = list.map((b, idx) => {
                return `
                    <tr>
                        <td>${idx + 1}</td>
                        <td>${b.nomor_pendaftaran}</td>
                        <td>${b.nama_lengkap}</td>
                        <td>
                            <button class="btn btn-sm btn-primary btn-seleksi" data-id="${b.id}" data-nomor="${b.nomor_pendaftaran}" data-nama="${b.nama_lengkap}">Seleksi</button>
                        </td>
                    </tr>
                `;
            }).join('');

            tableBody.innerHTML = rows;

            document.querySelectorAll('.btn-seleksi').forEach(btn => {
                btn.addEventListener('click', (e) => {
                    const id = btn.dataset.id;
                    const nama = btn.dataset.nama;
                    const nomor = btn.dataset.nomor;
                    openModal(id, nama, nomor);
                });
            });
        }

        function openModal(id, nama, nomor){
            document.getElementById('biodata_id').value = id;
            document.getElementById('modalNama').textContent = nama;
            document.getElementById('modalNomor').textContent = nomor;
            document.getElementById('nilai_akhir').value = '';
            document.getElementById('pesan_pengumuman').value = '';
            document.querySelectorAll('#seleksiForm input[name="status_hasil"]').forEach(i => i.checked = false);
            var modal = new bootstrap.Modal(document.getElementById('seleksiModal'));
            modal.show();
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
