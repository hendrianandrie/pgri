<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'PGRI - Persatuan Guru Republik Indonesia')</title>

    <!-- Favicon Official PGRI -->
    <link rel="icon" type="image/png" href="{{ asset('images/logo-pgri.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('images/logo-pgri.png') }}">

    <!-- Google Fonts: Plus Jakarta Sans & Inter -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <!-- Bootstrap 5.3 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome 6 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <style>
        :root {
            /* Warna Resmi Logo PGRI */
            --pgri-red: #dc2626;         /* Merah Lingkaran Luar & Lidah Api */
            --pgri-red-dark: #991b1b;
            --pgri-green: #15803d;       /* Hijau Daun Latar Obor & Buku */
            --pgri-green-dark: #166534;
            --pgri-green-light: #22c55e;
            --pgri-gold: #f59e0b;        /* Kuning Keemasan Obor Penerang */
            --pgri-gold-bright: #facc15;
            --pgri-navy: #0f172a;        /* Slate/Navy Kontras Modern */
            --pgri-slate: #1e293b;
            --pgri-bg: #f8fafc;
        }

        body {
            font-family: 'Plus Jakarta Sans', 'Inter', sans-serif;
            background-color: var(--pgri-bg);
            color: #1e293b;
            overflow-x: hidden;
        }

        /* Accent Tri-Color Stripe (Merah - Hijau - Emas Logo PGRI) */
        .pgri-accent-stripe {
            height: 3.5px;
            background: linear-gradient(90deg, #dc2626 0%, #dc2626 35%, #15803d 35%, #15803d 68%, #f59e0b 68%, #f59e0b 100%);
            width: 100%;
        }

        /* Top Bar */
        .top-bar {
            background-color: var(--pgri-navy);
            color: rgba(255, 255, 255, 0.9);
            font-size: 0.82rem;
            padding: 8px 0;
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
        }

        /* Main Navbar */
        .navbar-pgri {
            background: linear-gradient(135deg, #090d16 0%, #0f172a 60%, #1e1b4b 100%);
            box-shadow: 0 4px 20px rgba(15, 23, 42, 0.2);
            padding: 12px 0;
            border-bottom: 1px solid rgba(255, 255, 255, 0.06);
        }

        .navbar-logo-img {
            width: 48px;
            height: 48px;
            object-fit: contain;
            filter: drop-shadow(0 2px 8px rgba(0, 0, 0, 0.4));
            transition: transform 0.25s ease;
        }

        .navbar-brand:hover .navbar-logo-img {
            transform: scale(1.08) rotate(3deg);
        }

        .nav-link-pgri {
            color: rgba(255, 255, 255, 0.85) !important;
            font-weight: 600;
            font-size: 0.92rem;
            padding: 8px 16px !important;
            border-radius: 10px;
            transition: all 0.2s ease;
        }

        .nav-link-pgri:hover, .nav-link-pgri.active {
            color: #ffffff !important;
            background-color: rgba(220, 38, 38, 0.2);
            border: 1px solid rgba(220, 38, 38, 0.4);
        }

        .dropdown-menu-sakti {
            border: 1px solid rgba(226, 232, 240, 0.8);
            border-radius: 16px;
            box-shadow: 0 20px 40px rgba(15, 23, 42, 0.15);
            padding: 12px;
            min-width: 290px;
        }

        .dropdown-item-sakti {
            border-radius: 10px;
            padding: 10px 14px;
            transition: all 0.2s ease;
        }

        .dropdown-item-sakti:hover {
            background-color: #f1f5f9;
        }

        /* ScrewFast Inspired Components */
        .screw-hero {
            background: radial-gradient(circle at top right, rgba(220, 38, 38, 0.08), transparent 45%),
                        radial-gradient(circle at bottom left, rgba(21, 128, 61, 0.07), transparent 45%),
                        radial-gradient(circle at center, rgba(245, 158, 11, 0.04), transparent 50%),
                        #ffffff;
            position: relative;
        }

        .screw-card {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 20px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.03);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .screw-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 16px 32px rgba(15, 23, 42, 0.08);
            border-color: #cbd5e1;
        }

        .screw-card-dark {
            background: var(--pgri-navy);
            color: #ffffff;
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 20px;
            transition: all 0.3s ease;
        }

        .screw-card-dark:hover {
            border-color: rgba(245, 158, 11, 0.4);
            transform: translateY(-4px);
        }

        .glass-floating {
            background: rgba(255, 255, 255, 0.92);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.8);
            border-radius: 16px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.12);
        }

        .badge-screw {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 6px 14px;
            border-radius: 50px;
            font-size: 0.78rem;
            font-weight: 700;
            letter-spacing: 0.3px;
        }

        /* Buttons Bertema Logo PGRI (Merah, Hijau, Emas) */
        .btn-screw-primary {
            background: linear-gradient(135deg, var(--pgri-red) 0%, #b91c1c 100%);
            color: white;
            font-weight: 700;
            border: none;
            border-radius: 12px;
            padding: 12px 26px;
            box-shadow: 0 8px 24px rgba(220, 38, 38, 0.3);
            transition: all 0.25s ease;
        }

        .btn-screw-primary:hover {
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 12px 28px rgba(220, 38, 38, 0.4);
        }

        .btn-screw-green {
            background: linear-gradient(135deg, var(--pgri-green) 0%, #166534 100%);
            color: white;
            font-weight: 700;
            border: none;
            border-radius: 12px;
            padding: 12px 26px;
            box-shadow: 0 8px 24px rgba(21, 128, 61, 0.3);
            transition: all 0.25s ease;
        }

        .btn-screw-green:hover {
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 12px 28px rgba(21, 128, 61, 0.4);
        }

        .btn-screw-gold {
            background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
            color: white;
            font-weight: 700;
            border: none;
            border-radius: 12px;
            padding: 12px 26px;
            box-shadow: 0 8px 24px rgba(245, 158, 11, 0.3);
            transition: all 0.25s ease;
        }

        .btn-screw-gold:hover {
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 12px 28px rgba(245, 158, 11, 0.4);
        }

        .btn-screw-secondary {
            background: #ffffff;
            color: var(--pgri-navy);
            border: 1px solid #cbd5e1;
            font-weight: 700;
            border-radius: 12px;
            padding: 12px 26px;
            transition: all 0.25s ease;
        }

        .btn-screw-secondary:hover {
            background: #f8fafc;
            border-color: var(--pgri-green);
            color: var(--pgri-green);
            transform: translateY(-2px);
        }

        /* Footer */
        .footer-pgri {
            background: #090d16;
            color: rgba(255, 255, 255, 0.7);
            padding: 70px 0 30px;
            border-top: 1px solid rgba(255, 255, 255, 0.08);
        }

        .footer-title {
            color: #ffffff;
            font-weight: 800;
            font-size: 1.05rem;
            margin-bottom: 20px;
        }

        .pill-tab {
            background-color: #f1f5f9;
            border-radius: 14px;
            padding: 6px;
            display: inline-flex;
            gap: 4px;
            flex-wrap: wrap;
        }

        .pill-tab-btn {
            border: none;
            background: transparent;
            color: #64748b;
            font-weight: 700;
            font-size: 0.85rem;
            padding: 10px 20px;
            border-radius: 10px;
            transition: all 0.2s ease;
        }

        .pill-tab-btn.active, .pill-tab-btn:hover {
            background-color: #ffffff;
            color: var(--pgri-navy);
            box-shadow: 0 4px 12px rgba(0,0,0,0.06);
        }

        .pill-tab-btn.active {
            color: var(--pgri-red);
        }
    </style>
</head>
<body>

    <!-- Tri-Color Top Accent Line (Red - Green - Gold) -->
    <div class="pgri-accent-stripe"></div>

    <!-- MAIN NAVBAR -->
    <nav class="navbar navbar-expand-lg navbar-dark navbar-pgri sticky-top">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center gap-3" href="{{ route('home') }}">
                <img src="{{ asset('images/logo-pgri.png') }}" alt="Logo PGRI" class="navbar-logo-img flex-shrink-0" style="width: 48px; height: 48px; max-width: 48px; max-height: 48px; object-fit: contain;">
                <div class="d-flex flex-column justify-content-center">
                    <span class="text-white fs-4 tracking-tight" style="font-weight: 900; line-height: 1; letter-spacing: -0.5px;">PGRI</span>
                    <span class="text-slate-300 text-uppercase tracking-wider" style="font-size: 0.65rem; font-weight: 700; line-height: 1; opacity: 0.9; margin-top: 2px;">Persatuan Guru Republik Indonesia</span>
                </div>
            </a>

            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMain">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarMain">
                <ul class="navbar-nav ms-auto align-items-lg-center gap-1 mt-3 mt-lg-0">
                    <li class="nav-item">
                        <a class="nav-link nav-link-pgri {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">
                            <i class="fa-solid fa-house me-1 text-danger"></i> Beranda
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link nav-link-pgri {{ request()->routeIs('profile') ? 'active' : '' }}" href="{{ route('profile') }}">
                            <i class="fa-solid fa-landmark me-1 text-success"></i> Profil
                        </a>
                    </li>
                    
                    <!-- Dropdown SAKTI -->
                    <li class="nav-item dropdown">
                        <a class="nav-link nav-link-pgri dropdown-toggle {{ request()->routeIs('sakti.*') ? 'active' : '' }}" href="#" role="button" data-bs-toggle="dropdown">
                            <i class="fa-solid fa-wand-magic-sparkles text-amber-400 me-1"></i> SAKTI PGRI
                        </a>
                        <ul class="dropdown-menu dropdown-menu-sakti mt-2">
                            <li>
                                <a class="dropdown-item dropdown-item-sakti d-flex align-items-center gap-3" href="{{ route('sakti.pembelajaran-mendalam') }}">
                                    <div class="rounded-circle bg-info bg-opacity-10 text-info p-2 d-flex align-items-center justify-content-center" style="width: 38px; height: 38px;">
                                        <i class="fa-solid fa-brain fs-6"></i>
                                    </div>
                                    <div>
                                        <div class="fw-bold text-dark small">Pembelajaran Mendalam</div>
                                        <div class="text-muted extra-small" style="font-size: 0.72rem;">Model Deep Learning & Pedagogi Modern</div>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item dropdown-item-sakti d-flex align-items-center gap-3" href="{{ route('sakti.rumah-pendidikan') }}">
                                    <div class="rounded-circle bg-success bg-opacity-10 text-success p-2 d-flex align-items-center justify-content-center" style="width: 38px; height: 38px;">
                                        <i class="fa-solid fa-folder-open fs-6"></i>
                                    </div>
                                    <div>
                                        <div class="fw-bold text-dark small">Rumah Pendidikan</div>
                                        <div class="text-muted extra-small" style="font-size: 0.72rem;">Repositori Modul & Perangkat Ajar</div>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item dropdown-item-sakti d-flex align-items-center gap-3" href="{{ route('sakti.pid') }}">
                                    <div class="rounded-circle bg-warning bg-opacity-10 text-warning p-2 d-flex align-items-center justify-content-center" style="width: 38px; height: 38px;">
                                        <i class="fa-solid fa-bullhorn fs-6"></i>
                                    </div>
                                    <div>
                                        <div class="fw-bold text-dark small">PID (Pusat Informasi Digital)</div>
                                        <div class="text-muted extra-small" style="font-size: 0.72rem;">Portal Berita & Edaran Resmi</div>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item dropdown-item-sakti d-flex align-items-center gap-3" href="{{ route('sakti.koding-kka') }}">
                                    <div class="rounded-circle bg-purple bg-opacity-10 text-purple p-2 d-flex align-items-center justify-content-center" style="width: 38px; height: 38px; color: #9333ea;">
                                        <i class="fa-solid fa-code fs-6"></i>
                                    </div>
                                    <div>
                                        <div class="fw-bold text-dark small">Koding / KKA</div>
                                        <div class="text-muted extra-small" style="font-size: 0.72rem;">Berpikir Komputasional & AI</div>
                                    </div>
                                </a>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <a class="dropdown-item dropdown-item-sakti text-center fw-bold text-danger small" href="{{ route('sakti.index') }}">
                                    Lihat Semua Layanan SAKTI <i class="fa-solid fa-arrow-right ms-1"></i>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link nav-link-pgri {{ request()->routeIs('news.*') ? 'active' : '' }}" href="{{ route('news.index') }}">
                            <i class="fa-solid fa-newspaper me-1 text-danger"></i> Berita
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link nav-link-pgri {{ request()->routeIs('gallery.index') ? 'active' : '' }}" href="{{ route('gallery.index') }}">
                            <i class="fa-solid fa-images me-1 text-warning"></i> Galeri
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link nav-link-pgri {{ request()->routeIs('contact.index') ? 'active' : '' }}" href="{{ route('contact.index') }}">
                            <i class="fa-solid fa-paper-plane me-1 text-info"></i> Kontak
                        </a>
                    </li>
                    <li class="nav-item ms-lg-2 mt-2 mt-lg-0">
                        <a class="btn btn-warning text-dark font-bold rounded-3 px-3.5 py-2 shadow-sm d-inline-flex align-items-center gap-1.5 fw-bold text-decoration-none" style="font-size: 0.88rem; background: linear-gradient(135deg, #facc15 0%, #f59e0b 100%); border: none;" href="{{ route('admin.login') }}">
                            <i class="fa-solid fa-user-shield text-danger"></i> Login Admin
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- CONTENT -->
    <main>
        @yield('content')
    </main>

    <!-- FOOTER -->
    @php
        $footerIg = \App\Models\Setting::get('office_instagram', '@pbpgri_official');
        $footerIgUrl = str_starts_with($footerIg, 'http') ? $footerIg : 'https://www.instagram.com/' . ltrim($footerIg, '@');
        $footerTt = \App\Models\Setting::get('office_tiktok', '@pbpgri_official');
        $footerTtUrl = str_starts_with($footerTt, 'http') ? $footerTt : 'https://www.tiktok.com/@' . ltrim($footerTt, '@');
        $footerWa = \App\Models\Setting::get('office_whatsapp', '0812-3456-7890');
        $footerWaNum = preg_replace('/[^0-9]/', '', $footerWa);
        if (str_starts_with($footerWaNum, '0')) {
            $footerWaNum = '62' . substr($footerWaNum, 1);
        }
        $footerWaUrl = 'https://wa.me/' . $footerWaNum;
    @endphp
    <footer class="footer-pgri">
        <div class="container">
            <div class="row g-4 mb-5">
                <div class="col-lg-4">
                    <div class="d-flex align-items-center gap-3 mb-3">
                        <img src="{{ asset('images/logo-pgri.png') }}" alt="Logo PGRI" style="width: 48px; height: 48px; max-width: 48px; max-height: 48px; object-fit: contain;" class="flex-shrink-0 drop-shadow">
                        <div class="d-flex flex-column justify-content-center">
                            <h5 class="text-white mb-0" style="font-weight: 900; line-height: 1;">PGRI</h5>
                            <div class="small text-emerald-400 font-semibold" style="line-height: 1; margin-top: 2px;">Persatuan Guru Republik Indonesia</div>
                        </div>
                    </div>
                    <p class="small text-white-50 leading-relaxed mb-3">Organisasi profesi guru pertama dan terbesar di Indonesia sejak 1945, bertransformasi mewujudkan guru profesional, sejahtera, bermartabat, serta melek koding & kecerdasan buatan melalui platform SAKTI PGRI.</p>
                    <div class="d-flex align-items-center gap-2">
                        <a href="{{ $footerIgUrl }}" target="_blank" rel="noopener" class="text-white d-inline-flex align-items-center justify-content-center rounded-circle text-decoration-none shadow-sm" style="width: 36px; height: 36px; background: linear-gradient(45deg, #f09433 0%, #e6683c 25%, #dc2743 50%, #cc2366 75%, #bc1888 100%);" title="Instagram Resmi {{ $footerIg }}">
                            <i class="fa-brands fa-instagram"></i>
                        </a>
                        <a href="{{ $footerTtUrl }}" target="_blank" rel="noopener" class="text-white d-inline-flex align-items-center justify-content-center rounded-circle text-decoration-none bg-dark border border-secondary shadow-sm" style="width: 36px; height: 36px;" title="TikTok Resmi {{ $footerTt }}">
                            <i class="fa-brands fa-tiktok"></i>
                        </a>
                        <a href="{{ $footerWaUrl }}" target="_blank" rel="noopener" class="text-white d-inline-flex align-items-center justify-content-center rounded-circle text-decoration-none bg-success shadow-sm" style="width: 36px; height: 36px;" title="WhatsApp Center">
                            <i class="fa-brands fa-whatsapp"></i>
                        </a>
                    </div>
                </div>

                <div class="col-lg-3">
                    <h5 class="footer-title">Menu Navigasi</h5>
                    <ul class="list-unstyled small d-flex flex-column gap-2.5">
                        <li><a href="{{ route('home') }}" class="text-white-50 text-decoration-none"><i class="fa-solid fa-chevron-right text-danger me-2"></i> Beranda Utama</a></li>
                        <li><a href="{{ route('profile') }}" class="text-white-50 text-decoration-none"><i class="fa-solid fa-chevron-right text-success me-2"></i> Profil & Visi Misi PGRI</a></li>
                        <li><a href="{{ route('news.index') }}" class="text-white-50 text-decoration-none"><i class="fa-solid fa-chevron-right text-danger me-2"></i> Berita & Reportase</a></li>
                        <li><a href="{{ route('gallery.index') }}" class="text-white-50 text-decoration-none"><i class="fa-solid fa-chevron-right text-warning me-2"></i> Galeri & Dokumentasi</a></li>
                        <li><a href="{{ route('contact.index') }}" class="text-white-50 text-decoration-none"><i class="fa-solid fa-chevron-right text-info me-2"></i> Layanan Kontak & Aspirasi</a></li>
                        <li><a href="{{ route('admin.login') }}" class="text-warning text-decoration-none fw-bold"><i class="fa-solid fa-user-shield me-2 text-emerald-400"></i> Portal Admin PGRI</a></li>
                    </ul>
                </div>

                <div class="col-lg-3">
                    <h5 class="footer-title">Ekosistem SAKTI</h5>
                    <ul class="list-unstyled small d-flex flex-column gap-2.5">
                        <li><a href="{{ route('sakti.pembelajaran-mendalam') }}" class="text-white-50 text-decoration-none"><i class="fa-solid fa-brain text-info me-2"></i> Pembelajaran Mendalam</a></li>
                        <li><a href="{{ route('sakti.rumah-pendidikan') }}" class="text-white-50 text-decoration-none"><i class="fa-solid fa-folder-open text-success me-2"></i> Rumah Pendidikan</a></li>
                        <li><a href="{{ route('sakti.pid') }}" class="text-white-50 text-decoration-none"><i class="fa-solid fa-bullhorn text-warning me-2"></i> PID (Pusat Informasi Digital)</a></li>
                        <li><a href="{{ route('sakti.koding-kka') }}" class="text-white-50 text-decoration-none"><i class="fa-solid fa-code me-2" style="color:#c084fc;"></i> Koding / KKA & AI</a></li>
                    </ul>
                </div>

                <div class="col-lg-2">
                    <h5 class="footer-title">Sekretariat</h5>
                    <div class="small text-white-50">
                        <p class="mb-2"><i class="fa-solid fa-location-dot text-danger me-2"></i> {{ \App\Models\Setting::get('office_address', 'Jl. Tanah Abang III No. 24, Jakarta Pusat') }}</p>
                        <p class="mb-2"><i class="fa-solid fa-phone text-warning me-2"></i> {{ \App\Models\Setting::get('office_phone', '(021) 3844932') }}</p>
                        <p class="mb-2"><i class="fa-solid fa-envelope text-emerald-400 me-2"></i> {{ \App\Models\Setting::get('office_email', 'sekretariat@pgri.or.id') }}</p>
                        <p class="mb-1"><i class="fa-brands fa-instagram text-danger me-2"></i> <a href="{{ $footerIgUrl }}" target="_blank" class="text-white-50 text-decoration-none">{{ $footerIg }}</a></p>
                        <p class="mb-0"><i class="fa-brands fa-tiktok text-white me-2"></i> <a href="{{ $footerTtUrl }}" target="_blank" class="text-white-50 text-decoration-none">{{ $footerTt }}</a></p>
                    </div>
                </div>
            </div>

            <!-- Tri-color thin divider -->
            <div class="pgri-accent-stripe opacity-40 mb-4 rounded"></div>

            <div class="d-flex flex-column flex-md-row align-items-center justify-content-between gap-3 small text-white-50">
                <div>&copy; {{ date('Y') }} PB PGRI (Persatuan Guru Republik Indonesia) — All Rights Reserved.</div>
                <div>Transformasi Digital Guru Indonesia dengan Platform SAKTI | <a href="{{ route('admin.login') }}" class="text-warning text-decoration-none font-bold">Admin Portal</a></div>
            </div>
        </div>
    </footer>

    <!-- Bootstrap 5.3 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
