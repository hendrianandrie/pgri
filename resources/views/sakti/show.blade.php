@extends('layouts.app')

@section('title', $content->title . ' — SAKTI PGRI')

@section('content')
<div class="bg-dark text-white py-5" style="background: linear-gradient(135deg, #0f172a 0%, #1e1b4b 60%, #b91c1c 100%);">
    <div class="container py-3">
        <div class="d-flex align-items-center gap-2 mb-3">
            <a href="{{ route('sakti.index') }}" class="text-white-50 text-decoration-none small"><i class="fa-solid fa-arrow-left me-1"></i> SAKTI PGRI</a>
            <span class="text-white-50">/</span>
            <span class="small text-warning text-capitalize">{{ str_replace('_', ' ', $content->category) }}</span>
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
                    <p class="text-muted small mb-0">{{ $content->summary }}</p>
                </div>

                <div class="lh-lg text-secondary fs-6 mb-4" style="text-align: justify;">
                    {!! nl2br(e($content->content)) !!}
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
