@extends('layouts.dashboard')
@section('title', 'Isi Biodata')

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

        .foto-preview {
            margin-top: 15px;
            text-align: center;
        }

        .foto-preview img {
            max-width: 150px;
            border-radius: 10px;
            border: 2px solid var(--primary-light);
            padding: 4px;
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
            <h2>Isi Biodata</h2>
            <p class="text-muted mb-0">Lengkapi informasi pribadi Anda untuk proses PPDB.</p>
        </div>

        {{-- INFO BOX --}}
        <div class="info-box">
            <i class="ti ti-info-circle"></i>
            <strong>Penting:</strong> Pastikan semua data yang Anda isi sudah benar dan sesuai dengan dokumen resmi.
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

            <form action="{{ route('user.biodata.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                {{-- DATA PRIBADI --}}
                <h5 class="section-title">
                    <i class="ti ti-user-circle"></i> Data Pribadi
                </h5>

                <div class="row-group">
                    <div class="form-group">
                        <label class="form-label">Nama Lengkap</label>
                        <input type="text" name="nama" class="form-control @error('nama') is-invalid @enderror"
                            value="{{ old('nama', $user->nama ?? '') }}" placeholder="Masukkan nama lengkap">
                        @error('nama')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">NISN</label>
                        <input type="text" name="nisn" class="form-control @error('nisn') is-invalid @enderror"
                            value="{{ old('nisn', $user->nisn ?? '') }}" placeholder="10 digit NISN" inputmode="numeric" pattern="[0-9]*" maxlength="10" onInput="this.value = this.value.replace(/[^0-9]/g, '')">
                        @error('nisn')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row-group">
                    <div class="form-group">
                        <label class="form-label">Tempat Lahir</label>
                        <input type="text" name="tempat_lahir"
                            class="form-control @error('tempat_lahir') is-invalid @enderror"
                            value="{{ old('tempat_lahir', $user->tempat_lahir ?? '') }}" placeholder="Nama kota/kabupaten">
                        @error('tempat_lahir')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">Tanggal Lahir</label>
                        <input type="date" name="tanggal_lahir"
                            class="form-control @error('tanggal_lahir') is-invalid @enderror"
                            value="{{ old('tanggal_lahir', $user->tanggal_lahir ?? '') }}">
                        @error('tanggal_lahir')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row-group">
                    <div class="form-group">
                        <label class="form-label">Jenis Kelamin</label>
                        <select name="jenis_kelamin" class="form-select @error('jenis_kelamin') is-invalid @enderror">
                            <option value="">-- Pilih Jenis Kelamin --</option>
                            <option value="Laki-laki" {{ old('jenis_kelamin', $user->jenis_kelamin ?? '') === 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                            <option value="Perempuan" {{ old('jenis_kelamin', $user->jenis_kelamin ?? '') === 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                        </select>
                        @error('jenis_kelamin')
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

                {{-- ALAMAT --}}
                <h5 class="section-title">
                    <i class="ti ti-map-pin"></i> Alamat
                </h5>

                <div class="form-group">
                    <label class="form-label">Alamat Lengkap</label>
                    <textarea name="alamat" class="form-control @error('alamat') is-invalid @enderror"
                        placeholder="Jalan, Nomor, RT/RW, Kelurahan, Kecamatan"
                        rows="4">{{ old('alamat', $user->alamat ?? '') }}</textarea>
                    @error('alamat')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- FOTO DIRI --}}
                <h5 class="section-title">
                    <i class="ti ti-camera"></i> Foto Diri
                </h5>

                <div class="form-group">
                    <label class="form-label">Upload Foto Diri (Opsional)</label>
                    <div class="file-upload-wrapper">
                        <label class="file-upload-label" for="foto-input">
                            <div class="file-upload-text">
                                <i class="ti ti-cloud-upload"></i>
                                <span>Klik atau seret foto di sini</span>
                                <small style="display: block; color: #9ca3af;">JPG, JPEG, PNG (Max. 2 MB)</small>
                            </div>
                        </label>
                        <input type="file" id="foto-input" name="foto"
                            class="file-upload-input @error('foto') is-invalid @enderror" accept=".jpg,.jpeg,.png">
                    </div>
                    @error('foto')
                        <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
                    @enderror

                    @if($user->foto)
                        <div class="foto-preview">
                            <p class="text-muted small mb-2">Foto saat ini:</p>
                            <img src="{{ asset('storage/' . $user->foto) }}" alt="Foto profil">
                        </div>
                    @endif
                </div>

                {{-- TOMBOL SUBMIT --}}
                <div class="d-flex gap-3 mt-5">
                    <button type="submit" class="btn-submit">
                        <i class="ti ti-check"></i> Simpan Biodata
                    </button>
                    <a href="/dashboard" class="btn-secondary">
                        <i class="ti ti-arrow-left"></i> Kembali
                    </a>
                </div>

            </form>

        </div>

    </div>

    <script>
        // File name display and drag-drop
        const fotoInput = document.getElementById('foto-input');
        const fotoLabel = fotoInput.closest('.file-upload-wrapper').querySelector('.file-upload-label');

        fotoInput.addEventListener('change', function () {
            if (this.files[0]) {
                const reader = new FileReader();
                reader.onload = (e) => {
                    fotoLabel.innerHTML = `<div class="file-upload-text"><i class="ti ti-check-circle" style="color: #15803d;"></i><span>${this.files[0].name}</span></div>`;
                };
                reader.readAsDataURL(this.files[0]);
            }
        });

        // Drag and drop for foto
        ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
            fotoLabel.addEventListener(eventName, preventDefaults, false);
        });

        function preventDefaults(e) {
            e.preventDefault();
            e.stopPropagation();
        }

        ['dragenter', 'dragover'].forEach(eventName => {
            fotoLabel.addEventListener(eventName, () => {
                fotoLabel.style.borderColor = 'var(--primary)';
                fotoLabel.style.background = 'var(--primary-light)';
            });
        });

        ['dragleave', 'drop'].forEach(eventName => {
            fotoLabel.addEventListener(eventName, () => {
                fotoLabel.style.borderColor = '#ddd';
                fotoLabel.style.background = '#f9fafb';
            });
        });

        fotoLabel.addEventListener('drop', (e) => {
            const dt = e.dataTransfer;
            const files = dt.files;
            fotoInput.files = files;
            fotoInput.dispatchEvent(new Event('change'));
        });
    </script>

@endsection
