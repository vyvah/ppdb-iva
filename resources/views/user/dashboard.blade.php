<div class="row justify-content-center">
    <div class="col-12">
        <div class="card shadow-lg border-0 rounded-4" style="backdrop-filter: blur(6px);">
            <div class="card-body text-center py-5">

                <!-- Welcome -->
                <h2 class="mb-3 fw-bold text-primary">
                    Selamat Datang, <span class="text-dark">{{ Auth::user()->name }}</span>!
                </h2>

                <!-- Verification Alert -->
                @if (!$user->is_verified)
                <div class="alert alert-warning d-flex align-items-center justify-content-between shadow-sm rounded-3 mt-4">
                    <div class="d-flex align-items-center">
                        <i class="ti ti-alert-triangle-filled fs-3 me-3"></i>
                        <div>
                            <strong>Email Anda belum terverifikasi.</strong>
                            Silakan lakukan verifikasi untuk mengakses semua fitur.
                        </div>
                    </div>

                    <a href="{{ route('verify.form') }}" id="verify-button"
                        class="btn btn-warning fw-bold btn-sm px-3 rounded-pill">
                        Verifikasi Sekarang
                    </a>
                </div>
                @endif

                <!-- Success Message -->
                @if (session('success'))
                <div class="alert alert-success shadow-sm rounded-3">
                    {{ session('success') }}
                </div>
                @endif

                <!-- Intro Text -->
                <p class="lead mt-3 text-secondary">
                    Ini adalah <span class="fw-bold text-success">Dashboard</span> untuk memantau progress dan status
                    <span class="text-info">PPDB</span> kamu.
                    Silakan gunakan menu di samping untuk mengakses fitur lainnya.
                </p>

                <!-- Feature Cards -->
                <div class="row mt-5 g-4">

                    <!-- Pendaftaran -->
                    <div class="col-md-4">
                        <div class="card h-100 border-0 shadow-sm feature-card hover-card rounded-4">
                            <div class="card-body text-center py-4">
                                <i class="ti ti-id-badge fs-1 text-info"></i>
                                <h5 class="mt-3 fw-semibold">Pendaftaran</h5>
                                <p class="text-muted mb-0">Lengkapi dan cek data pendaftaran kamu di sini.</p>
                            </div>
                        </div>
                    </div>

                    <!-- Progress -->
                    <div class="col-md-4">
                        <div class="card h-100 border-0 shadow-sm feature-card hover-card rounded-4">
                            <div class="card-body text-center py-4">
                                <i class="ti ti-chart-bar fs-1 text-success"></i>
                                <h5 class="mt-3 fw-semibold">Progress</h5>
                                <p class="text-muted mb-0">Pantau status dan perkembangan seleksi PPDB.</p>
                            </div>
                        </div>
                    </div>

                    <!-- Pengumuman -->
                    <div class="col-md-4">
                        <div class="card h-100 border-0 shadow-sm feature-card hover-card rounded-4">
                            <div class="card-body text-center py-4">
                                <i class="ti ti-megaphone fs-1 text-warning"></i>
                                <h5 class="mt-3 fw-semibold">Pengumuman</h5>
                                <p class="text-muted mb-0">Lihat pengumuman terbaru dari panitia PPDB.</p>
                            </div>
                        </div>
                    </div>

                </div>

                <!-- Profile Button -->
                <a href="/myprofile" class="btn btn-primary mt-5 px-4 py-2 rounded-pill shadow-sm">
                    Lihat Profil Saya
                </a>

            </div>
        </div>
    </div>
</div>

<!-- Button Loader -->
<script>
    const verifyButton = document.getElementById('verify-button');

    if (verifyButton) {
        verifyButton.addEventListener('click', function() {
            this.classList.add('disabled');
            this.innerHTML = `
                <span class="spinner-border spinner-border-sm"></span>
                Memproses...
            `;
        });
    }
</script>

<!-- Extra Modern Styling -->
<style>
    .hover-card {
        transition: .25s ease;
    }

    .hover-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 35px rgba(0, 0, 0, 0.12) !important;
    }
</style>
