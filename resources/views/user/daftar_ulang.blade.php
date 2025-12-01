@extends('layouts.dashboard')
@section('title', 'Daftar Ulang')

@section('content')

    <style>
        :root {
            --primary: #4f46e5;
            --primary-light: #eef2ff;
            --text-dark: #111827;
            --text-muted: #6b7280;
            --card-bg: #fff;
            --radius: 16px;
            --shadow: 0 4px 18px rgba(0, 0, 0, 0.06);
            --shadow-hover: 0 8px 30px rgba(0, 0, 0, 0.12);
        }

        .container-modern {
            padding: 15px;
        }

        .card-modern {
            background: var(--card-bg);
            border-radius: var(--radius);
            padding: 26px;
            border: 1px solid #ececec;
            box-shadow: var(--shadow);
        }

        .header-modern {
            padding: 35px;
            border-radius: var(--radius);
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(10px);
            border: 1px solid #ececec;
            margin-bottom: 30px;
            box-shadow: var(--shadow);
        }

        .header-modern h2 {
            font-weight: 700;
            color: var(--primary);
            margin: 0;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-label {
            font-weight: 600;
            color: var(--text-dark);
            margin-bottom: 8px;
            display: block;
            font-size: 14px;
        }

        .form-control,
        .form-select {
            border-radius: 10px;
            border: 1px solid #ddd;
            padding: 10px 15px;
            font-size: 14px;
            transition: .2s ease;
            width: 100%;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1);
            outline: none;
        }

        textarea.form-control {
            resize: vertical;
            min-height: 100px;
        }

        .row-group {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
        }

        .section-title {
            font-weight: 700;
            color: var(--text-dark);
            margin-bottom: 20px;
            margin-top: 30px;
            padding-bottom: 15px;
            border-bottom: 2px solid var(--primary-light);
        }

        .btn-submit {
            background: var(--primary);
            color: white;
            border: none;
            padding: 12px 30px;
            border-radius: 10px;
            font-weight: 600;
            cursor: pointer;
            transition: .2s ease;
        }

        .btn-submit:hover {
            background: #4338ca;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(79, 70, 229, 0.3);
        }

        .btn-secondary {
            background: #f3f4f6;
            color: var(--text-dark);
            border: none;
            padding: 12px 30px;
            border-radius: 10px;
            font-weight: 600;
            cursor: pointer;
            transition: .2s ease;
            text-decoration: none;
        }

        .btn-secondary:hover {
            background: #e5e7eb;
        }

        .alert {
            border-radius: 12px;
            padding: 15px 20px;
            margin-bottom: 20px;
        }

        .alert-success {
            background: #dcfce7;
            color: #15803d;
            border: 1px solid #bbf7d0;
        }

        .alert-danger {
            background: #fee2e2;
            color: #b91c1c;
            border: 1px solid #fecaca;
        }

        .alert ul {
            margin-bottom: 0;
            margin-top: 10px;
            padding-left: 20px;
        }

        .alert li {
            margin-bottom: 5px;
        }

        .invalid-feedback {
            color: #b91c1c;
            font-size: 12px;
            margin-top: 4px;
            display: block;
        }

        .is-invalid {
            border-color: #fca5a5 !important;
        }

        .file-upload-wrapper {
            position: relative;
            overflow: hidden;
        }

        .file-upload-label {
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100px;
            border: 2px dashed #ddd;
            border-radius: 10px;
            cursor: pointer;
            transition: all .3s ease;
            background: #f9fafb;
        }

        .file-upload-label:hover {
            border-color: var(--primary);
            background: var(--primary-light);
        }

        .file-upload-input {
            display: none;
        }

        .file-upload-text {
            text-align: center;
            color: var(--text-muted);
        }

        .file-upload-text i {
            font-size: 32px;
            color: var(--primary);
            display: block;
            margin-bottom: 8px;
        }

        .info-box {
            background: var(--primary-light);
            border-left: 4px solid var(--primary);
            padding: 15px 20px;
            border-radius: 8px;
            margin-bottom: 20px;
            color: var(--text-dark);
            font-size: 14px;
        }

        .info-box i {
            margin-right: 10px;
            color: var(--primary);
        }
    </style>

    <div class="container-modern">

        {{-- HEADER --}}
        <div class="header-modern">
            <h2>Daftar Ulang</h2>
            <p class="text-muted mb-0">Lengkapi formulir daftar ulang untuk menyelesaikan proses pendaftaran.</p>
        </div>

        {{-- INFO BOX --}}
        <div class="info-box">
            <i class="ti ti-info-circle"></i>
            <strong>Penting:</strong> Pastikan semua data dan dokumen yang Anda upload sudah benar dan sesuai.
        </div>

        {{-- ALERT SUCCESS --}}
        @if(session('success'))
            <div class="alert alert-success">
                <i class="ti ti-check-circle"></i> <strong>Sukses!</strong> {{ session('success') }}
            </div>
        @endif

        {{-- ALERT ERROR --}}
        @if ($errors->any())
            <div class="alert alert-danger">
                <strong>Periksa kembali data Anda!</strong>
                <ul class="mb-0">
                    @foreach ($errors->all() as $err)
                        <li>{{ $err }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- FORM --}}
        <div class="card-modern">

            <form action="{{ route('user.daftar_ulang.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                {{-- DOKUMEN PENDAFTARAN --}}
                <h5 class="section-title">
                    <i class="ti ti-file-upload"></i> Dokumen Pendaftaran
                </h5>

                <div class="form-group">
                    <label class="form-label">NIK (Nomor Induk Kependudukan)</label>
                    <input type="text" name="nik" class="form-control @error('nik') is-invalid @enderror"
                        value="{{ old('nik') }}" placeholder="16 digit NIK">
                    @error('nik')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="row-group">
                    <div class="form-group">
                        <label class="form-label">Upload Kartu Keluarga (KK)</label>
                        <div class="file-upload-wrapper">
                            <label class="file-upload-label" for="kk-input">
                                <div class="file-upload-text">
                                    <i class="ti ti-cloud-upload"></i>
                                    <span>Klik atau seret file KK di sini</span>
                                    <small style="display: block; color: #9ca3af;">JPG, JPEG, PNG, PDF (Max. 2 MB)</small>
                                </div>
                            </label>
                            <input type="file" id="kk-input" name="kk"
                                class="file-upload-input @error('kk') is-invalid @enderror" accept=".jpg,.jpeg,.png,.pdf">
                        </div>
                        @error('kk')
                            <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">Upload Surat Pernyataan Orang Tua</label>
                        <div class="file-upload-wrapper">
                            <label class="file-upload-label" for="surat-input">
                                <div class="file-upload-text">
                                    <i class="ti ti-cloud-upload"></i>
                                    <span>Klik atau seret surat pernyataan di sini</span>
                                    <small style="display: block; color: #9ca3af;">JPG, JPEG, PNG, PDF (Max. 2 MB)</small>
                                </div>
                            </label>
                            <input type="file" id="surat-input" name="surat_pernyataan"
                                class="file-upload-input @error('surat_pernyataan') is-invalid @enderror"
                                accept=".jpg,.jpeg,.png,.pdf">
                        </div>
                        @error('surat_pernyataan')
                            <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                {{-- DATA ORANG TUA / WALI --}}
                <h5 class="section-title">
                    <i class="ti ti-users"></i> Data Orang Tua / Wali
                </h5>

                <div class="row-group">
                    <div class="form-group">
                        <label class="form-label">Nama Ayah</label>
                        <input type="text" name="nama_ayah" class="form-control @error('nama_ayah') is-invalid @enderror"
                            value="{{ old('nama_ayah') }}" placeholder="Masukkan nama ayah">
                        @error('nama_ayah')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">Pekerjaan Ayah</label>
                        <input type="text" name="pekerjaan_ayah"
                            class="form-control @error('pekerjaan_ayah') is-invalid @enderror"
                            value="{{ old('pekerjaan_ayah') }}" placeholder="Pekerjaan ayah">
                        @error('pekerjaan_ayah')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row-group">
                    <div class="form-group">
                        <label class="form-label">Nama Ibu</label>
                        <input type="text" name="nama_ibu" class="form-control @error('nama_ibu') is-invalid @enderror"
                            value="{{ old('nama_ibu') }}" placeholder="Masukkan nama ibu">
                        @error('nama_ibu')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">Pekerjaan Ibu</label>
                        <input type="text" name="pekerjaan_ibu"
                            class="form-control @error('pekerjaan_ibu') is-invalid @enderror"
                            value="{{ old('pekerjaan_ibu') }}" placeholder="Pekerjaan ibu">
                        @error('pekerjaan_ibu')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Alamat Orang Tua / Wali</label>
                    <textarea name="alamat_ortu" class="form-control @error('alamat_ortu') is-invalid @enderror"
                        placeholder="Jalan, Nomor, RT/RW, Kelurahan, Kecamatan" rows="4">{{ old('alamat_ortu') }}</textarea>
                    @error('alamat_ortu')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- TOMBOL SUBMIT --}}
                <div class="d-flex gap-3 mt-5">
                    <button type="submit" class="btn-submit">
                        <i class="ti ti-check"></i> Simpan Daftar Ulang
                    </button>
                    <a href="/dashboard" class="btn-secondary">
                        <i class="ti ti-arrow-left"></i> Kembali
                    </a>
                </div>

            </form>

        </div>

    </div>

    <script>
        // Drag and drop for file uploads
        const fileInputs = ['kk-input', 'surat-input'];
        fileInputs.forEach(inputId => {
            const input = document.getElementById(inputId);
            const label = input.closest('.file-upload-wrapper').querySelector('.file-upload-label');

            ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
                label.addEventListener(eventName, preventDefaults, false);
            });

            function preventDefaults(e) {
                e.preventDefault();
                e.stopPropagation();
            }

            ['dragenter', 'dragover'].forEach(eventName => {
                label.addEventListener(eventName, () => {
                    label.style.borderColor = 'var(--primary)';
                    label.style.background = 'var(--primary-light)';
                });
            });

            ['dragleave', 'drop'].forEach(eventName => {
                label.addEventListener(eventName, () => {
                    label.style.borderColor = '#ddd';
                    label.style.background = '#f9fafb';
                });
            });

            label.addEventListener('drop', (e) => {
                const dt = e.dataTransfer;
                const files = dt.files;
                input.files = files;
                input.dispatchEvent(new Event('change'));
            });

            // Show file name on select
            input.addEventListener('change', function () {
                if (this.files[0]) {
                    const fileName = this.files[0].name;
                    label.innerHTML = `<div class="file-upload-text"><i class="ti ti-check-circle" style="color: #15803d;"></i><span>${fileName}</span></div>`;
                }
            });
        });
    </script>

@endsection
