@extends('layouts.app')

@section('title', 'PGRI - Persatuan Guru Republik Indonesia & SAKTI')

@section('content')

<!-- FULL-WIDTH HERO SLIDER BACKGROUND (OPSI B) -->
@php
    $rawSlides = \App\Models\Setting::get('hero_slides');
    if (!empty($rawSlides)) {
        $heroSlides = json_decode($rawSlides, true) ?: [];
    } else {
        $singleHero = \App\Models\Setting::get('hero_image', '/storage/hero/hero_1790667887_WBKNbozY.jpeg');
        $heroSlides = [
            $singleHero,
            'https://images.unsplash.com/photo-1524178232363-1fb2b075b655?auto=format&fit=crop&w=1600&q=80',
            'https://images.unsplash.com/photo-1509062522246-3755977927d7?auto=format&fit=crop&w=1600&q=80',
        ];
    }
@endphp

<section class="position-relative overflow-hidden text-white hero-slider-section d-flex align-items-center" style="min-height: 600px; background-color: #0f172a;">
    <!-- Background Carousel Slider -->
    <div id="heroBgCarousel" class="carousel slide carousel-fade position-absolute top-0 start-0 w-100 h-100 z-0" data-bs-ride="carousel" data-bs-interval="4500" data-bs-pause="false">
        @if(count($heroSlides) > 1)
        <!-- Indicators / Dots -->
        <div class="carousel-indicators z-3 mb-4">
            @foreach($heroSlides as $idx => $slide)
            <button type="button" data-bs-target="#heroBgCarousel" data-bs-slide-to="{{ $idx }}" class="{{ $idx === 0 ? 'active' : '' }}" aria-current="{{ $idx === 0 ? 'true' : 'false' }}" aria-label="Slide {{ $idx + 1 }}" style="width: 32px; height: 4px; border-radius: 2px;"></button>
            @endforeach
        </div>
        @endif

        <div class="carousel-inner w-100 h-100">
            @foreach($heroSlides as $idx => $slideImg)
            <div class="carousel-item w-100 h-100 {{ $idx === 0 ? 'active' : '' }}" style="transition: transform 1.2s ease-in-out, opacity 1.2s ease-in-out;">
                <img src="{{ $slideImg }}" class="d-block w-100 h-100 object-fit-cover" alt="PGRI Banner Slide {{ $idx + 1 }}" style="min-height: 600px; filter: brightness(0.92);">
            </div>
            @endforeach
        </div>

        @if(count($heroSlides) > 1)
        <!-- Prev / Next Controls (Glassmorphic) -->
        <button class="carousel-control-prev z-3 d-none d-md-flex align-items-center justify-content-center" type="button" data-bs-target="#heroBgCarousel" data-bs-slide="prev" style="width: 48px; height: 48px; top: 50%; transform: translateY(-50%); left: 24px; border-radius: 50%; background: rgba(15, 23, 42, 0.5); backdrop-filter: blur(8px); border: 1px solid rgba(255, 255, 255, 0.2);">
            <i class="fa-solid fa-chevron-left text-white fs-5"></i>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next z-3 d-none d-md-flex align-items-center justify-content-center" type="button" data-bs-target="#heroBgCarousel" data-bs-slide="next" style="width: 48px; height: 48px; top: 50%; transform: translateY(-50%); right: 24px; border-radius: 50%; background: rgba(15, 23, 42, 0.5); backdrop-filter: blur(8px); border: 1px solid rgba(255, 255, 255, 0.2);">
            <i class="fa-solid fa-chevron-right text-white fs-5"></i>
            <span class="visually-hidden">Next</span>
        </button>
        @endif
    </div>

    <!-- Gradient Vignette & Dark Overlay for Optimal Readability -->
    <div class="position-absolute top-0 start-0 w-100 h-100 z-1" style="background: linear-gradient(90deg, rgba(15, 23, 42, 0.94) 0%, rgba(15, 23, 42, 0.85) 45%, rgba(153, 27, 27, 0.50) 80%, rgba(15, 23, 42, 0.78) 100%), radial-gradient(circle at 80% 20%, rgba(220, 38, 38, 0.25) 0%, transparent 60%); pointer-events: none;"></div>

    <!-- Tri-color PGRI accent bar on bottom -->
    <div class="position-absolute bottom-0 start-0 w-100 z-2 pgri-accent-stripe" style="height: 4px;"></div>

    <!-- Foreground Content -->
    <div class="container position-relative z-2 py-5 my-lg-2">
        <div class="row align-items-center g-5">
            <!-- Left Column: Typography & Action -->
            <div class="col-lg-7">
                <!-- Badge Pill -->
                <div class="d-inline-flex align-items-center gap-2 px-3 py-1.5 rounded-pill mb-3 shadow-sm border border-warning border-opacity-40" style="background: rgba(245, 158, 11, 0.15); backdrop-filter: blur(8px);">
                    <i class="fa-solid fa-fire text-warning"></i>
                    <span class="small fw-bold text-warning">{{ \App\Models\Setting::get('hero_badge', 'Platform Transformasi Edukasi & Profesi Guru') }}</span>
                </div>

                <h1 class="display-4 fw-black text-white tracking-tight mb-3 leading-tight" style="font-weight: 800; letter-spacing: -1px; text-shadow: 0 3px 14px rgba(0,0,0,0.6);">
                    {!! \App\Models\Setting::get('hero_title', 'Mewujudkan Guru <span class="text-danger">Profesional</span>, <span class="text-success" style="color: #4ade80 !important;">Sejahtera</span> & <span class="text-warning" style="color: #facc15 !important;">Melek AI</span>') !!}
                </h1>

                <p class="lead text-white text-opacity-90 mb-4 fs-6 leading-relaxed" style="max-width: 620px; text-shadow: 0 2px 8px rgba(0,0,0,0.5);">
                    {{ \App\Models\Setting::get('hero_description', 'Persatuan Guru Republik Indonesia (PGRI) mengabdi sejak 1945. Bersama ekosistem SAKTI PGRI, kami mendorong pembelajaran mendalam, repositori perangkat ajar, serta kemampuan Koding, KKA & AI bagi seluruh pendidik Indonesia.') }}
                </p>

                <!-- Action Buttons -->
                <div class="d-flex flex-wrap align-items-center gap-3 mb-4">
                    <a href="{{ \App\Models\Setting::get('hero_btn1_url', route('sakti.index')) }}" class="btn text-white fw-bold px-4 py-2.5 rounded-pill shadow-lg d-inline-flex align-items-center gap-2 text-decoration-none" style="background: linear-gradient(135deg, #dc2626 0%, #b91c1c 100%); border: 1px solid rgba(255,255,255,0.25);">
                        <i class="fa-solid fa-wand-magic-sparkles text-warning"></i> 
                        <span>{{ \App\Models\Setting::get('hero_btn1_text', 'Jelajahi SAKTI PGRI') }}</span>
                    </a>
                    <a href="{{ \App\Models\Setting::get('hero_btn2_url', route('profile')) }}" class="btn text-white fw-bold px-4 py-2.5 rounded-pill shadow-sm d-inline-flex align-items-center gap-2 text-decoration-none" style="background: rgba(255, 255, 255, 0.14); backdrop-filter: blur(10px); border: 1px solid rgba(255, 255, 255, 0.25);">
                        <i class="fa-solid fa-landmark text-emerald-400"></i> 
                        <span>{{ \App\Models\Setting::get('hero_btn2_text', 'Profil & Sejarah') }}</span>
                    </a>
                </div>

                <!-- Social Proof / Avatar Trust -->
                <div class="d-flex align-items-center gap-3 pt-2">
                    <div class="d-flex align-items-center">
                        <img src="https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?auto=format&fit=crop&w=100&q=80" alt="Guru 1" class="rounded-circle border border-2 border-white shadow-sm" style="width: 40px; height: 40px; margin-right: -10px; object-fit: cover;">
                        <img src="https://images.unsplash.com/photo-1560250097-0b93528c311a?auto=format&fit=crop&w=100&q=80" alt="Guru 2" class="rounded-circle border border-2 border-white shadow-sm" style="width: 40px; height: 40px; margin-right: -10px; object-fit: cover;">
                        <img src="https://images.unsplash.com/photo-1580894732413-847fecb439c2?auto=format&fit=crop&w=100&q=80" alt="Guru 3" class="rounded-circle border border-2 border-white shadow-sm" style="width: 40px; height: 40px; margin-right: -10px; object-fit: cover;">
                        <div class="rounded-circle bg-danger text-white border border-2 border-white shadow-sm d-flex align-items-center justify-content-center fw-bold extra-small" style="width: 40px; height: 40px; font-size: 0.7rem;">
                            {{ \App\Models\Setting::get('hero_stat_number', '3.4M+') }}
                        </div>
                    </div>
                    <div>
                        <div class="d-flex text-warning fs-6">
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                        </div>
                        <div class="small fw-semibold text-white text-opacity-80" style="font-size: 0.8rem;">{{ \App\Models\Setting::get('hero_stat_label', 'Guru & Tenaga Kependidikan Terhubung') }}</div>
                    </div>
                </div>
            </div>

            <!-- Right Column: Glassmorphic Feature Showcase Card -->
            <div class="col-lg-5">
                <div class="p-4 p-md-4 rounded-4 shadow-2xl border" style="background: rgba(15, 23, 42, 0.45); backdrop-filter: blur(16px); -webkit-backdrop-filter: blur(16px); border-color: rgba(255, 255, 255, 0.20); box-shadow: 0 20px 50px rgba(0,0,0,0.5);">
                    <div class="d-flex align-items-center justify-content-between mb-3 pb-2 border-bottom border-white border-opacity-15">
                        <div class="d-flex align-items-center gap-2">
                            <span class="badge bg-danger rounded-pill px-2.5 py-1 text-white fw-bold small"><i class="fa-solid fa-bolt text-warning me-1"></i> SAKTI PGRI</span>
                            <span class="small text-white text-opacity-85 fw-semibold">Ekosistem Edukasi</span>
                        </div>
                        <span class="badge bg-warning text-dark rounded-pill fw-bold small px-2.5 py-1">4 Pilar Utama</span>
                    </div>

                    <p class="small text-white text-opacity-85 mb-4 leading-relaxed">Platform terpadu mempersiapkan pendidik Indonesia unggul dalam kecerdasan buatan, repositori ajar digital, dan advokasi profesi.</p>

                    <!-- Stat 1 -->
                    <div class="d-flex align-items-center gap-3 p-3 rounded-3 mb-3" style="background: rgba(255, 255, 255, 0.08); border: 1px solid rgba(255, 255, 255, 0.15);">
                        <div class="rounded-circle p-2.5 d-flex align-items-center justify-content-center text-emerald-400 flex-shrink-0" style="width: 46px; height: 46px; background: rgba(16, 185, 129, 0.25);">
                            <i class="fa-solid fa-circle-check fs-5"></i>
                        </div>
                        <div>
                            <div class="fw-bold text-white fs-6">{{ \App\Models\Setting::get('hero_card1_title', '500+ Modul SAKTI') }}</div>
                            <div class="text-white text-opacity-70 small">{{ \App\Models\Setting::get('hero_card1_subtitle', 'Deep Learning, Koding & AI') }}</div>
                        </div>
                    </div>

                    <!-- Stat 2 -->
                    <div class="d-flex align-items-center gap-3 p-3 rounded-3" style="background: rgba(255, 255, 255, 0.08); border: 1px solid rgba(255, 255, 255, 0.15);">
                        <div class="rounded-circle p-2.5 d-flex align-items-center justify-content-center flex-shrink-0" style="width: 46px; height: 46px; color: #c084fc; background: rgba(168, 85, 247, 0.25);">
                            <i class="fa-solid fa-code fs-5"></i>
                        </div>
                        <div>
                            <div class="fw-bold text-white fs-6">{{ \App\Models\Setting::get('hero_card2_title', 'Pelatihan Koding & AI') }}</div>
                            <div class="text-white text-opacity-70 small">{{ \App\Models\Setting::get('hero_card2_subtitle', 'Berpikir Komputasional Guru') }}</div>
                        </div>
                    </div>

                    @auth
                        @if(Auth::user()->role === 'admin' || Auth::user()->role === 'pengurus')
                        <div class="mt-4 pt-3 border-top border-white border-opacity-15 text-center">
                            <a href="{{ route('admin.hero-settings') }}" class="btn btn-sm btn-warning text-dark fw-bold rounded-pill px-3 py-1.5 shadow-sm text-decoration-none d-inline-flex align-items-center gap-1.5">
                                <i class="fa-solid fa-images"></i>
                                <span>Kelola Foto Slider Banner</span>
                            </a>
                        </div>
                        @endif
                    @endauth
                </div>
            </div>
        </div>
    </div>
</section>


<!-- INTERACTIVE 4 PILAR SAKTI SHOWCASE (ScrewFast Tabbed) -->
<section class="py-6 my-4">
    <div class="container">
        <div class="text-center max-w-3xl mx-auto mb-5">
            <div class="badge-screw bg-amber-500 bg-opacity-10 text-warning border border-warning border-opacity-20 mb-2" style="color:#d97706 !important;">
                <i class="fa-solid fa-wand-magic-sparkles"></i> 4 Pilar Utama Platform SAKTI
            </div>
            <h2 class="display-6 fw-extrabold text-dark tracking-tight">Ekosistem Layanan Guru Modern</h2>
            <p class="text-muted">Akses modul pembelajaran mendalam, repositori bahan ajar, informasi publik, dan kelas koding/AI.</p>
        </div>

        <!-- Pill Tabs Navigation -->
        <div class="text-center mb-4">
            <div class="pill-tab" role="tablist">
                <button class="pill-tab-btn active" id="tab-deep-btn" data-bs-toggle="pill" data-bs-target="#tab-deep" type="button">
                    <i class="fa-solid fa-brain me-1 text-info"></i> Pembelajaran Mendalam
                </button>
                <button class="pill-tab-btn" id="tab-rumah-btn" data-bs-toggle="pill" data-bs-target="#tab-rumah" type="button">
                    <i class="fa-solid fa-folder-open me-1 text-success"></i> Rumah Pendidikan
                </button>
                <button class="pill-tab-btn" id="tab-pid-btn" data-bs-toggle="pill" data-bs-target="#tab-pid" type="button">
                    <i class="fa-solid fa-bullhorn me-1 text-warning"></i> PID (Pusat Informasi)
                </button>
                <button class="pill-tab-btn" id="tab-koding-btn" data-bs-toggle="pill" data-bs-target="#tab-koding" type="button">
                    <i class="fa-solid fa-code me-1" style="color:#c084fc;"></i> Koding & AI (KKA)
                </button>
            </div>
        </div>

        <!-- Tab Content Panels -->
        <div class="tab-content">
            <!-- TAB 1: Pembelajaran Mendalam -->
            <div class="tab-pane fade show active" id="tab-deep">
                <div class="row g-4">
                    @forelse($deepLearning as $item)
                        <div class="col-md-4">
                            <div class="screw-card h-100 p-4 d-flex flex-column justify-content-between">
                                <div>
                                    <div class="d-flex align-items-center justify-content-between mb-3">
                                        <span class="badge-screw badge-sakti-deep">Deep Learning</span>
                                        <span class="small text-muted"><i class="fa-solid fa-eye"></i> {{ $item->views }}</span>
                                    </div>
                                    <h5 class="fw-bold text-dark mb-2">{{ $item->title }}</h5>
                                    <p class="small text-secondary line-clamp-2 mb-3">{{ $item->summary }}</p>
                                </div>
                                <div class="pt-3 border-top border-slate-100 d-flex align-items-center justify-content-between">
                                    <span class="small text-muted"><i class="fa-regular fa-calendar"></i> {{ $item->created_at ? $item->created_at->format('d M Y') : 'Terbaru' }}</span>
                                    <a href="{{ route('sakti.show', $item->slug) }}" class="btn btn-outline-info btn-sm rounded-pill font-bold">Detail &rarr;</a>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-12 text-center py-5 text-muted">Belum ada modul Pembelajaran Mendalam.</div>
                    @endforelse
                </div>
            </div>

            <!-- TAB 2: Rumah Pendidikan -->
            <div class="tab-pane fade" id="tab-rumah">
                <div class="row g-4">
                    @forelse($rumahPendidikan as $item)
                        <div class="col-md-4">
                            <div class="screw-card h-100 p-4 d-flex flex-column justify-content-between">
                                <div>
                                    <div class="d-flex align-items-center justify-content-between mb-3">
                                        <span class="badge-screw badge-sakti-rumah">Rumah Pendidikan</span>
                                        <span class="small text-muted"><i class="fa-solid fa-eye"></i> {{ $item->views }}</span>
                                    </div>
                                    <h5 class="fw-bold text-dark mb-2">{{ $item->title }}</h5>
                                    <p class="small text-secondary line-clamp-2 mb-3">{{ $item->summary }}</p>
                                </div>
                                <div class="pt-3 border-top border-slate-100 d-flex align-items-center justify-content-between">
                                    <span class="small text-muted"><i class="fa-regular fa-calendar"></i> {{ $item->created_at ? $item->created_at->format('d M Y') : 'Terbaru' }}</span>
                                    <a href="{{ route('sakti.show', $item->slug) }}" class="btn btn-outline-success btn-sm rounded-pill font-bold">Detail &rarr;</a>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-12 text-center py-5 text-muted">Belum ada modul Rumah Pendidikan.</div>
                    @endforelse
                </div>
            </div>

            <!-- TAB 3: PID -->
            <div class="tab-pane fade" id="tab-pid">
                <div class="row g-4">
                    @forelse($latestPid as $item)
                        <div class="col-md-4">
                            <div class="screw-card h-100 p-4 d-flex flex-column justify-content-between">
                                <div>
                                    <div class="d-flex align-items-center justify-content-between mb-3">
                                        <span class="badge-screw badge-sakti-pid">PID Informatif</span>
                                        <span class="small text-muted"><i class="fa-solid fa-eye"></i> {{ $item->views }}</span>
                                    </div>
                                    <h5 class="fw-bold text-dark mb-2">{{ $item->title }}</h5>
                                    <p class="small text-secondary line-clamp-2 mb-3">{{ $item->summary }}</p>
                                </div>
                                <div class="pt-3 border-top border-slate-100 d-flex align-items-center justify-content-between">
                                    <span class="small text-muted"><i class="fa-regular fa-calendar"></i> {{ $item->created_at ? $item->created_at->format('d M Y') : 'Terbaru' }}</span>
                                    <a href="{{ route('sakti.show', $item->slug) }}" class="btn btn-outline-warning text-dark btn-sm rounded-pill font-bold">Detail &rarr;</a>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-12 text-center py-5 text-muted">Belum ada informasi PID.</div>
                    @endforelse
                </div>
            </div>

            <!-- TAB 4: Koding & AI -->
            <div class="tab-pane fade" id="tab-koding">
                <div class="row g-4">
                    @forelse($latestKoding as $item)
                        <div class="col-md-4">
                            <div class="screw-card h-100 p-4 d-flex flex-column justify-content-between">
                                <div>
                                    <div class="d-flex align-items-center justify-content-between mb-3">
                                        <span class="badge-screw badge-sakti-koding">Koding / KKA & AI</span>
                                        <span class="small text-muted"><i class="fa-solid fa-eye"></i> {{ $item->views }}</span>
                                    </div>
                                    <h5 class="fw-bold text-dark mb-2">{{ $item->title }}</h5>
                                    <p class="small text-secondary line-clamp-2 mb-3">{{ $item->summary }}</p>
                                </div>
                                <div class="pt-3 border-top border-slate-100 d-flex align-items-center justify-content-between">
                                    <span class="small text-muted"><i class="fa-regular fa-calendar"></i> {{ $item->created_at ? $item->created_at->format('d M Y') : 'Terbaru' }}</span>
                                    @if($item->file_url)
                                        <a href="{{ $item->file_url }}" target="_blank" rel="noopener noreferrer" class="btn btn-sm rounded-pill font-bold text-white px-3" style="background-color:#9333ea;">
                                            <i class="fa-solid fa-arrow-up-right-from-square me-1"></i> Buka Modul
                                        </a>
                                    @else
                                        <a href="{{ route('sakti.show', $item->slug) }}" class="btn btn-outline-primary btn-sm rounded-pill font-bold" style="border-color:#9333ea; color:#9333ea;">Detail &rarr;</a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-12 text-center py-5 text-muted">Belum ada modul Koding/KKA.</div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</section>



<!-- BERITA & REPORTASE TERKINI -->
<section class="py-6 my-4 bg-slate-50 border-top border-bottom">
    <div class="container">
        <div class="d-flex flex-column flex-md-row align-items-md-end justify-content-between mb-5 gap-3">
            <div>
                <span class="badge-screw bg-danger bg-opacity-10 text-danger border border-danger border-opacity-20 mb-2">
                    <i class="fa-solid fa-newspaper text-danger"></i> Kabar & Dokumentasi
                </span>
                <h2 class="display-6 fw-extrabold text-dark tracking-tight mb-0">Berita & Reportase Kegiatan</h2>
            </div>
            <a href="{{ route('news.index') }}" class="btn btn-outline-danger rounded-pill fw-bold px-4">
                Lihat Semua Berita <i class="fa-solid fa-arrow-right ms-1"></i>
            </a>
        </div>

        <div class="row g-4">
            @forelse($latestNews as $item)
                <div class="col-md-4">
                    <div class="card h-100 border-0 rounded-4 shadow-sm overflow-hidden bg-white d-flex flex-column justify-content-between hover-card transition">
                        <div>
                            <a href="{{ route('news.show', $item->slug) }}" class="d-block overflow-hidden position-relative" style="height: 200px;">
                                <img src="{{ $item->image ?? 'https://images.unsplash.com/photo-1517245386807-bb43f82c33c4?auto=format&fit=crop&w=600&q=80' }}" 
                                     alt="{{ $item->title }}" class="w-100 h-100 object-fit-cover transition transform hover-scale">
                                <div class="position-absolute top-0 end-0 m-3">
                                    <span class="badge bg-dark bg-opacity-75 rounded-pill px-2.5 py-1 extra-small text-white backdrop-blur">
                                        <i class="fa-regular fa-eye me-1"></i> {{ $item->views_count }}
                                    </span>
                                </div>
                            </a>
                            <div class="p-4">
                                <div class="text-danger extra-small fw-bold mb-2">
                                    <i class="fa-regular fa-calendar me-1"></i> {{ \Carbon\Carbon::parse($item->published_at)->translatedFormat('d M Y') }}
                                </div>
                                <h5 class="fw-bold text-dark mb-2 line-clamp-2">
                                    <a href="{{ route('news.show', $item->slug) }}" class="text-dark text-decoration-none hover-danger">
                                        {{ $item->title }}
                                    </a>
                                </h5>
                                <p class="text-secondary small line-clamp-2 mb-0">
                                    {{ $item->excerpt }}
                                </p>
                            </div>
                        </div>
                        <div class="px-4 pb-4 pt-3 border-top d-flex align-items-center justify-content-between">
                            <span class="extra-small text-muted text-truncate fw-semibold" style="max-width: 180px;">
                                <i class="fa-solid fa-user-pen me-1"></i> {{ $item->author }}
                            </span>
                            <a href="{{ route('news.show', $item->slug) }}" class="btn btn-sm btn-link text-danger fw-bold text-decoration-none p-0">
                                Baca <i class="fa-solid fa-chevron-right ms-1"></i>
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center py-5 text-muted">Belum ada berita kegiatan.</div>
            @endforelse
        </div>
    </div>
</section>

<!-- LEADERSHIP & PENGURUS SHOWCASE -->
<section class="py-6 my-4">
    <div class="container">
        <div class="d-flex flex-column flex-md-row align-items-md-end justify-content-between mb-5 gap-3">
            <div>
                <span class="badge-screw bg-danger bg-opacity-10 text-danger border border-danger border-opacity-20 mb-2">
                    <i class="fa-solid fa-users"></i> Struktur Kepemimpinan
                </span>
                <h2 class="display-6 fw-extrabold text-dark tracking-tight mb-0">Pengurus PGRI Cabang Ciamis</h2>
            </div>
            <a href="{{ route('profile') }}" class="btn btn-outline-dark rounded-pill fw-bold px-4">Lihat Seluruh Pengurus &rarr;</a>
        </div>

        <div class="row g-4">
            @forelse($executives as $person)
                <div class="col-md-3 col-sm-6">
                    <div class="screw-card p-4 text-center h-100 d-flex flex-column justify-content-between">
                        <div>
                            <div class="mb-3 position-relative d-inline-block">
                                <img src="{{ $person->photo ?? 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&w=300&q=80' }}" alt="{{ $person->name }}" class="rounded-circle object-fit-cover shadow-sm border border-3 border-white" style="width: 110px; height: 110px;">
                                <span class="position-absolute bottom-0 end-0 bg-danger text-white rounded-circle p-1.5 fs-6 shadow-sm border border-2 border-white d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                                    <i class="fa-solid fa-user-tie" style="font-size: 0.75rem;"></i>
                                </span>
                            </div>
                            <h5 class="fw-bold text-dark mb-1 fs-6">{{ $person->name }}</h5>
                            <div class="text-danger fw-bold extra-small uppercase mb-2" style="font-size: 0.75rem;">{{ $person->position }}</div>
                            @if(!empty($person->bio) && $person->bio !== 'Pengurus Organisasi PB PGRI.')
                                <p class="small text-muted line-clamp-2 mb-0">{{ $person->bio }}</p>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center py-5 text-muted">Belum ada data pengurus.</div>
            @endforelse
        </div>
    </div>
</section>

<!-- TESTIMONIAL & ASPIRASI GRID -->
<section id="suara-guru" class="py-6 bg-slate-100 border-top border-bottom">
    <div class="container">
        <div class="text-center max-w-3xl mx-auto mb-5">
            <span class="badge-screw bg-warning bg-opacity-10 text-warning border border-warning border-opacity-20 mb-2" style="color:#d97706 !important;">
                <i class="fa-solid fa-quote-left"></i> Suara Guru Indonesia
            </span>
            <h2 class="display-6 fw-extrabold text-dark tracking-tight">Kisah Dampak PGRI & SAKTI</h2>
            <p class="text-muted">Testimoni nyata pendidik yang merasakan manfaat advokasi dan pelatihan digital.</p>
        </div>

        <div class="row g-4">
            @forelse($testimonials as $testi)
                <div class="col-md-4">
                    <div class="screw-card p-4 h-100 d-flex flex-column justify-content-between">
                        <div>
                            <div class="text-warning mb-3">
                                @for($i = 1; $i <= 5; $i++)
                                    <i class="fa-solid fa-star {{ $i <= $testi->rating ? '' : 'text-slate-200' }}"></i>
                                @endfor
                            </div>
                            <p class="text-secondary italic mb-4">"{{ $testi->quote }}"</p>
                        </div>
                        <div class="d-flex align-items-center gap-3 pt-3 border-top">
                            <img src="{{ $testi->photo }}" alt="{{ $testi->name }}" class="rounded-circle object-fit-cover" style="width: 44px; height: 44px;">
                            <div>
                                <div class="fw-bold text-dark small">{{ $testi->name }}</div>
                                <div class="extra-small text-muted">{{ $testi->role_origin }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center py-5 text-muted">Belum ada testimoni guru.</div>
            @endforelse
        </div>
    </div>
</section>

<!-- FAQ ACCORDION SECTION -->
<section class="py-6 my-4">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="text-center mb-5">
                    <span class="badge-screw bg-info bg-opacity-10 text-info border border-info border-opacity-20 mb-2">
                        <i class="fa-solid fa-circle-question"></i> Tanya Jawab Umum
                    </span>
                    <h2 class="display-6 fw-extrabold text-dark tracking-tight">Pertanyaan Sering Diajukan (FAQ)</h2>
                </div>

                <div class="accordion custom-accordion" id="faqAccordion">
                    <div class="accordion-item border rounded-3 mb-3 overflow-hidden shadow-sm">
                        <h2 class="accordion-header">
                            <button class="accordion-button fw-bold text-dark" type="button" data-bs-toggle="collapse" data-bs-target="#faq1">
                                Bagaimana cara bergabung menjadi anggota PGRI?
                            </button>
                        </h2>
                        <div id="faq1" class="accordion-collapse collapse show" data-bs-parent="#faqAccordion">
                            <div class="accordion-body text-secondary small leading-relaxed">
                                Guru dan tenaga kependidikan dapat mendaftar melalui Pengurus Ranting atau Cabang PGRI terdekat di kota/kabupaten masing-masing, atau menghubungi sekretariat untuk pembuatan Kartu Tanda Anggota (KTA) Digital.
                            </div>
                        </div>
                    </div>

                    <div class="accordion-item border rounded-3 mb-3 overflow-hidden shadow-sm">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed fw-bold text-dark" type="button" data-bs-toggle="collapse" data-bs-target="#faq2">
                                Apakah platform SAKTI PGRI gratis diakses oleh guru?
                            </button>
                        </h2>
                        <div id="faq2" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                            <div class="accordion-body text-secondary small leading-relaxed">
                                Ya! Seluruh modul Pembelajaran Mendalam, Rumah Pendidikan, Berita PID, serta pelatihan awal Koding/KKA & AI dapat diakses secara gratis oleh seluruh guru dan pendidik di Indonesia.
                            </div>
                        </div>
                    </div>

                    <div class="accordion-item border rounded-3 mb-3 overflow-hidden shadow-sm">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed fw-bold text-dark" type="button" data-bs-toggle="collapse" data-bs-target="#faq3">
                                Bagaimana jika guru menghadapi kendala hukum saat bertugas?
                            </button>
                        </h2>
                        <div id="faq3" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                            <div class="accordion-body text-secondary small leading-relaxed">
                                Anggota PGRI dapat mengajukan permohonan advokasi melalui pengurus cabang terdekat atau melalui menu Kontak Aspirasi pada portal ini untuk langsung ditangani oleh Lembaga Konsultasi dan Bantuan Hukum (LKBH) PGRI.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- HIGH CONTRAST CTA BANNER -->
<section class="py-6 my-4">
    <div class="container">
        <div class="p-5 p-md-6 rounded-4 text-white shadow-2xl position-relative overflow-hidden" style="background: linear-gradient(135deg, #090d16 0%, #0f172a 40%, #14532d 75%, #7f1d1d 100%); border: 1px solid rgba(255,255,255,0.1);">
            <div class="row align-items-center g-4 position-relative" style="z-index: 2;">
                <div class="col-lg-8">
                    <div class="d-inline-flex align-items-center gap-2 px-3 py-1 rounded-pill bg-white bg-opacity-10 border border-white border-opacity-20 mb-3 text-warning text-xs font-bold uppercase tracking-wider">
                        <i class="fa-solid fa-graduation-cap text-warning me-1"></i>
                        <span>Transformasi Pendidikan Indonesia</span>
                    </div>
                    <h2 class="display-5 fw-extrabold text-white mb-3">Siap Bertransformasi Bersama PGRI & SAKTI?</h2>
                    <p class="text-slate-300 fs-6 leading-relaxed mb-0">
                        Bergabunglah dengan jutaan guru Indonesia yang telah memanfaatkan platform SAKTI untuk meningkatkan kualitas mengajar, penguasaan Koding & AI, serta perlindungan profesi.
                    </p>
                </div>
                <div class="col-lg-4 text-lg-end">
                    <div class="d-flex flex-column flex-sm-row flex-lg-column gap-3 justify-content-lg-end">
                        <a href="{{ route('sakti.index') }}" class="btn-screw-gold text-decoration-none text-center">
                            <i class="fa-solid fa-rocket me-2"></i> Mulai Belajar di SAKTI
                        </a>
                        <a href="{{ route('contact.index') }}" class="btn btn-outline-light font-bold rounded-3 py-3 px-4 text-center fw-bold">
                            <i class="fa-solid fa-paper-plane me-2"></i> Hubungi PGRI
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
