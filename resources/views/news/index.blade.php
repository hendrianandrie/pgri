@extends('layouts.app')

@section('title', 'Berita & Reportase Kegiatan - PGRI')

@section('content')
<div class="py-5 bg-slate-50 min-vh-100">

    <!-- PAGE HEADER HERO -->
    <div class="container mb-5">
        <div class="bg-dark rounded-4 p-4 p-md-5 text-white position-relative overflow-hidden shadow-lg" 
             style="background: linear-gradient(135deg, #0f172a 0%, #1e293b 50%, #991b1b 100%);">
            <div class="position-relative z-1 max-w-3xl">
                <span class="badge bg-danger rounded-pill px-3 py-1.5 font-bold mb-3 d-inline-flex align-items-center gap-1.5">
                    <i class="fa-solid fa-bullhorn"></i> Kabar & Dokumentasi Kegiatan
                </span>
                <h1 class="display-5 fw-extrabold tracking-tight mb-3">Berita & Reportase PGRI</h1>
                <p class="lead text-white-50 fs-6 mb-4">Informasi resmi, kabar advokasi perlindungan guru, dan liputan reportase kegiatan seputar PGRI.</p>

                <!-- Search Input -->
                <form action="{{ route('news.index') }}" method="GET" class="d-flex flex-wrap gap-2 max-w-xl">
                    <div class="input-group bg-white rounded-3 overflow-hidden shadow-sm flex-grow-1" style="max-width: 480px;">
                        <span class="input-group-text bg-white border-0 text-muted ps-3">
                            <i class="fa-solid fa-magnifying-glass"></i>
                        </span>
                        <input type="text" name="q" value="{{ $search }}" class="form-control border-0 py-2.5 text-dark" placeholder="Cari berita atau kegiatan...">
                        @if(!empty($search))
                            <a href="{{ route('news.index') }}" class="btn btn-link text-muted border-0 text-decoration-none px-2 d-flex align-items-center">
                                <i class="fa-solid fa-xmark"></i>
                            </a>
                        @endif
                    </div>
                    <button type="submit" class="btn btn-danger fw-bold px-4 py-2.5 rounded-3 shadow-sm">
                        Cari
                    </button>
                </form>
            </div>
        </div>
    </div>

    <div class="container">

        @if(!empty($search))
            <div class="d-flex align-items-center justify-content-between mb-4 pb-2 border-bottom">
                <h4 class="fw-bold text-dark mb-0">
                    Hasil Pencarian: <span class="text-danger">"{{ $search }}"</span>
                </h4>
                <a href="{{ route('news.index') }}" class="btn btn-outline-secondary btn-sm rounded-pill">
                    <i class="fa-solid fa-arrow-left me-1"></i> Tampilkan Semua
                </a>
            </div>
        @endif

        <!-- FEATURED / SPOTLIGHT NEWS (Only shown when not searching and available) -->
        @if(empty($search) && $featuredNews)
            <div class="mb-5">
                <div class="card border-0 rounded-4 shadow-sm overflow-hidden bg-white hover:shadow-md transition">
                    <div class="row g-0 align-items-center">
                        <div class="col-lg-6">
                            <a href="{{ route('news.show', $featuredNews->slug) }}" class="d-block overflow-hidden" style="height: 340px;">
                                <img src="{{ $featuredNews->image ?? 'https://images.unsplash.com/photo-1517245386807-bb43f82c33c4?auto=format&fit=crop&w=1000&q=80' }}" 
                                     alt="{{ $featuredNews->title }}" 
                                     class="w-100 h-100 object-fit-cover transition transform hover-scale">
                            </a>
                        </div>
                        <div class="col-lg-6 p-4 p-md-5">
                            <div class="d-flex align-items-center gap-2 mb-2">
                                <span class="badge bg-danger rounded-pill px-2.5 py-1 text-uppercase extra-small font-bold">Terbaru</span>
                                <span class="text-muted small">
                                    <i class="fa-regular fa-calendar me-1"></i> {{ \Carbon\Carbon::parse($featuredNews->published_at)->translatedFormat('d F Y') }}
                                </span>
                            </div>
                            <h2 class="fw-bold text-dark mb-3 fs-3">
                                <a href="{{ route('news.show', $featuredNews->slug) }}" class="text-dark text-decoration-none hover-danger">
                                    {{ $featuredNews->title }}
                                </a>
                            </h2>
                            <p class="text-secondary leading-relaxed mb-4">
                                {{ $featuredNews->excerpt }}
                            </p>
                            <div class="d-flex align-items-center justify-content-between pt-3 border-top">
                                <div class="d-flex align-items-center gap-2">
                                    <div class="rounded-circle bg-danger-subtle text-danger d-flex align-items-center justify-content-center fw-bold" style="width: 36px; height: 36px; font-size: 0.8rem;">
                                        <i class="fa-solid fa-user-pen"></i>
                                    </div>
                                    <div>
                                        <div class="fw-bold text-dark small leading-none">{{ $featuredNews->author }}</div>
                                        <div class="text-muted extra-small" style="font-size: 0.72rem;">Penyusun Laporan</div>
                                    </div>
                                </div>
                                <a href="{{ route('news.show', $featuredNews->slug) }}" class="btn btn-outline-danger btn-sm rounded-pill fw-bold px-3">
                                    Baca Selengkapnya <i class="fa-solid fa-arrow-right ms-1"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <!-- NEWS LIST GRID -->
        <div class="row g-4 mb-5">
            @forelse($newsList as $item)
                <div class="col-md-6 col-lg-4">
                    <div class="card h-100 border-0 rounded-4 shadow-sm overflow-hidden bg-white d-flex flex-column justify-content-between hover-card transition">
                        <div>
                            <!-- Cover Image -->
                            <a href="{{ route('news.show', $item->slug) }}" class="d-block overflow-hidden position-relative" style="height: 210px;">
                                <img src="{{ $item->image ?? 'https://images.unsplash.com/photo-1517245386807-bb43f82c33c4?auto=format&fit=crop&w=600&q=80' }}" 
                                     alt="{{ $item->title }}" class="w-100 h-100 object-fit-cover transition transform hover-scale">
                                <div class="position-absolute top-0 end-0 m-3">
                                    <span class="badge bg-dark bg-opacity-75 rounded-pill px-2.5 py-1 extra-small text-white backdrop-blur">
                                        <i class="fa-regular fa-eye me-1"></i> {{ $item->views_count }}
                                    </span>
                                </div>
                            </a>

                            <div class="p-4">
                                <div class="d-flex align-items-center gap-2 text-muted extra-small mb-2" style="font-size: 0.78rem;">
                                    <span class="text-danger fw-semibold">
                                        <i class="fa-regular fa-calendar me-1"></i> {{ \Carbon\Carbon::parse($item->published_at)->translatedFormat('d M Y') }}
                                    </span>
                                </div>

                                <h3 class="fs-5 fw-bold text-dark mb-2 leading-snug">
                                    <a href="{{ route('news.show', $item->slug) }}" class="text-dark text-decoration-none hover-danger line-clamp-2">
                                        {{ $item->title }}
                                    </a>
                                </h3>

                                <p class="text-secondary small leading-relaxed line-clamp-3 mb-0">
                                    {{ $item->excerpt }}
                                </p>
                            </div>
                        </div>

                        <!-- Card Footer -->
                        <div class="px-4 pb-4 pt-3 border-top d-flex align-items-center justify-content-between">
                            <div class="d-flex align-items-center gap-2 min-w-0">
                                <div class="rounded-circle bg-light text-secondary d-flex align-items-center justify-content-center flex-shrink-0" style="width: 30px; height: 30px; font-size: 0.75rem;">
                                    <i class="fa-solid fa-user"></i>
                                </div>
                                <span class="small text-muted text-truncate fw-semibold" style="font-size: 0.78rem;">
                                    {{ $item->author }}
                                </span>
                            </div>
                            <a href="{{ route('news.show', $item->slug) }}" class="btn btn-sm btn-link text-danger fw-bold text-decoration-none p-0 flex-shrink-0 ms-2">
                                Baca <i class="fa-solid fa-chevron-right ms-1"></i>
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 py-5 text-center text-muted">
                    <div class="w-16 h-16 rounded-circle bg-light d-flex align-items-center justify-content-center mx-auto mb-3 text-secondary fs-3" style="width: 64px; height: 64px;">
                        <i class="fa-solid fa-newspaper"></i>
                    </div>
                    <h5 class="fw-bold text-dark">Belum ada berita ditemukan</h5>
                    <p class="small text-muted">Silakan periksa kembali kata kunci pencarian Anda atau kembali ke beranda.</p>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if($newsList->hasPages())
            <div class="d-flex justify-content-center mb-5">
                {{ $newsList->links('pagination::bootstrap-5') }}
            </div>
        @endif

    </div>
</div>

<style>
    .hover-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 28px rgba(0,0,0,0.08) !important;
    }
    .hover-danger:hover {
        color: var(--pgri-red) !important;
    }
    .hover-scale:hover {
        transform: scale(1.04);
    }
    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    .line-clamp-3 {
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
</style>
@endsection
