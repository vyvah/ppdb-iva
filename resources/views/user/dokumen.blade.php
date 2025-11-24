@extends('layouts.dashboard')
@section('title', 'Upload Dokumen')

@section('content')
<div class="pc-content">

    <div class="row justify-content-center">
        <div class="col-md-7">

            <div class="card shadow-sm border-0 rounded-3">
                <div class="card-header bg-primary text-white py-3">
                    <h5 class="mb-0"><i class="bi bi-cloud-upload"></i> Upload Dokumen</h5>
                </div>

                <div class="card-body">

                    {{-- Alert jika berhasil --}}
                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    {{-- Alert jika error --}}
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <strong>Periksa kembali data anda!</strong>
                            <ul class="mb-0 mt-2">
                                @foreach ($errors->all() as $err)
                                    <li>{{ $err }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('user.dokumen') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <!-- Nama -->
                        <div class="mb-3">
                            <label class="form-label fw-bold">Nama Lengkap</label>
                            <input type="text" class="form-control" name="nama" placeholder="Masukkan nama lengkap">
                        </div>

                        <!-- Nomor Telepon -->
                        <div class="mb-3">
                            <label class="form-label fw-bold">Nomor Telepon</label>
                            <input type="text" class="form-control" name="telepon" placeholder="08xxxxxxxxxx">
                        </div>

                        <!-- Jurusan -->
                        <div class="mb-3">
                            <label class="form-label fw-bold">Jurusan</label>
                            <select name="jurusan" class="form-select">
                                <option value="">-- Pilih Jurusan --</option>
                                <option value="RPL">Rekayasa Perangkat Lunak</option>
                                <option value="TKJ">Teknik Komputer & Jaringan</option>
                                <option value="AKL">Akuntansi</option>
                            </select>
                        </div>

                        <hr>

                        <!-- Upload dokumen -->
                        <div class="mb-3">
                            <label class="form-label fw-bold">Upload KK (Kartu Keluarga)</label>
                            <input type="file" class="form-control" name="kk">
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Upload Akte Kelahiran</label>
                            <input type="file" class="form-control" name="akte">
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Bukti Transfer / Pembayaran</label>
                            <input type="file" class="form-control" name="bukti_transfer">
                        </div>

                        <hr>

                        <!-- Tombol -->
                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary px-4">
                                <i class="bi bi-check-circle"></i> Upload Dokumen
                            </button>
                        </div>

                    </form>

                </div>
            </div>

        </div>
    </div>

</div>
@endsection
