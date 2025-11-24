@extends('layouts.dashboard')
@section('title', 'Biodata')

@section('content')
<div class="pc-content">

    <!-- Header -->
    <div class="page-header d-flex justify-content-between align-items-center">
        <div>
            <h3 class="fw-bold">Biodata</h3>
            <p class="text-muted mb-0">Lengkapi informasi pribadi kamu untuk proses PPDB.</p>
        </div>
    </div>

    <!-- Biodata Form Card -->
    <div class="card shadow-lg border-0 rounded-4 mt-4">
        <div class="card-body px-4 py-5">

            <!-- Success Message -->
            @if (session('success'))
                <div class="alert alert-success rounded-3 shadow-sm">
                    {{ session('success') }}
                </div>
            @endif

            <form action="{{ route('user.biodata') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="row g-4">

                    <!-- Nama Lengkap -->
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Nama Lengkap</label>
                        <input type="text"
                               name="nama"
                               value="{{ old('nama', $user->nama) }}"
                               class="form-control form-control-lg rounded-3 shadow-sm"
                               required>
                    </div>

                    <!-- NISN -->
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">NISN</label>
                        <input type="text"
                               name="nisn"
                               value="{{ old('nisn', $user->nisn) }}"
                               class="form-control form-control-lg rounded-3 shadow-sm"
                               required>
                    </div>

                    <!-- Tempat Lahir -->
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Tempat Lahir</label>
                        <input type="text"
                               name="tempat_lahir"
                               value="{{ old('tempat_lahir', $user->tempat_lahir) }}"
                               class="form-control form-control-lg rounded-3 shadow-sm"
                               required>
                    </div>

                    <!-- Tanggal Lahir -->
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Tanggal Lahir</label>
                        <input type="date"
                               name="tanggal_lahir"
                               value="{{ old('tanggal_lahir', $user->tanggal_lahir) }}"
                               class="form-control form-control-lg rounded-3 shadow-sm"
                               required>
                    </div>

                    <!-- Jenis Kelamin -->
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Jenis Kelamin</label>
                        <select name="jenis_kelamin"
                                class="form-select form-select-lg rounded-3 shadow-sm"
                                required>
                            <option value="">-- Pilih --</option>
                            <option value="Laki-laki" {{ $user->jenis_kelamin == 'Laki-laki' ? 'selected' : '' }}>
                                Laki-laki
                            </option>
                            <option value="Perempuan" {{ $user->jenis_kelamin == 'Perempuan' ? 'selected' : '' }}>
                                Perempuan
                            </option>
                        </select>
                    </div>

                    <!-- Nomor HP -->
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Nomor HP</label>
                        <input type="text"
                               name="telepon"
                               value="{{ old('telepon', $user->telepon) }}"
                               class="form-control form-control-lg rounded-3 shadow-sm"
                               required>
                    </div>

                    <!-- Alamat -->
                    <div class="col-12">
                        <label class="form-label fw-semibold">Alamat Lengkap</label>
                        <textarea class="form-control form-control-lg rounded-3 shadow-sm"
                                  name="alamat"
                                  rows="3"
                                  required>{{ old('alamat', $user->alamat) }}</textarea>
                    </div>

                    <!-- Upload Foto -->
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Foto Diri</label>
                        <input type="file"
                               name="foto"
                               class="form-control form-control-lg rounded-3 shadow-sm">
                        @if ($user->foto)
                            <img src="{{ asset('uploads/foto/' . $user->foto) }}"
                                 class="img-thumbnail mt-2 rounded"
                                 width="120">
                        @endif
                    </div>

                </div>

                <!-- Buttons -->
                <div class="d-flex justify-content-end mt-4">
                    <button type="submit"
                            class="btn btn-primary px-4 py-2 rounded-pill fw-semibold shadow-sm">
                        Simpan Biodata
                    </button>
                </div>

            </form>

        </div>
    </div>
</div>

<style>
    .form-control-lg, .form-select-lg {
        padding: 12px 16px;
    }

    .form-label {
        font-size: 0.95rem;
        color: #4a4a4a;
    }
</style>
@endsection
