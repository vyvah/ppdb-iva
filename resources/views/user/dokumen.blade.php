@extends('layouts.dashboard')
@section('title', 'Upload Dokumen')

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

        .file-upload-wrapper {
            position: relative;
            overflow: hidden;
        }

        .file-upload-label {
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 120px;
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

        .file-name {
            font-weight: 600;
            color: var(--primary);
            display: block;
            margin-top: 8px;
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
            <h2>Upload Dokumen</h2>
            <p class="text-muted mb-0">Unggah dokumen pendaftaran Anda dengan format yang sesuai.</p>
        </div>

        {{-- INFO BOX --}}
        <div class="info-box">
            <i class="ti ti-info-circle"></i>
            <strong>Informasi:</strong> File yang diterima: JPG, JPEG, PNG, PDF. Ukuran maksimal: 2 MB per file.
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

            <form action="{{ route('user.dokumen.store') }}" method="POST" enctype="multipart/form-data" id="dokumenForm">
                @csrf

                {{-- INFORMASI DASAR --}}
                <h5 class="section-title">
                    <i class="ti ti-user"></i> Informasi Dasar
                </h5>

                <div class="row-group">
                    <div class="form-group">
                        <label class="form-label">Nama Lengkap</label>
                        <input type="text" name="nama" class="form-control @error('nama') is-invalid @enderror"
                            value="{{ old('nama', $user->name ?? '') }}" placeholder="Masukkan nama lengkap">
                        @error('nama')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">Nomor Telepon</label>
                        <input type="text" name="telepon" class="form-control @error('telepon') is-invalid @enderror"
                            value="{{ old('telepon', $user->telepon ?? '') }}" placeholder="08xxxxxxxxxx">
                        @error('telepon')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Jurusan</label>
                    <select name="jurusan" class="form-select @error('jurusan') is-invalid @enderror">
                        <option value="">-- Pilih Jurusan --</option>
                        <option value="TKR" {{ old('jurusan', $user->jurusan ?? '') === 'TKR' ? 'selected' : '' }}>Teknik
                            Kendaraan Ringan</option>
                        <option value="TPM" {{ old('jurusan', $user->jurusan ?? '') === 'TPM' ? 'selected' : '' }}>Teknik
                            Pemesinan</option>
                        <option value="RPL" {{ old('jurusan', $user->jurusan ?? '') === 'RPL' ? 'selected' : '' }}>Rekayasa
                            Perangkat Lunak</option>
                        <option value="TITL" {{ old('jurusan', $user->jurusan ?? '') === 'TITL' ? 'selected' : '' }}>Teknik
                            Instalasi Tenaga Listrik</option>
                        <option value="TEI" {{ old('jurusan', $user->jurusan ?? '') === 'TEI' ? 'selected' : '' }}>Teknik
                            Elektronika Industri</option>
                    </select>
                    @error('jurusan')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- UPLOAD DOKUMEN --}}
                <h5 class="section-title">
                    <i class="ti ti-file-upload"></i> Upload Dokumen
                </h5>

                <!-- KK -->
                <div class="form-group">
                    <label class="form-label">Kartu Keluarga (KK)</label>
                    <div class="file-upload-wrapper">
                        <label class="file-upload-label" for="kk-input">
                            <div class="file-upload-text">
                                <i class="ti ti-cloud-upload"></i>
                                <span>Klik atau seret file KK di sini</span>
                                <small style="display: block; color: #9ca3af;">JPG, JPEG, PNG, PDF (Max. 2 MB)</small>
                                <span class="file-name" id="kk-name"></span>
                            </div>
                        </label>
                        <input type="file" id="kk-input" name="kk"
                            class="file-upload-input @error('kk') is-invalid @enderror" accept=".jpg,.jpeg,.png,.pdf">
                    </div>
                    @error('kk')
                        <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
                    @enderror
                </div>

                <!-- AKTE -->
                <div class="form-group">
                    <label class="form-label">Akte Kelahiran</label>
                    <div class="file-upload-wrapper">
                        <label class="file-upload-label" for="akte-input">
                            <div class="file-upload-text">
                                <i class="ti ti-cloud-upload"></i>
                                <span>Klik atau seret file Akte Kelahiran di sini</span>
                                <small style="display: block; color: #9ca3af;">JPG, JPEG, PNG, PDF (Max. 2 MB)</small>
                                <span class="file-name" id="akte-name"></span>
                            </div>
                        </label>
                        <input type="file" id="akte-input" name="akte"
                            class="file-upload-input @error('akte') is-invalid @enderror" accept=".jpg,.jpeg,.png,.pdf">
                    </div>
                    @error('akte')
                        <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
                    @enderror
                </div>

                <!-- BUKTI TRANSFER -->
                <div class="form-group">
                    <label class="form-label">Bukti Transfer / Pembayaran</label>
                    <div class="file-upload-wrapper">
                        <label class="file-upload-label" for="bukti-input">
                            <div class="file-upload-text">
                                <i class="ti ti-cloud-upload"></i>
                                <span>Klik atau seret bukti transfer di sini</span>
                                <small style="display: block; color: #9ca3af;">JPG, JPEG, PNG, PDF (Max. 2 MB)</small>
                                <span class="file-name" id="bukti-name"></span>
                            </div>
                        </label>
                        <input type="file" id="bukti-input" name="bukti_transfer"
                            class="file-upload-input @error('bukti_transfer') is-invalid @enderror"
                            accept=".jpg,.jpeg,.png,.pdf">
                    </div>
                    @error('bukti_transfer')
                        <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
                    @enderror
                </div>

                {{-- TOMBOL SUBMIT --}}
                <div class="d-flex gap-3 mt-5">
                    <button type="submit" class="btn-submit">
                        <i class="ti ti-upload"></i> Upload Dokumen
                    </button>
                    <a href="/dashboard" class="btn-secondary">
                        <i class="ti ti-arrow-left"></i> Kembali
                    </a>
                </div>

            </form>

        </div>

    </div>

    <script>
        // File name display on select
        document.getElementById('kk-input').addEventListener('change', function () {
            document.getElementById('kk-name').textContent = this.files[0]?.name || '';
        });

        document.getElementById('akte-input').addEventListener('change', function () {
            document.getElementById('akte-name').textContent = this.files[0]?.name || '';
        });

        document.getElementById('bukti-input').addEventListener('change', function () {
            document.getElementById('bukti-name').textContent = this.files[0]?.name || '';
        });

        // Drag and drop
        const fileInputs = ['kk-input', 'akte-input', 'bukti-input'];
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
        });
    </script>

@endsection