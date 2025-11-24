<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <title>@yield('title') - Aplikasi PPDB SMK</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Icons -->
    <link rel="stylesheet" href="{{ asset('assets/fonts/tabler-icons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/fonts/feather.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/fonts/fontawesome.css') }}">

    <!-- Core CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style-preset.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/landing.css') }}">

    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f8fafc;
        }

        .navbar-modern {
            backdrop-filter: blur(12px);
            background: rgba(0, 0, 0, 0.35) !important;
            transition: all .3s ease;
        }

        .navbar-modern.scrolled {
            background: #1e293b !important;
            box-shadow: 0 4px 20px rgba(0, 0, 0, .2);
        }

        footer {
            background: #0f172a;
        }

        footer a {
            color: #cbd5e1;
            transition: 0.2s;
        }

        footer a:hover {
            color: #fff;
        }
    </style>
</head>
<body>

    <!-- NAVBAR -->
    <nav class="navbar navbar-expand-lg navbar-dark fixed-top navbar-modern py-3" id="mainNav">
        <div class="container">
            <a class="navbar-brand fw-bold" href="/">
                <img src="{{ asset('assets/images/my/logo-black-tp.png') }}" width="65" alt="logo">
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <i class="ti ti-menu-2"></i>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-lg-center gap-lg-3">
                    <li class="nav-item"><a class="nav-link {{ request()->is('/') ? 'active fw-semibold' : '' }}" href="/">Home</a></li>
                    <li class="nav-item"><a class="nav-link {{ request()->is('dashboard') ? 'active fw-semibold' : '' }}" href="/dashboard">Dashboard</a></li>
                    <li class="nav-item"><a class="nav-link {{ request()->is('contact-us') ? 'active fw-semibold' : '' }}" href="/contact-us">Contact Us</a></li>

                    @if(auth()->check())
                        <li class="nav-item mt-2 mt-lg-0">
                            <a class="btn btn-primary px-4 py-2" href="/myprofile">{{ auth()->user()->name }}</a>
                        </li>
                    @else
                        <li class="nav-item mt-2 mt-lg-0">
                            <a class="btn btn-primary px-4 py-2" href="/login">Login</a>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
    </nav>

    <!-- PAGE CONTENT -->
    <main class="pt-5 mt-4">
        @yield('content')
    </main>

    <!-- FOOTER -->
    <footer class="text-white pt-5 pb-3 mt-5">
        <div class="container">
            <div class="row g-4">
                <div class="col-md-4">
                    <img src="{{ asset('assets/images/my/logo-black-tp.png') }}" alt="Logo" class="img-fluid mb-3" style="max-width: 180px;">
                    <p class="text-gray-300">Sekolah Harapan Bangsa berkomitmen mencetak generasi cerdas, kreatif, dan berakhlak.</p>
                </div>

                <div class="col-md-8">
                    <div class="row">
                        <div class="col-sm-4">
                            <h5 class="fw-semibold mb-3">Navigasi</h5>
                            <ul class="list-unstyled small">
                                <li><a href="/">Beranda</a></li>
                                <li><a href="/#alur">Alur Pendaftaran</a></li>
                                <li><a href="#">Pengumuman</a></li>
                                <li><a href="/contact">Kontak</a></li>
                            </ul>
                        </div>

                        <div class="col-sm-4">
                            <h5 class="fw-semibold mb-3">Hubungi Kami</h5>
                            <ul class="list-unstyled small">
                                <li class="d-flex gap-2"><i class="ti ti-map-pin"></i> Jalan Raya Siwalan Panji, Bedrek, Siwalanpanji, Kec Sidoarjo, Kabupaten Jawa Timur</li>
                                <li class="d-flex gap-2"><i class="ti ti-mail"></i> SMKAntartika1SDA@gmail.com</li>
                                <li class="d-flex gap-2"><i class="ti ti-phone"></i> (021) 123-4567</li>
                            </ul>
                        </div>

                        <div class="col-sm-4">
                            <h5 class="fw-semibold mb-3">Tautan Lainnya</h5>
                            <ul class="list-unstyled small">
                                <li><a href="#">Kebijakan Privasi</a></li>
                                <li><a href="#">Syarat & Ketentuan</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <div class="border-top border-gray-700 mt-4 pt-3 d-flex justify-content-between small">
                <span>© {{ date('Y') }} SMK Antartika 1 Sidoarjo. Hak Cipta Dilindungi.</span>
                <div class="d-flex gap-3">
                    <a href="#"><i class="ti ti-brand-facebook"></i></a>
                    <a href="#"><i class="ti ti-brand-instagram"></i></a>
                    <a href="#"><i class="ti ti-brand-youtube"></i></a>
                </div>
            </div>
        </div>
    </footer>

    <!-- JS -->
    <script src="{{ asset('assets/js/plugins/bootstrap.min.js') }}"></script>
    <script>
        // Navbar scroll effect
        const nav = document.getElementById('mainNav');
        window.addEventListener('scroll', () => {
            if (window.scrollY > 20) nav.classList.add('scrolled');
            else nav.classList.remove('scrolled');
        });
    </script>

</body>
</html>
