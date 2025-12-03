@extends('layouts.dashboard')
@section('title', 'Data Orang Tua')

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

        .form-control {
            border-radius: 10px;
            border: 1px solid #ddd;
            padding: 10px 15px;
            font-size: 14px;
            transition: .2s ease;
        }

        .form-control:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1);
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

        .invalid-feedback {
            color: #b91c1c;
            font-size: 12px;
            margin-top: 4px;
            display: block;
        }
    </style>

    <div class="container-modern">

        {{-- HEADER --}}
        <div class="header-modern">
            <h2>Data Orang Tua</h2>
            <p class="text-muted mb-0">Lengkapi informasi orang tua/wali Anda.</p>
        </div>

        {{-- ALERT SUCCESS --}}
        @if(session('success'))
            <div class="alert alert-success">
                <strong>Sukses!</strong> {{ session('success') }}
            </div>
        @endif

        {{-- ALERT ERROR --}}
        @if ($errors->any())
            <div class="alert alert-danger">
                <strong>Periksa kembali data Anda!</strong>
                <ul class="mb-0 mt-2">
                    @foreach ($errors->all() as $err)
                        <li>{{ $err }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- FORM --}}
        <div class="card-modern">

            <form action="{{ route('user.orangtua.store') }}" method="POST">
                @csrf

                {{-- DATA AYAH --}}
                <h5 class="section-title">
                    <i class="ti ti-user-circle"></i> Data Ayah/Wali
                </h5>

                <div class="row-group">
                    <div class="form-group">
                        <label class="form-label">Nama Ayah</label>
                        <input type="text" name="nama_ayah" class="form-control @error('nama_ayah') is-invalid @enderror"
                            value="{{ old('nama_ayah', $user->nama_ayah ?? '') }}" placeholder="Masukkan nama ayah">
                        @error('nama_ayah')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">NIK Ayah</label>
                        <input type="text" inputmode="numeric" pattern="[0-9]*" maxlength="16" name="nik_ayah" class="form-control @error('nik_ayah') is-invalid @enderror"
                            value="{{ old('nik_ayah', $user->nik_ayah ?? '') }}" placeholder="16 digit NIK">
                        @error('nik_ayah')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row-group">
                    <div class="form-group">
                        <label class="form-label">Pekerjaan Ayah</label>
                        <input type="text" name="pekerjaan_ayah"
                            class="form-control @error('pekerjaan_ayah') is-invalid @enderror"
                            value="{{ old('pekerjaan_ayah', $user->pekerjaan_ayah ?? '') }}" placeholder="Pekerjaan ayah">
                        @error('pekerjaan_ayah')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">Telepon Ayah</label>
                        <input type="text" inputmode="numeric" pattern="[0-9]*" maxlength="20" name="telepon_ayah"
                            class="form-control @error('telepon_ayah') is-invalid @enderror"
                            value="{{ old('telepon_ayah', $user->telepon_ayah ?? '') }}" placeholder="08xxxxxxxxxx">
                        @error('telepon_ayah')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                {{-- DATA IBU --}}
                <h5 class="section-title">
                    <i class="ti ti-user-circle"></i> Data Ibu
                </h5>

                <div class="row-group">
                    <div class="form-group">
                        <label class="form-label">Nama Ibu</label>
                        <input type="text" name="nama_ibu" class="form-control @error('nama_ibu') is-invalid @enderror"
                            value="{{ old('nama_ibu', $user->nama_ibu ?? '') }}" placeholder="Masukkan nama ibu">
                        @error('nama_ibu')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">NIK Ibu</label>
                        <input type="text" inputmode="numeric" pattern="[0-9]*" maxlength="16" name="nik_ibu" class="form-control @error('nik_ibu') is-invalid @enderror"
                            value="{{ old('nik_ibu', $user->nik_ibu ?? '') }}" placeholder="16 digit NIK">
                        @error('nik_ibu')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row-group">
                    <div class="form-group">
                        <label class="form-label">Pekerjaan Ibu</label>
                        <input type="text" name="pekerjaan_ibu"
                            class="form-control @error('pekerjaan_ibu') is-invalid @enderror"
                            value="{{ old('pekerjaan_ibu', $user->pekerjaan_ibu ?? '') }}" placeholder="Pekerjaan ibu">
                        @error('pekerjaan_ibu')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">Telepon Ibu</label>
                        <input type="text" inputmode="numeric" pattern="[0-9]*" maxlength="20" name="telepon_ibu"
                            class="form-control @error('telepon_ibu') is-invalid @enderror"
                            value="{{ old('telepon_ibu', $user->telepon_ibu ?? '') }}" placeholder="08xxxxxxxxxx">
                        @error('telepon_ibu')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                {{-- ALAMAT ORANG TUA --}}
                <h5 class="section-title">
                    <i class="ti ti-map-pin"></i> Alamat Orang Tua
                </h5>

                <div class="form-group">
                    <label class="form-label">Alamat Lengkap</label>
                    <textarea name="alamat_ortu" class="form-control @error('alamat_ortu') is-invalid @enderror"
                        placeholder="Jalan, Nomor, RT/RW"
                        rows="3">{{ old('alamat_ortu', $user->alamat_ortu ?? '') }}</textarea>
                    @error('alamat_ortu')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="row-group">
                    <div class="form-group">
                        <label class="form-label">RT</label>
                        <input type="text" inputmode="numeric" pattern="[0-9]*" maxlength="3" name="rt" class="form-control" value="{{ old('rt', $user->rt_ortu ?? '') }}"
                            placeholder="01">
                    </div>

                    <div class="form-group">
                        <label class="form-label">RW</label>
                        <input type="text" inputmode="numeric" pattern="[0-9]*" maxlength="3" name="rw" class="form-control" value="{{ old('rw', $user->rw_ortu ?? '') }}"
                            placeholder="01">
                    </div>

                    <div class="form-group">
                        <label class="form-label">Kelurahan</label>
                        <input type="text" name="kelurahan" class="form-control"
                            value="{{ old('kelurahan', $user->kelurahan_ortu ?? '') }}" placeholder="Kelurahan">
                    </div>
                </div>

                <div class="row-group">
                    <div class="form-group">
                        <label class="form-label">Kecamatan</label>
                        <input type="text" name="kecamatan" class="form-control"
                            value="{{ old('kecamatan', $user->kecamatan_ortu ?? '') }}" placeholder="Kecamatan">
                    </div>

                    <div class="form-group">
                        <label class="form-label">Kabupaten/Kota</label>
                        <input type="text" name="kabupaten" class="form-control"
                            value="{{ old('kabupaten', $user->kabupaten_ortu ?? '') }}" placeholder="Kabupaten/Kota">
                    </div>

                    <div class="form-group">
                        <label class="form-label">Provinsi</label>
                        <input type="text" name="provinsi" class="form-control"
                            value="{{ old('provinsi', $user->provinsi_ortu ?? '') }}" placeholder="Provinsi">
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Kode Pos</label>
                    <input type="text" inputmode="numeric" pattern="[0-9]*" name="kode_pos" class="form-control"
                        value="{{ old('kode_pos', $user->kode_pos_ortu ?? '') }}" placeholder="60000" maxlength="5">
                </div>

                {{-- TOMBOL SUBMIT --}}
                <div class="d-flex gap-3 mt-4">
                    <button type="submit" class="btn-submit">
                        <i class="ti ti-check"></i> Simpan Data
                    </button>
                    <a href="/dashboard" class="btn"
                        style="padding: 12px 30px; border-radius: 10px; background: #f3f4f6; color: #111827; text-decoration: none; font-weight: 600;">
                        <i class="ti ti-arrow-left"></i> Kembali
                    </a>
                </div>

            </form>

        </div>

    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            function enforceDigits(el, max) {
                if (!el) return;
                el.addEventListener('input', function () {
                    let v = this.value.replace(/\D+/g, '');
                    if (max) v = v.slice(0, max);
                    if (this.value !== v) this.value = v;
                });
                el.addEventListener('keypress', function (e) {
                    const ch = String.fromCharCode(e.which || e.keyCode);
                    if (!/\d/.test(ch)) e.preventDefault();
                });
            }

            enforceDigits(document.querySelector('input[name="nik_ayah"]'), 16);
            enforceDigits(document.querySelector('input[name="nik_ibu"]'), 16);
            enforceDigits(document.querySelector('input[name="telepon_ayah"]'), 20);
            enforceDigits(document.querySelector('input[name="telepon_ibu"]'), 20);
            enforceDigits(document.querySelector('input[name="rt"]'), 3);
            enforceDigits(document.querySelector('input[name="rw"]'), 3);
        });
    </script>
@endsection