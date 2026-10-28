@extends('layouts.app')

@section('title', $news->title . ' - Berita PGRI')

@section('content')
<div class="py-5 bg-slate-50 min-vh-100">
    <div class="container">

        <!-- BREADCRUMB -->
        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb small">
                <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-decoration-none text-muted"><i class="fa-solid fa-house me-1"></i> Beranda</a></li>
                <li class="breadcrumb-item"><a href="{{ route('news.index') }}" class="text-decoration-none text-muted">Berita</a></li>
                <li class="breadcrumb-item active text-truncate text-dark fw-semibold" style="max-width: 400px;" aria-current="page">{{ $news->title }}</li>
            </ol>
        </nav>

        <div class="row g-5">
            <!-- MAIN CONTENT (Left Col) -->
            <div class="col-lg-8">
                <article class="bg-white rounded-4 p-4 p-md-5 shadow-sm border-0 mb-5">

                    <!-- Meta Tags / Category -->
                    <div class="d-flex flex-wrap align-items-center gap-2 mb-3">
                        <span class="badge bg-danger rounded-pill px-3 py-1 font-bold text-uppercase extra-small">
                            <i class="fa-solid fa-bullhorn me-1"></i> Reportase Kegiatan
                        </span>
                        <span class="text-muted extra-small">
                            <i class="fa-regular fa-clock me-1"></i> Dibaca {{ $news->views_count }} kali
                        </span>
                    </div>

                    <!-- Article Title -->
                    <h1 class="display-6 fw-extrabold text-dark tracking-tight mb-4 leading-tight">
                        {{ $news->title }}
                    </h1>

                    <!-- Author & Date Strip -->
                    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 p-3 rounded-3 bg-slate-50 border border-slate-100 mb-4">
                        <div class="d-flex align-items-center gap-3">
                            <div class="rounded-circle bg-danger text-white d-flex align-items-center justify-content-center fw-bold shadow-sm" style="width: 42px; height: 42px; font-size: 0.95rem;">
                                <i class="fa-solid fa-user-pen"></i>
                            </div>
                            <div>
                                <div class="fw-bold text-dark small">{{ $news->author }}</div>
                                <div class="text-muted extra-small" style="font-size: 0.75rem;">
                                    <i class="fa-regular fa-calendar-check text-emerald-600 me-1"></i> 
                                    {{ \Carbon\Carbon::parse($news->published_at)->translatedFormat('l, d F Y') }}
                                </div>
                            </div>
                        </div>

                        <!-- Share Buttons -->
                        <div class="d-flex align-items-center gap-1.5">
                            <span class="extra-small text-muted fw-bold me-1">Bagikan:</span>
                            <a href="https://api.whatsapp.com/send?text={{ urlencode($news->title . ' ' . url()->current()) }}" target="_blank" 
                               class="btn btn-sm btn-outline-success rounded-circle d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;" title="Bagikan ke WhatsApp">
                                <i class="fa-brands fa-whatsapp"></i>
                            </a>
                            <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}" target="_blank" 
                               class="btn btn-sm btn-outline-primary rounded-circle d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;" title="Bagikan ke Facebook">
                                <i class="fa-brands fa-facebook-f"></i>
                            </a>
                            <button onclick="navigator.clipboard.writeText(window.location.href); alert('Tautan berita berhasil disalin ke clipboard!');" 
                                    class="btn btn-sm btn-outline-secondary rounded-circle d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;" title="Salin Tautan">
                                <i class="fa-solid fa-link"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Featured Cover Image -->
                    @if($news->image)
                        <div class="rounded-4 overflow-hidden mb-4 shadow-sm">
                            <img src="{{ $news->image }}" alt="{{ $news->title }}" class="w-100 object-fit-cover" style="max-height: 460px;">
                        </div>
                    @endif

                    <!-- Article Excerpt / Highlight -->
                    @if(!empty($news->excerpt))
                        <div class="p-3.5 rounded-3 bg-red-50 border-start border-4 border-danger mb-4">
                            <p class="mb-0 text-dark fw-medium fs-6 leading-relaxed italic text-justify" style="text-align: justify; text-justify: inter-word;">
                                "{{ $news->excerpt }}"
                            </p>
                        </div>
                    @endif

                    <!-- Article Content Body -->
                    <div class="article-content text-slate-800 leading-relaxed fs-6 mb-5" style="text-align: justify; text-justify: inter-word;">
                        @php
                            $newsParagraphs = preg_split('/(\r\n\r\n|\n\n|\r\r)/', trim($news->content ?? ''));
                        @endphp
                        @foreach($newsParagraphs as $nPara)
                            @if(trim($nPara))
                                <p class="mb-3 text-justify" style="text-align: justify; text-justify: inter-word; line-height: 1.85;">
                                    {!! nl2br(e(trim($nPara))) !!}
                                </p>
                            @endif
                        @endforeach
                    </div>

                    <!-- Author Footer Box -->
                    <div class="p-4 rounded-3 bg-slate-100 d-flex align-items-center gap-3 border border-slate-200">
                        <div class="rounded-circle bg-dark text-white d-flex align-items-center justify-content-center flex-shrink-0" style="width: 48px; height: 48px;">
                            <i class="fa-solid fa-bullhorn text-amber-400 fs-5"></i>
                        </div>
                        <div>
                            <div class="fw-bold text-dark small">Redaksi & Publikasi PGRI</div>
                            <p class="text-muted extra-small mb-0">Laporan kegiatan ini dihimpun dan dipublikasikan secara resmi oleh <strong>{{ $news->author }}</strong> untuk seluruh anggota dan keluarga besar PGRI.</p>
                        </div>
                    </div>

                </article>

                <!-- COMMENTS SECTION -->
                <section id="komentar" class="bg-white rounded-4 p-4 p-md-5 shadow-sm border-0 mb-5">
                    
                    <!-- Section Header -->
                    <div class="d-flex align-items-center justify-content-between pb-3 mb-4 border-bottom">
                        <h3 class="fs-5 fw-bold text-dark mb-0 d-flex align-items-center gap-2">
                            <i class="fa-solid fa-comments text-danger"></i>
                            <span>Komentar & Tanggapan</span>
                            <span class="badge bg-danger-subtle text-danger rounded-pill px-2.5 py-1 extra-small fw-bold">
                                {{ $news->approvedComments->count() }}
                            </span>
                        </h3>
                        <a href="#form-komentar" class="btn btn-sm btn-outline-danger rounded-pill px-3 fw-bold extra-small">
                            <i class="fa-solid fa-pen-nib me-1"></i> Tulis Komentar
                        </a>
                    </div>

                    <!-- Flash Message for Comment Submission -->
                    @if(session('comment_success'))
                        <div class="alert alert-success alert-dismissible fade show rounded-3 p-3 mb-4 d-flex align-items-start gap-2 border-0 shadow-sm" role="alert">
                            <i class="fa-solid fa-circle-check fs-5 text-success flex-shrink-0 mt-0.5"></i>
                            <div class="small leading-snug">
                                <strong class="d-block mb-1">Berhasil Terkirim!</strong>
                                {{ session('comment_success') }}
                            </div>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show rounded-3 p-3 mb-4 border-0 shadow-sm" role="alert">
                            <div class="d-flex align-items-start gap-2">
                                <i class="fa-solid fa-circle-exclamation fs-5 text-danger flex-shrink-0 mt-0.5"></i>
                                <div class="small">
                                    <strong class="d-block mb-1">Gagal mengirim komentar:</strong>
                                    <ul class="mb-0 ps-3">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <!-- Comments List -->
                    <div class="d-flex flex-column gap-3 mb-5">
                        @forelse($news->approvedComments as $comment)
                            <div class="p-3.5 rounded-3 bg-slate-50 border border-slate-100">
                                <div class="d-flex align-items-center justify-content-between gap-2 mb-2">
                                    <div class="d-flex align-items-center gap-2.5">
                                        <div class="rounded-circle bg-danger-subtle text-danger fw-bold d-flex align-items-center justify-content-center flex-shrink-0" style="width: 38px; height: 38px; font-size: 0.85rem;">
                                            {{ strtoupper(substr($comment->name, 0, 1)) }}
                                        </div>
                                        <div>
                                            <div class="fw-bold text-dark small leading-tight">{{ $comment->name }}</div>
                                            <div class="text-muted extra-small" style="font-size: 0.72rem;">
                                                <i class="fa-regular fa-clock me-1"></i>
                                                {{ $comment->created_at ? $comment->created_at->diffForHumans() : '-' }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="text-secondary small leading-relaxed ps-md-5 ms-md-2" style="font-size: 0.88rem; white-space: pre-line;">
                                    {{ $comment->comment }}
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-4 px-3 bg-slate-50 rounded-3 border border-dashed border-slate-200">
                                <i class="fa-regular fa-comment-dots text-muted fs-3 mb-2 d-block"></i>
                                <p class="text-muted small mb-1 fw-semibold">Belum ada komentar untuk berita ini.</p>
                                <span class="text-muted extra-small">Jadilah yang pertama memberikan tanggapan atau apresiasi Anda.</span>
                            </div>
                        @endforelse
                    </div>

                    <!-- Leave Comment Form -->
                    <div id="form-komentar" class="p-4 rounded-4 bg-slate-50 border border-slate-200">
                        <div class="mb-3">
                            <h4 class="fs-6 fw-bold text-dark mb-1 d-flex align-items-center gap-2">
                                <i class="fa-solid fa-pen-to-square text-danger"></i>
                                <span>Tinggalkan Komentar</span>
                            </h4>
                            <p class="text-muted extra-small mb-0">
                                <i class="fa-solid fa-shield-halved text-emerald-600 me-1"></i>
                                Komentar akan ditinjau oleh redaksi sebelum ditampilkan ke publik. Alamat email Anda tidak akan dipublikasikan.
                            </p>
                        </div>

                        <form action="{{ route('news.comment.store', $news->slug) }}" method="POST">
                            @csrf

                            <!-- Honeypot field (hidden from real users) -->
                            <div style="display: none !important;" aria-hidden="true">
                                <label for="website_hp">Website</label>
                                <input type="text" name="website_hp" id="website_hp" tabindex="-1" autocomplete="off">
                            </div>

                            <div class="row g-3 mb-3">
                                <div class="col-md-6">
                                    <label for="name" class="form-label extra-small fw-bold text-dark mb-1">
                                        Nama Lengkap <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" name="name" id="name" value="{{ old('name') }}" required
                                           class="form-control form-control-sm rounded-3 @error('name') is-invalid @enderror"
                                           placeholder="Contoh: Budi Santoso, S.Pd.">
                                    @error('name')
                                        <div class="invalid-feedback extra-small">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="email" class="form-label extra-small fw-bold text-dark mb-1">
                                        Alamat Email <span class="text-danger">*</span>
                                    </label>
                                    <input type="email" name="email" id="email" value="{{ old('email') }}" required
                                           class="form-control form-control-sm rounded-3 @error('email') is-invalid @enderror"
                                           placeholder="nama@email.com">
                                    @error('email')
                                        <div class="invalid-feedback extra-small">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="comment" class="form-label extra-small fw-bold text-dark mb-1">
                                    Isi Komentar / Tanggapan <span class="text-danger">*</span>
                                </label>
                                <textarea name="comment" id="comment" rows="4" required
                                          class="form-control form-control-sm rounded-3 @error('comment') is-invalid @enderror"
                                          placeholder="Tuliskan apresiasi, masukan, atau tanggapan Anda dengan bahasa yang santun...">{{ old('comment') }}</textarea>
                                @error('comment')
                                    <div class="invalid-feedback extra-small">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 pt-1">
                                <span class="extra-small text-muted">
                                    <i class="fa-solid fa-circle-info me-1"></i> Maksimal 1.000 karakter.
                                </span>
                                <button type="submit" class="btn btn-danger btn-sm rounded-pill px-4 fw-bold shadow-sm d-flex align-items-center gap-1.5">
                                    <i class="fa-solid fa-paper-plane"></i>
                                    <span>Kirim Komentar</span>
                                </button>
                            </div>
                        </form>
                    </div>

                </section>
            </div>

            <!-- SIDEBAR (Right Col) -->
            <div class="col-lg-4">
                <div class="sticky-top" style="top: 90px;">

                    <!-- Recent News Widget -->
                    <div class="bg-white rounded-4 p-4 shadow-sm border-0 mb-4">
                        <div class="d-flex align-items-center justify-content-between pb-3 mb-3 border-bottom">
                            <h5 class="fw-bold text-dark mb-0 fs-6 flex items-center gap-2">
                                <i class="fa-solid fa-newspaper text-danger"></i>
                                <span>Berita Terbaru Lainnya</span>
                            </h5>
                            <a href="{{ route('news.index') }}" class="extra-small text-danger fw-bold text-decoration-none">Lihat Semua</a>
                        </div>

                        <div class="d-flex flex-column gap-3">
                            @forelse($recentNews as $recent)
                                <a href="{{ route('news.show', $recent->slug) }}" class="text-decoration-none group">
                                    <div class="d-flex gap-3 align-items-start">
                                        <div class="rounded-3 overflow-hidden bg-slate-100 flex-shrink-0 border border-slate-200" style="width: 76px; height: 60px;">
                                            <img src="{{ $recent->image ?? 'https://images.unsplash.com/photo-1517245386807-bb43f82c33c4?auto=format&fit=crop&w=200&q=80' }}" 
                                                 alt="{{ $recent->title }}" class="w-100 h-100 object-fit-cover">
                                        </div>
                                        <div class="min-w-0">
                                            <h6 class="fw-bold text-dark mb-1 text-truncate-2 group-hover-danger small leading-snug">
                                                {{ $recent->title }}
                                            </h6>
                                            <div class="extra-small text-muted" style="font-size: 0.72rem;">
                                                <i class="fa-regular fa-calendar me-1"></i> {{ \Carbon\Carbon::parse($recent->published_at)->translatedFormat('d M Y') }}
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            @empty
                                <div class="text-center py-3 text-muted small">Tidak ada berita lainnya.</div>
                            @endforelse
                        </div>
                    </div>

                    <!-- Banner Callout SAKTI PGRI -->
                    <div class="bg-dark text-white rounded-4 p-4 shadow-sm position-relative overflow-hidden" 
                         style="background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%);">
                        <div class="badge bg-danger rounded-pill px-2.5 py-1 extra-small font-bold mb-2">Platform Digital</div>
                        <h5 class="fw-bold text-white mb-2">SAKTI PGRI</h5>
                        <p class="small text-white-50 leading-relaxed mb-3">Akses modul pembelajaran mendalam, repositori bahan ajar, dan pelatihan koding/AI resmi untuk guru.</p>
                        <a href="{{ route('sakti.index') }}" class="btn btn-warning btn-sm text-dark font-bold rounded-pill px-3 shadow-sm w-100">
                            <i class="fa-solid fa-wand-magic-sparkles me-1 text-danger"></i> Masuk ke SAKTI PGRI
                        </a>
                    </div>

                </div>
            </div>
        </div>

    </div>
</div>

<style>
    .text-truncate-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    .group:hover .group-hover-danger {
        color: var(--pgri-red) !important;
    }
    .article-content p {
        margin-bottom: 1.5rem;
    }
</style>
@endsection
