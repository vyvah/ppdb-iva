@extends('layouts.dashboard')
@section('title', 'Daftar Ulang')

@section('content')
<div class="pc-content">

    <div class="container py-4">

        <h2 class="fw-bold mb-4">Daftar Ulang</h2>

        <!-- Card Wrapper -->
        <div class="card shadow-sm border-0 rounded-4 p-4">

            <h5 class="fw-semibold mb-3">Formulir Daftar Ulang</h5>
            <p class="text-muted mb-4">Silakan lengkapi data berikut dengan benar untuk proses daftar ulang.</p>

            <form action="{{ route('user.daftar_ulang') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="row g-3">

                    <!-- NIK -->
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">NIK</label>
                        <input type="text" name="nik" class="form-control py-2 rounded-3" required>
                    </div>

                    <!-- Upload KK -->
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Upload Kartu Keluarga</label>
                        <input type="file" name="kk" class="form-control py-2 rounded-3" required>
                    </div>

                    <!-- Upload Surat Pernyataan -->
                    <div class="col-md-12">
                        <label class="form-label fw-semibold">Upload Surat Pernyataan Orang Tua</label>
                        <input type="file" name="surat_pernyataan" class="form-control py-2 rounded-3" required>
                    </div>

                    <hr class="my-4">

                    <h5 class="fw-semibold">Identitas Orang Tua / Wali</h5>

                    <!-- Nama Ayah -->
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Nama Ayah</label>
                        <input type="text" name="nama_ayah" class="form-control py-2 rounded-3" required>
                    </div>

                    <!-- Pekerjaan Ayah -->
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Pekerjaan Ayah</label>
                        <input type="text" name="pekerjaan_ayah" class="form-control py-2 rounded-3" required>
                    </div>

                    <!-- Nama Ibu -->
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Nama Ibu</label>
                        <input type="text" name="nama_ibu" class="form-control py-2 rounded-3" required>
                    </div>

                    <!-- Pekerjaan Ibu -->
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Pekerjaan Ibu</label>
                        <input type="text" name="pekerjaan_ibu" class="form-control py-2 rounded-3" required>
                    </div>

                    <!-- Alamat -->
                    <div class="col-md-12">
                        <label class="form-label fw-semibold">Alamat Orang Tua / Wali</label>
                        <textarea name="alamat_ortu" rows="3" class="form-control rounded-3" required></textarea>
                    </div>

                </div>

                <!-- Submit Button -->
                <div class="mt-4">
                    <button class="btn btn-primary px-4 py-2 rounded-3 fw-semibold">
                        Simpan Form Daftar Ulang
                    </button>
                </div>

            </form>
        </div>
    </div>

</div>

<style>
    .card {
        background: #ffffff;
        border-radius: 16px;
    }

    .form-control {
        border: 1.5px solid #e1e1e1;
    }

    .form-control:focus {
        border-color: #4C83FF;
        box-shadow: 0 0 0 0.15rem rgba(76, 131, 255, 0.25);
    }

    button.btn-primary {
        background: #4C83FF;
        border: none;
    }

    button.btn-primary:hover {
        background: #3A6DE0;
    }
</style>
@endsection
