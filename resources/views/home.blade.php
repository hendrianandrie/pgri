@extends('layouts.app')

@section('title', 'PGRI - Persatuan Guru Republik Indonesia & SAKTI')

@section('content')

<!-- HERO SECTION (ScrewFast Style) -->
<section class="screw-hero py-5 py-lg-6 border-bottom">
    <div class="container py-4">
        <div class="row align-items-center g-5">
            <div class="col-lg-6">
                <!-- Badge Pill -->
                <div class="badge-screw bg-danger bg-opacity-10 text-danger border border-danger border-opacity-20 mb-3">
                    <i class="fa-solid fa-fire text-danger"></i>
                    <span>{{ \App\Models\Setting::get('hero_badge', 'Platform Transformasi Edukasi & Profesi Guru') }}</span>
                </div>

                <h1 class="display-4 fw-black text-dark tracking-tight mb-3 leading-tight" style="font-weight: 800; letter-spacing: -1px;">
                    {!! \App\Models\Setting::get('hero_title', 'Mewujudkan Guru <span class="text-danger">Profesional</span>, <span class="text-success" style="color: #15803d !important;">Sejahtera</span> & <span class="text-warning" style="color: #d97706 !important;">Melek AI</span>') !!}
                </h1>

                <p class="lead text-secondary mb-4 fs-6 leading-relaxed">
                    {{ \App\Models\Setting::get('hero_description', 'Persatuan Guru Republik Indonesia (PGRI) mengabdi sejak 1945. Bersama ekosistem SAKTI PGRI, kami mendorong pembelajaran mendalam, repositori perangkat ajar, serta kemampuan Koding, KKA & AI bagi seluruh pendidik Indonesia.') }}
                </p>

                <!-- Action Buttons: Red & Green PGRI Palette -->
                <div class="d-flex flex-wrap align-items-center gap-3 mb-4">
                    <a href="{{ \App\Models\Setting::get('hero_btn1_url', route('sakti.index')) }}" class="btn-screw-primary text-decoration-none">
                        <i class="fa-solid fa-wand-magic-sparkles me-2"></i> {{ \App\Models\Setting::get('hero_btn1_text', 'Jelajahi SAKTI PGRI') }}
                    </a>
                    <a href="{{ \App\Models\Setting::get('hero_btn2_url', route('profile')) }}" class="btn-screw-green text-decoration-none">
                        <i class="fa-solid fa-landmark me-2"></i> {{ \App\Models\Setting::get('hero_btn2_text', 'Profil & Sejarah') }}
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
                        <div class="small fw-semibold text-muted" style="font-size: 0.8rem;">{{ \App\Models\Setting::get('hero_stat_label', 'Guru & Tenaga Kependidikan Terhubung') }}</div>
                    </div>
                </div>

            </div>

            <div class="col-lg-6 position-relative">
                <div class="position-relative">
                    <img src="{{ \App\Models\Setting::get('hero_image', 'https://images.unsplash.com/photo-1524178232363-1fb2b075b655?auto=format&fit=crop&w=800&q=80') }}" alt="PGRI SAKTI Teachers" class="img-fluid rounded-4 shadow-2xl border border-secondary border-opacity-10 w-100 object-fit-cover" style="min-height: 380px; max-height: 480px;">

                    <!-- Floating Glassmorphic Stat 1 (Top Right) -->
                    <div class="glass-floating p-3 position-absolute top-0 end-0 translate-middle-y me-2 mt-4 d-none d-sm-flex align-items-center gap-3">
                        <div class="rounded-circle bg-success bg-opacity-10 text-success p-2.5 d-flex align-items-center justify-content-center" style="width: 44px; height: 44px;">
                            <i class="fa-solid fa-circle-check fs-5"></i>
                        </div>
                        <div>
                            <div class="fw-extrabold text-dark fs-6">{{ \App\Models\Setting::get('hero_card1_title', '500+ Modul SAKTI') }}</div>
                            <div class="text-muted extra-small" style="font-size: 0.75rem;">{{ \App\Models\Setting::get('hero_card1_subtitle', 'Deep Learning, Koding & AI') }}</div>
                        </div>
                    </div>

                    <!-- Floating Glassmorphic Stat 2 (Bottom Left) -->
                    <div class="glass-floating p-3 position-absolute bottom-0 start-0 translate-middle-y ms-2 mb-2 d-none d-sm-flex align-items-center gap-3">
                        <div class="rounded-circle bg-purple bg-opacity-10 text-purple p-2.5 d-flex align-items-center justify-content-center" style="width: 44px; height: 44px; color:#9333ea; background-color:#f3e8ff;">
                            <i class="fa-solid fa-code fs-5"></i>
                        </div>
                        <div>
                            <div class="fw-extrabold text-dark fs-6">{{ \App\Models\Setting::get('hero_card2_title', 'Pelatihan Koding & AI') }}</div>
                            <div class="text-muted extra-small" style="font-size: 0.75rem;">{{ \App\Models\Setting::get('hero_card2_subtitle', 'Berpikir Komputasional Guru') }}</div>
                        </div>
                    </div>
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
