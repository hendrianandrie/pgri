<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Panel') - PGRI Portal</title>
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('images/logo-pgri.png') }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        /* Pagination Styling in Admin */
        .pagination {
            display: inline-flex;
            gap: 0.25rem;
            align-items: center;
            list-style: none;
            padding: 0;
            margin: 0;
        }
        .pagination .page-item .page-link {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 2.25rem;
            height: 2.25rem;
            padding: 0.25rem 0.65rem;
            font-size: 0.875rem;
            font-weight: 600;
            color: #475569;
            background-color: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 0.5rem;
            transition: all 0.15s ease;
            text-decoration: none;
        }
        .pagination .page-item .page-link:hover {
            background-color: #f1f5f9;
            color: #0f172a;
            border-color: #cbd5e1;
        }
        .pagination .page-item.active .page-link {
            background-color: #dc2626;
            border-color: #dc2626;
            color: #ffffff;
            box-shadow: 0 2px 6px rgba(220, 38, 38, 0.3);
        }
        .pagination .page-item.disabled .page-link {
            color: #94a3b8;
            background-color: #f8fafc;
            border-color: #e2e8f0;
            cursor: not-allowed;
        }
        nav svg, .pagination svg {
            width: 1.25rem !important;
            height: 1.25rem !important;
            max-width: 1.25rem !important;
            max-height: 1.25rem !important;
        }
    </style>
</head>
<body class="bg-slate-100 text-slate-800 font-sans antialiased min-h-screen flex flex-col md:flex-row">

    <!-- Sidebar -->
    <aside class="w-full md:w-64 bg-slate-900 text-slate-200 flex-shrink-0 flex flex-col justify-between min-h-screen">
        <div>
            <!-- Logo Header -->
            <div class="p-5 border-b border-slate-800 flex items-center gap-3">
                <img src="{{ asset('images/logo-pgri.png') }}" alt="Logo PGRI" class="w-11 h-11 object-contain drop-shadow">
                <div>
                    <h1 class="font-extrabold text-white text-base leading-tight">Admin PGRI</h1>
                    <p class="text-xs text-emerald-400 font-medium">Portal Kelola Konten</p>
                </div>
            </div>

            <!-- Navigation Links -->
            <nav class="p-4 space-y-1.5 text-sm font-medium">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg transition {{ request()->routeIs('admin.dashboard') ? 'bg-red-700 text-white font-semibold shadow-md' : 'text-slate-400 hover:text-white hover:bg-slate-800' }}">
                    <i class="fa-solid fa-chart-pie w-5 text-center text-amber-400"></i>
                    <span>Dashboard</span>
                </a>

                <a href="{{ route('admin.hero-settings') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg transition {{ request()->routeIs('admin.hero-settings*') ? 'bg-red-700 text-white font-semibold shadow-md' : 'text-slate-400 hover:text-white hover:bg-slate-800' }}">
                    <i class="fa-solid fa-panorama w-5 text-center text-indigo-400"></i>
                    <span>Banner Beranda</span>
                </a>
                
                <!-- Pilar SAKTI PGRI Section -->
                <div class="pt-2 pb-1 px-3">
                    <p class="text-[10px] font-extrabold uppercase tracking-wider text-slate-400/80 flex items-center gap-1.5">
                        <i class="fa-solid fa-layer-group text-amber-400 text-xs"></i>
                        <span>Modul SAKTI PGRI</span>
                    </p>
                </div>

                <a href="{{ route('admin.sakti.pembelajaran-mendalam') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg transition text-xs font-semibold {{ request()->routeIs('admin.sakti.pembelajaran-mendalam') ? 'bg-red-700 text-white shadow-md' : 'text-slate-300 hover:text-white hover:bg-slate-800' }}">
                    <i class="fa-solid fa-brain w-4 text-center text-sky-400"></i>
                    <span>Pembelajaran Mendalam</span>
                </a>

                <a href="{{ route('admin.sakti.rumah-pendidikan') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg transition text-xs font-semibold {{ request()->routeIs('admin.sakti.rumah-pendidikan') ? 'bg-red-700 text-white shadow-md' : 'text-slate-300 hover:text-white hover:bg-slate-800' }}">
                    <i class="fa-solid fa-folder-open w-4 text-center text-emerald-400"></i>
                    <span>Rumah Pendidikan</span>
                </a>

                <a href="{{ route('admin.sakti.pid') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg transition text-xs font-semibold {{ request()->routeIs('admin.sakti.pid') ? 'bg-red-700 text-white shadow-md' : 'text-slate-300 hover:text-white hover:bg-slate-800' }}">
                    <i class="fa-solid fa-bullhorn w-4 text-center text-amber-400"></i>
                    <span>Papan Interaktif Digital</span>
                </a>

                <a href="{{ route('admin.sakti.koding-kka') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg transition text-xs font-semibold {{ request()->routeIs('admin.sakti.koding-kka') ? 'bg-red-700 text-white shadow-md' : 'text-slate-300 hover:text-white hover:bg-slate-800' }}">
                    <i class="fa-solid fa-code w-4 text-center text-purple-400"></i>
                    <span>Koding & AI (KKA)</span>
                </a>

                <a href="{{ route('admin.profile-settings') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg transition {{ request()->routeIs('admin.profile-settings*') ? 'bg-red-700 text-white font-semibold shadow-md' : 'text-slate-400 hover:text-white hover:bg-slate-800' }}">
                    <i class="fa-solid fa-address-card w-5 text-center text-sky-400"></i>
                    <span>Profil & Visi Misi</span>
                </a>

                <a href="{{ route('admin.executives.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg transition {{ request()->routeIs('admin.executives.*') ? 'bg-red-700 text-white font-semibold shadow-md' : 'text-slate-400 hover:text-white hover:bg-slate-800' }}">
                    <i class="fa-solid fa-users-gear w-5 text-center text-emerald-400"></i>
                    <span>Pengurus & Organisasi</span>
                </a>

                <a href="{{ route('admin.news.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg transition {{ request()->routeIs('admin.news.*') ? 'bg-red-700 text-white font-semibold shadow-md' : 'text-slate-400 hover:text-white hover:bg-slate-800' }}">
                    <i class="fa-solid fa-newspaper w-5 text-center text-rose-400"></i>
                    <span>Berita & Reportase</span>
                </a>

                <a href="{{ route('admin.comments.index') }}" class="flex items-center justify-between px-3 py-2.5 rounded-lg transition {{ request()->routeIs('admin.comments.*') ? 'bg-red-700 text-white font-semibold shadow-md' : 'text-slate-400 hover:text-white hover:bg-slate-800' }}">
                    <div class="flex items-center gap-3">
                        <i class="fa-solid fa-comment-dots w-5 text-center text-cyan-400"></i>
                        <span>Komentar & Diskusi</span>
                    </div>
                    @php
                        $pendingCommentsCount = \App\Models\Comment::pending()->count();
                    @endphp
                    @if($pendingCommentsCount > 0)
                        <span class="px-2 py-0.5 text-[10px] font-extrabold bg-amber-500 text-white rounded-full shadow-sm">{{ $pendingCommentsCount }}</span>
                    @endif
                </a>

                <a href="{{ route('admin.submissions.index') }}" class="flex items-center justify-between px-3 py-2.5 rounded-lg transition {{ request()->routeIs('admin.submissions.*') ? 'bg-red-700 text-white font-semibold shadow-md' : 'text-slate-400 hover:text-white hover:bg-slate-800' }}">
                    <div class="flex items-center gap-3">
                        <i class="fa-solid fa-feather-pointed w-5 text-center text-amber-400"></i>
                        <span>Kiriman Masuk</span>
                    </div>
                    @php
                        $pendingSubmissionsCount = \App\Models\ContentSubmission::pending()->count();
                    @endphp
                    @if($pendingSubmissionsCount > 0)
                        <span class="px-2 py-0.5 text-[10px] font-extrabold bg-amber-500 text-white rounded-full shadow-sm">{{ $pendingSubmissionsCount }}</span>
                    @endif
                </a>

                <a href="{{ route('admin.galleries.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg transition {{ request()->routeIs('admin.galleries.*') ? 'bg-red-700 text-white font-semibold shadow-md' : 'text-slate-400 hover:text-white hover:bg-slate-800' }}">
                    <i class="fa-solid fa-images w-5 text-center text-amber-400"></i>
                    <span>Galeri & Dokumentasi</span>
                </a>

                <a href="{{ route('admin.testimonials.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg transition {{ request()->routeIs('admin.testimonials.*') ? 'bg-red-700 text-white font-semibold shadow-md' : 'text-slate-400 hover:text-white hover:bg-slate-800' }}">
                    <i class="fa-solid fa-comments w-5 text-center text-yellow-400"></i>
                    <span>Testimoni Guru</span>
                </a>

                <a href="{{ route('admin.messages.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg transition {{ request()->routeIs('admin.messages.*') ? 'bg-red-700 text-white font-semibold shadow-md' : 'text-slate-400 hover:text-white hover:bg-slate-800' }}">
                    <i class="fa-solid fa-envelope-open-text w-5 text-center text-rose-400"></i>
                    <span>Pesan & Aspirasi</span>
                </a>

                <a href="{{ route('admin.contact-settings') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg transition {{ request()->routeIs('admin.contact-settings*') ? 'bg-red-700 text-white font-semibold shadow-md' : 'text-slate-400 hover:text-white hover:bg-slate-800' }}">
                    <i class="fa-solid fa-address-book w-5 text-center text-teal-400"></i>
                    <span>Kontak & Sekretariat</span>
                </a>

                @if(Auth::check() && Auth::user()->role === 'admin')
                    <a href="{{ route('admin.users.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg transition {{ request()->routeIs('admin.users.*') ? 'bg-red-700 text-white font-semibold shadow-md' : 'text-slate-400 hover:text-white hover:bg-slate-800' }}">
                        <i class="fa-solid fa-users-gear w-5 text-center text-purple-400"></i>
                        <span>Kelola Akun</span>
                    </a>
                @endif
            </nav>
        </div>

        <div class="p-4 border-t border-slate-800 space-y-2">
            <a href="{{ route('home') }}" target="_blank" class="flex items-center gap-2 text-xs font-semibold text-slate-300 hover:text-emerald-400 py-1.5 px-3 rounded hover:bg-slate-800 transition">
                <i class="fa-solid fa-arrow-up-right-from-square"></i>
                <span>Lihat Website Utama</span>
            </a>
            <form action="{{ route('admin.logout') }}" method="POST">
                @csrf
                <button type="submit" class="w-full flex items-center gap-2 text-xs font-semibold text-red-400 hover:text-red-300 py-2 px-3 rounded hover:bg-red-950/40 transition">
                    <i class="fa-solid fa-right-from-bracket"></i>
                    <span>Keluar (Logout)</span>
                </button>
            </form>
        </div>
    </aside>

    <!-- Main Content Area -->
    <div class="flex-1 flex flex-col min-w-0 min-h-screen">
        <!-- Top Navbar -->
        <header class="bg-white border-b border-slate-200 px-6 py-4 flex items-center justify-between shadow-sm">
            <div>
                <h2 class="text-xl font-bold text-slate-800">@yield('page_title', 'Dashboard')</h2>
                <p class="text-xs text-emerald-700 font-semibold">Persatuan Guru Republik Indonesia</p>
            </div>
            <div class="flex items-center gap-3">
                <div class="text-right hidden sm:block">
                    <div class="flex items-center justify-end gap-1.5">
                        <span class="text-sm font-bold text-slate-800">{{ Auth::user()->name ?? 'Administrator' }}</span>
                        @if(Auth::check())
                            <span class="text-[10px] font-extrabold uppercase px-1.5 py-0.5 rounded border 
                                @if(Auth::user()->role === 'admin') bg-red-100 text-red-700 border-red-200
                                @elseif(Auth::user()->role === 'pengurus') bg-sky-100 text-sky-700 border-sky-200
                                @else bg-emerald-100 text-emerald-700 border-emerald-200 @endif">
                                {{ Auth::user()->role_label }}
                            </span>
                        @endif
                    </div>
                    <p class="text-xs text-slate-400">{{ Auth::user()->email ?? 'admin@pgri.or.id' }}</p>
                </div>
                <div class="w-10 h-10 rounded-full bg-slate-900 border-2 border-red-600 text-white flex items-center justify-center font-bold text-sm shadow">
                    <i class="fa-solid fa-user-shield text-amber-400"></i>
                </div>
            </div>
        </header>

        <!-- Dynamic Body Content -->
        <main class="flex-1 p-6 max-w-7xl w-full mx-auto">
            @if(session('success'))
                <div class="mb-6 p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 flex items-center gap-3 shadow-sm">
                    <i class="fa-solid fa-circle-check text-emerald-600 text-lg"></i>
                    <p class="text-sm font-medium">{{ session('success') }}</p>
                </div>
            @endif

            @if(session('error'))
                <div class="mb-6 p-4 rounded-xl bg-red-50 border border-red-200 text-red-800 flex items-center gap-3 shadow-sm">
                    <i class="fa-solid fa-triangle-exclamation text-red-600 text-lg"></i>
                    <p class="text-sm font-medium">{{ session('error') }}</p>
                </div>
            @endif

            @yield('content')
        </main>
    </div>

</body>
</html>
