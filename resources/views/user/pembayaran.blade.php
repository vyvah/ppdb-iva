@extends('layouts.dashboard')
@section('title', 'Pembayaran')

@section('content')

    <style>
        :root {
            --primary: #4f46e5;
            --bg-soft: #f9fafb;
            --text-dark: #111827;
            --text-muted: #6b7280;
            --radius: 16px;
        }

        .dashboard-container { padding: 15px; }

        /* HEADER */
        .header-modern {
            padding: 28px;
            border-radius: var(--radius);
            background: #ffffff;
            border: 1px solid #e5e7eb;
            margin-bottom: 25px;
        }

        .header-modern h2 { font-weight:700; color:var(--primary); }

        /* CARD */
        .card-modern {
            background: #ffffff;
            padding: 24px;
            border-radius: 14px;
            border: 1px solid #e5e7eb;
            transition: .2s ease;
        }

        .card-modern:hover { background: #fafafa; }

        .section-title { font-weight: 700; color: var(--text-dark); margin-bottom: 18px; }

        .form-group { margin-bottom: 18px; }

        .form-label { font-weight:600; color:var(--text-dark); display:block; margin-bottom:8px; }

        .file-upload-wrapper { position: relative; overflow: hidden; }
        .file-upload-label {
            display:flex; align-items:center; justify-content:center;
            min-height:120px; border:2px dashed #e5e7eb; border-radius:10px; cursor:pointer; background:var(--bg-soft);
        }
        .file-upload-label:hover { border-color: var(--primary); }
        .file-upload-input { display:none; }
        .file-upload-text { text-align:center; color:var(--text-muted); }
        .file-name { font-weight:600; color:var(--primary); display:block; margin-top:8px; }

        .btn-submit { background: var(--primary); color:white; border:none; padding:12px 26px; border-radius:10px; font-weight:600; }
        .btn-secondary { background:#f3f4f6; color:var(--text-dark); padding:12px 26px; border-radius:10px; text-decoration:none; display:inline-block; }

        .alert { border-radius:12px; padding:15px 20px; margin-bottom:20px; }
        .alert-success { background:#dcfce7; color:#15803d; border:1px solid #bbf7d0; }
        .alert-danger { background:#fee2e2; color:#b91c1c; border:1px solid #fecaca; }

        .invalid-feedback { color:#b91c1c; font-size:12px; margin-top:4px; display:block; }

        .info-box { background:var(--bg-soft); border-left:4px solid var(--primary); padding:12px 16px; border-radius:8px; }
        .info-box i { margin-right:8px; color:var(--primary); }
    </style>

    <div class="dashboard-container">

        <div class="header-modern">
            <h2 class="fw-bold">Pembayaran</h2>
            <p class="text-muted mb-0">Informasi pembayaran pendaftaran dan cara mengunggah bukti pembayaran.</p>
        </div>

        <div class="card-modern">

            <h5 class="section-title"><i class="ti ti-credit-card"></i> Instruksi Pembayaran</h5>

            <p>Silakan lakukan pembayaran biaya pendaftaran ke rekening berikut:</p>
            <ul>
                <li><strong>Bank:</strong> BCA</li>
                <li><strong>Nama Rekening:</strong> SMK Contoh</li>
                <li><strong>Nomor Rekening:</strong> 123-456-7890</li>
                <li><strong>Jumlah:</strong> Rp 100.000</li>
            </ul>

            <div class="info-box mb-3">
                <i class="ti ti-info-circle"></i>
                Setelah melakukan transfer, unggah <strong>bukti transfer</strong> menggunakan form di bawah.
            </div>

            @if(session('success'))
                <div class="alert alert-success"><i class="ti ti-check-circle"></i> <strong>Sukses!</strong> {{ session('success') }}</div>
            @endif

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

            <div class="section-title mt-3"><i class="ti ti-upload"></i> Unggah Bukti Pembayaran</div>

            <form action="{{ route('user.dokumen.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <input type="hidden" name="nama" value="{{ old('nama', auth()->user()->name ?? '') }}">
                <input type="hidden" name="telepon" value="{{ old('telepon', auth()->user()->telepon ?? '') }}">

                <div class="form-group">
                    <label class="form-label">Pilih File Bukti Transfer</label>
                    <div class="file-upload-wrapper">
                        <label class="file-upload-label" for="bukti-input">
                            <div class="file-upload-text">
                                <i class="ti ti-cloud-upload" style="font-size:28px;color:var(--primary)"></i>
                                <div>Klik atau seret bukti transfer di sini</div>
                                <small style="display:block;color:#9ca3af">JPG, JPEG, PNG, PDF (Max. 2 MB)</small>
                                <span class="file-name" id="bukti-name">{{ old('bukti_transfer', auth()->user()->bukti_transfer ?? '') }}</span>
                            </div>
                        </label>
                        <input type="file" id="bukti-input" name="bukti_transfer" class="file-upload-input @error('bukti_transfer') is-invalid @enderror" accept=".jpg,.jpeg,.png,.pdf">
                    </div>
                    @error('bukti_transfer')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex gap-3 mt-3">
                    <button type="submit" class="btn-submit"><i class="ti ti-upload"></i> Unggah Bukti</button>
                    <a href="/dashboard" class="btn-secondary"><i class="ti ti-arrow-left"></i> Kembali</a>
                </div>
            </form>

        </div>

    </div>

    <script>
        const buktiInput = document.getElementById('bukti-input');
        if (buktiInput) {
            buktiInput.addEventListener('change', function () {
                document.getElementById('bukti-name').textContent = this.files[0]?.name || '';
            });
        }
    </script>

@endsection

