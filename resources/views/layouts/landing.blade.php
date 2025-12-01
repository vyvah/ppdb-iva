<!DOCTYPE html>
<html lang="en" class="scroll-smooth">

<head>
    <title>@yield('title') - PPDB SMK Antartika</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="PPDB Online SMK Antartika 1 Sidoarjo - Sistem Penerimaan Peserta Didik Baru">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">

    <!-- Icons -->
    <link rel="stylesheet" href="{{ asset('assets/fonts/tabler-icons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/fonts/feather.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/fonts/fontawesome.css') }}">

    <!-- Core CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style-preset.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/landing.css') }}">

    <style>
        :root {
            --primary: #4f46e5;
            --primary-dark: #4338ca;
            --primary-light: #eef2ff;
            --secondary: #06b6d4;
            --text-dark: #0f172a;
            --text-muted: #64748b;
            --bg-light: #f8fafc;
            --card-bg: #fff;
            --radius: 16px;
            --radius-sm: 12px;
            --shadow: 0 4px 18px rgba(0, 0, 0, 0.06);
            --shadow-hover: 0 12px 32px rgba(79, 70, 229, 0.15);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            background-color: var(--bg-light);
            color: var(--text-dark);
            line-height: 1.6;
        }

        h1,
        h2,
        h3,
        h4,
        h5,
        h6 {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            font-weight: 700;
            line-height: 1.3;
        }

        a {
            text-decoration: none;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        /* Navbar Modern Style */
        .navbar-modern {
            backdrop-filter: blur(10px);
            background: rgba(255, 255, 255, 0.7) !important;
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            padding: 1rem 0 !important;
        }

        .navbar-modern.scrolled {
            background: rgba(255, 255, 255, 0.95) !important;
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.08);
            padding: 0.75rem 0 !important;
        }

        .navbar-brand {
            display: flex;
            align-items: center;
            font-weight: 700;
            color: var(--primary) !important;
        }

        .navbar-brand img {
            transition: transform 0.3s ease;
        }

        .navbar-brand:hover img {
            transform: scale(1.05);
        }

        .navbar-nav .nav-link {
            color: var(--text-dark) !important;
            font-weight: 500;
            font-size: 0.95rem;
            padding: 0.5rem 1rem !important;
            position: relative;
        }

        .navbar-nav .nav-link::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 1rem;
            width: 0;
            height: 2px;
            background: var(--primary);
            transition: width 0.3s ease;
        }

        .navbar-nav .nav-link:hover::after,
        .navbar-nav .nav-link.active::after {
            width: calc(100% - 2rem);
        }

        .navbar-nav .nav-link.active {
            color: var(--primary) !important;
            font-weight: 600;
        }

        .navbar-toggler {
            border: none;
            color: var(--primary) !important;
            font-size: 1.5rem;
        }

        .navbar-toggler:focus {
            outline: none;
            box-shadow: none;
        }

        /* Button Styles */
        .btn-primary {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            border: none;
            border-radius: var(--radius-sm);
            font-weight: 600;
            font-size: 0.95rem;
            padding: 0.6rem 1.4rem;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(79, 70, 229, 0.2);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(79, 70, 229, 0.3);
        }

        .btn-primary:active {
            transform: translateY(0);
        }

        .btn-outline-light {
            border: 2px solid rgba(255, 255, 255, 0.5);
            color: #fff !important;
            font-weight: 600;
            border-radius: var(--radius-sm);
            transition: all 0.3s ease;
        }

        .btn-outline-light:hover {
            background: rgba(255, 255, 255, 0.15);
            border-color: #fff;
            backdrop-filter: blur(10px);
        }

        /* Footer Styles */
        footer {
            background: linear-gradient(180deg, #0f172a 0%, #1e293b 100%);
            color: #cbd5e1;
            border-top: 1px solid rgba(255, 255, 255, 0.05);
        }

        footer h5 {
            color: #fff;
            font-weight: 700;
            margin-bottom: 1.25rem;
            font-size: 0.95rem;
            letter-spacing: 0.5px;
            text-transform: uppercase;
        }

        footer a {
            color: #cbd5e1;
            transition: all 0.3s ease;
            font-size: 0.95rem;
        }

        footer a:hover {
            color: var(--primary);
            transform: translateX(3px);
        }

        footer ul li {
            margin-bottom: 0.75rem;
        }

        footer .border-top {
            border-color: rgba(255, 255, 255, 0.1) !important;
        }

        footer .d-flex.gap-3 a {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.08);
            font-size: 1.2rem;
        }

        footer .d-flex.gap-3 a:hover {
            background: var(--primary);
            color: #fff;
        }

        /* Main Content */
        main {
            min-height: 100vh;
        }

        /* Smooth transitions */
        .transition-all {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        /* Responsive Navbar */
        @media (max-width: 991.98px) {
            .navbar-modern {
                background: rgba(255, 255, 255, 0.95) !important;
                box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            }

            .navbar-nav {
                margin-top: 1rem;
            }

            .navbar-nav .nav-link {
                padding: 0.75rem 0 !important;
                border-bottom: 1px solid rgba(79, 70, 229, 0.1);
            }

            .navbar-nav .nav-link::after {
                display: none;
            }

            .navbar-nav .nav-item:last-child {
                border-bottom: none;
            }
        }
    </style>
</head>

<body>

    <!-- NAVBAR -->
    <nav class="navbar navbar-expand-lg navbar-light fixed-top navbar-modern" id="mainNav">
        <div class="container">
            <a class="navbar-brand fw-bold" href="/">
                <img src="{{ asset('assets/images/my/logo-black-tp.png') }}" width="65" alt="logo">
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <i class="ti ti-menu-2"></i>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-lg-center gap-lg-3">
                    <li class="nav-item"><a class="nav-link {{ request()->is('/') ? 'active fw-semibold' : '' }}"
                            href="/">Home</a></li>
                    <li class="nav-item"><a
                            class="nav-link {{ request()->is('dashboard') ? 'active fw-semibold' : '' }}"
                            href="/dashboard">Dashboard</a></li>
                    <li class="nav-item"><a
                            class="nav-link {{ request()->is('contact-us') ? 'active fw-semibold' : '' }}"
                            href="/contact-us">Contact Us</a></li>

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
                    <img src="{{ asset('assets/images/my/logo-black-tp.png') }}" alt="Logo" class="img-fluid mb-3"
                        style="max-width: 180px;">
                    <p class="text-gray-300" style="font-size: 0.95rem; line-height: 1.6;">SMK Antartika 1 Sidoarjo
                        berkomitmen mencetak generasi cerdas, kreatif, dan berakhlak melalui pendidikan berkualitas.</p>
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
                                <li class="d-flex gap-2"><i class="ti ti-map-pin"
                                        style="flex-shrink: 0; margin-top: 2px;"></i> <span>Jalan Raya Siwalan Panji,
                                        Bedrek, Siwalanpanji, Kec Sidoarjo, Kabupaten Jawa Timur</span></li>
                                <li class="d-flex gap-2"><i class="ti ti-mail"
                                        style="flex-shrink: 0; margin-top: 2px;"></i> SMKAntartika1SDA@gmail.com</li>
                                <li class="d-flex gap-2"><i class="ti ti-phone"
                                        style="flex-shrink: 0; margin-top: 2px;"></i> (021) 123-4567</li>
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

            <div
                class="border-top border-gray-700 mt-4 pt-3 d-flex justify-content-between align-items-center small flex-wrap gap-3">
                <span>© {{ date('Y') }} SMK Antartika 1 Sidoarjo. Hak Cipta Dilindungi.</span>
                <div class="d-flex gap-3">
                    <a href="#" title="Facebook"><i class="ti ti-brand-facebook"></i></a>
                    <a href="#" title="Instagram"><i class="ti ti-brand-instagram"></i></a>
                    <a href="#" title="YouTube"><i class="ti ti-brand-youtube"></i></a>
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
