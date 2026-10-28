@extends('layouts.app')

@section('title', $content->title . ' — SAKTI PGRI')

@section('content')
<div class="bg-dark text-white py-5" style="background: linear-gradient(135deg, #0f172a 0%, #1e1b4b 60%, #b91c1c 100%);">
    <div class="container py-3">
        <div class="d-flex align-items-center gap-2 mb-3">
            <a href="{{ route('sakti.index') }}" class="text-white-50 text-decoration-none small"><i class="fa-solid fa-arrow-left me-1"></i> SAKTI PGRI</a>
            <span class="text-white-50">/</span>
            <span class="small text-warning">
                @if($content->category === 'pid')
                    PID (Papan Interaktif Digital)
                @else
                    {{ ucwords(str_replace('_', ' ', $content->category)) }}
                @endif
            </span>
        </div>
        <h1 class="display-6 fw-extrabold text-white mb-3" style="max-width: 900px;">{{ $content->title }}</h1>
        
        <div class="d-flex flex-wrap align-items-center gap-3 small text-white-75">
            <span><i class="fa-solid fa-user-pen text-warning me-1"></i> {{ $content->author }}</span>
            @if($content->school_origin)
                <span>•</span>
                <span><i class="fa-solid fa-school text-warning me-1"></i> {{ $content->school_origin }}</span>
            @endif
            <span>•</span>
            <span><i class="fa-solid fa-calendar me-1"></i> {{ $content->published_at ? $content->published_at->format('d F Y') : date('d F Y') }}</span>
            <span>•</span>
            <span><i class="fa-solid fa-eye me-1"></i> {{ $content->views }} Dibaca</span>
        </div>
    </div>
</div>

<div class="container py-5">
    <div class="row g-5">
        <div class="col-lg-8">
            <div class="card card-custom p-4 p-md-5 bg-white shadow-sm">
                @if($content->image)
                <img src="{{ $content->image }}" class="img-fluid rounded-4 mb-4 object-fit-cover w-100" alt="{{ $content->title }}" style="max-height: 420px;">
                @endif

                <div class="p-3 bg-light rounded-3 border-start border-4 border-danger mb-4">
                    <h6 class="fw-bold text-dark mb-1"><i class="fa-solid fa-quote-left text-danger me-2"></i> Ringkasan Materi:</h6>
                    <p class="text-muted small mb-0 text-justify" style="text-align: justify; text-justify: inter-word;">{{ $content->summary }}</p>
                </div>

                <div class="lh-lg text-secondary fs-6 mb-4 content-justified" style="text-align: justify; text-justify: inter-word;">
                    @php
                        $paragraphs = preg_split('/(\r\n\r\n|\n\n|\r\r)/', trim($content->content ?? ''));
                    @endphp
                    @foreach($paragraphs as $para)
                        @if(trim($para))
                            <p class="mb-3 text-justify" style="text-align: justify; text-justify: inter-word; line-height: 1.85;">
                                {!! nl2br(e(trim($para))) !!}
                            </p>
                        @endif
                    @endforeach
                </div>

                @if($content->file_url)
                <div class="p-4 rounded-4 d-flex flex-column flex-sm-row align-items-sm-center justify-content-between gap-3 mt-4 border"
                     style="{{ $content->category === 'koding_kka' ? 'background-color: #f3e8ff; border-color: #d8b4fe !important;' : 'background-color: rgba(220, 38, 38, 0.08); border-color: rgba(220, 38, 38, 0.2) !important;' }}">
                    <div class="d-flex align-items-center gap-3">
                        <i class="fa-solid {{ $content->category === 'koding_kka' ? 'fa-code' : 'fa-file-pdf' }} fs-1"
                           style="{{ $content->category === 'koding_kka' ? 'color: #9333ea;' : 'color: #dc2626;' }}"></i>
                        <div>
                            <h6 class="fw-bold text-dark mb-0">{{ $content->category === 'koding_kka' ? 'Tautan Materi & Modul Koding' : 'Lampiran Dokumen Modul / Berkas' }}</h6>
                            <span class="small text-muted">{{ $content->category === 'koding_kka' ? 'Klik tombol di samping untuk membuka modul langsung secara online' : 'Unduh materi lengkap dalam format berkas' }}</span>
                        </div>
                    </div>
                    <a href="{{ $content->file_url }}" target="_blank" rel="noopener noreferrer" 
                       class="btn rounded-pill px-4 py-2.5 fw-bold text-white shadow-sm d-inline-flex align-items-center gap-2" 
                       style="background-color: {{ $content->category === 'koding_kka' ? '#9333ea' : '#dc2626' }};">
                        <i class="fa-solid fa-arrow-up-right-from-square"></i>
                        <span>Buka Link Modul</span>
                    </a>
                </div>
                @endif
            </div>

            <!-- COMMENTS & DISCUSSION SECTION -->
            <div id="komentar" class="card card-custom p-4 p-md-5 bg-white shadow-sm mt-4">
                
                <!-- Section Header -->
                <div class="d-flex align-items-center justify-content-between pb-3 mb-4 border-bottom">
                    <h3 class="fs-5 fw-bold text-dark mb-0 d-flex align-items-center gap-2">
                        <i class="fa-solid fa-comments text-danger"></i>
                        <span>Diskusi & Komentar Modul</span>
                        <span class="badge bg-danger bg-opacity-10 text-danger rounded-pill px-2.5 py-1 extra-small fw-bold">
                            {{ $content->approvedComments->count() }}
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
                    @forelse($content->approvedComments as $comment)
                        <div class="p-3.5 rounded-3 bg-light border border-slate-100">
                            <div class="d-flex align-items-center justify-content-between gap-2 mb-2">
                                <div class="d-flex align-items-center gap-2.5">
                                    <div class="rounded-circle bg-danger bg-opacity-10 text-danger fw-bold d-flex align-items-center justify-content-center flex-shrink-0" style="width: 38px; height: 38px; font-size: 0.85rem;">
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
                        <div class="text-center py-4 px-3 bg-light rounded-3 border border-dashed border-secondary border-opacity-25">
                            <i class="fa-regular fa-comment-dots text-muted fs-3 mb-2 d-block"></i>
                            <p class="text-muted small mb-1 fw-semibold">Belum ada diskusi untuk modul ini.</p>
                            <span class="text-muted extra-small">Jadilah yang pertama memberikan tanggapan, apresiasi, atau pertanyaan terkait modul ini.</span>
                        </div>
                    @endforelse
                </div>

                <!-- Leave Comment Form -->
                <div id="form-komentar" class="p-4 rounded-4 bg-light border border-slate-200">
                    <div class="mb-3">
                        <h4 class="fs-6 fw-bold text-dark mb-1 d-flex align-items-center gap-2">
                            <i class="fa-solid fa-pen-to-square text-danger"></i>
                            <span>Tinggalkan Diskusi / Komentar</span>
                        </h4>
                        <p class="text-muted extra-small mb-0">
                            <i class="fa-solid fa-shield-halved text-success me-1"></i>
                            Komentar akan ditinjau oleh redaksi/admin sebelum ditampilkan. Alamat email Anda tidak akan dipublikasikan.
                        </p>
                    </div>

                    <form action="{{ route('sakti.comment.store', $content->slug) }}" method="POST">
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
                                Isi Komentar / Tanggapan Modul <span class="text-danger">*</span>
                            </label>
                            <textarea name="comment" id="comment" rows="4" required
                                      class="form-control form-control-sm rounded-3 @error('comment') is-invalid @enderror"
                                      placeholder="Tuliskan apresiasi, masukan, atau tanggapan terkait materi modul ini...">{{ old('comment') }}</textarea>
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

            </div>
        </div>

        <div class="col-lg-4">
            <!-- RELATED CONTENTS -->
            <div class="card card-custom p-4 bg-white mb-4">
                <h5 class="fw-bold text-dark mb-3"><i class="fa-solid fa-layer-group text-danger me-2"></i> Materi Terkait</h5>
                <div class="d-flex flex-column gap-3">
                    @foreach($related as $rel)
                    <div class="pb-3 border-bottom">
                        <span class="badge bg-danger bg-opacity-10 text-danger extra-small mb-1">{{ $rel->badge ?? 'Materi' }}</span>
                        <h6 class="fw-bold text-dark mb-1" style="font-size: 0.92rem;">
                            <a href="{{ route('sakti.show', $rel->slug) }}" class="text-dark text-decoration-none hover-danger">{{ $rel->title }}</a>
                        </h6>
                        <span class="extra-small text-muted"><i class="fa-solid fa-calendar me-1"></i> {{ $rel->published_at ? $rel->published_at->format('d M Y') : '' }}</span>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- ASPIRASI QUICK CALLOUT -->
            <div class="card card-custom p-4 text-white" style="background: linear-gradient(135deg, #0f172a 0%, #b91c1c 100%);">
                <h5 class="fw-bold mb-2"><i class="fa-solid fa-comments me-2 text-warning"></i> Aspirasi Guru</h5>
                <p class="small opacity-80 mb-3">Ada pertanyaan atau aspirasi terkait materi SAKTI ini? Hubungi tim PB PGRI.</p>
                <a href="{{ route('contact.index') }}" class="btn btn-gold btn-sm rounded-pill fw-bold">Kirim Pesan</a>
            </div>
        </div>
    </div>
</div>
@endsection
