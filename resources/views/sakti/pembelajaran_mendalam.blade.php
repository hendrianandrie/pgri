@extends('layouts.app')

@section('title', 'Pembelajaran Mendalam — SAKTI PGRI')

@section('content')
<div class="py-5 text-white" style="background: linear-gradient(135deg, #0284c7 0%, #0369a1 100%);">
    <div class="container py-3">
        <div class="d-flex align-items-center gap-2 mb-2 text-white">
            <a href="{{ route('sakti.index') }}" class="text-white text-decoration-none small"><i class="fa-solid fa-arrow-left me-1"></i> Portofolio SAKTI</a>
            <span class="text-white-50">/</span>
            <span class="small text-white">Pembelajaran Mendalam</span>
        </div>
        <h1 class="display-5 fw-extrabold text-white mb-2">Modul Pembelajaran Mendalam (Deep Learning)</h1>
        <p class="lead opacity-90 text-white mb-0">Pendekatan pedagogi berbasis pemahaman mendalam, kognisi kritis, dan pembelajaran bermakna untuk semua jenjang pendidikan.</p>
    </div>
</div>

<div class="container py-5">
    <!-- SEARCH & LEVEL FILTER BAR -->
    <div class="card card-custom p-4 bg-white mb-4 border-0 shadow-sm">
        <form action="{{ route('sakti.pembelajaran-mendalam') }}" method="GET" class="row g-3 align-items-center">
            <div class="col-lg-6 col-md-5">
                <div class="input-group">
                    <span class="input-group-text bg-light border-0"><i class="fa-solid fa-magnifying-glass text-muted"></i></span>
                    <input type="text" name="search" class="form-control bg-light border-0" placeholder="Cari Nama Modul, Penyusun, Sekolah..." value="{{ request('search') }}">
                </div>
            </div>
            <div class="col-lg-4 col-md-4">
                <select name="tingkat" class="form-select bg-light border-0 font-medium">
                    <option value="">Semua Tingkat (PAUD, TK, SD, SMP, SMA/K, Umum)</option>
                    <option value="PAUD" {{ request('tingkat') == 'PAUD' ? 'selected' : '' }}>PAUD (Pendidikan Anak Usia Dini)</option>
                    <option value="TK" {{ request('tingkat') == 'TK' ? 'selected' : '' }}>TK (Taman Kanak-Kanak)</option>
                    <option value="SD" {{ request('tingkat') == 'SD' ? 'selected' : '' }}>SD (Sekolah Dasar)</option>
                    <option value="SMP" {{ request('tingkat') == 'SMP' ? 'selected' : '' }}>SMP (Sekolah Menengah Pertama)</option>
                    <option value="SMA/K" {{ request('tingkat') == 'SMA/K' ? 'selected' : '' }}>SMA/K (SMA & SMK)</option>
                    <option value="Umum" {{ request('tingkat') == 'Umum' ? 'selected' : '' }}>Umum</option>
                </select>
            </div>
            <div class="col-lg-2 col-md-3 d-flex gap-2">
                <button type="submit" class="btn text-white w-100 fw-bold rounded-3" style="background-color: #0284c7;">
                    Filter Modul
                </button>
                @if(request('search') || request('tingkat'))
                    <a href="{{ route('sakti.pembelajaran-mendalam') }}" class="btn btn-outline-secondary rounded-3" title="Reset Filter">
                        <i class="fa-solid fa-rotate-left"></i>
                    </a>
                @endif
            </div>
        </form>

        <!-- Quick Filter Tags -->
        <div class="d-flex flex-wrap gap-2 mt-3 pt-3 border-top">
            <span class="small text-muted fw-bold align-self-center me-1">Pilih Jenjang:</span>
            <a href="{{ route('sakti.pembelajaran-mendalam') }}" class="btn btn-sm rounded-pill {{ !request('tingkat') ? 'btn-dark' : 'btn-light border text-muted' }}">Semua</a>
            <a href="{{ route('sakti.pembelajaran-mendalam', ['tingkat' => 'PAUD']) }}" class="btn btn-sm rounded-pill {{ request('tingkat') == 'PAUD' ? 'btn-danger' : 'btn-light border text-muted' }}">PAUD</a>
            <a href="{{ route('sakti.pembelajaran-mendalam', ['tingkat' => 'TK']) }}" class="btn btn-sm rounded-pill {{ request('tingkat') == 'TK' ? 'btn-warning text-dark' : 'btn-light border text-muted' }}">TK</a>
            <a href="{{ route('sakti.pembelajaran-mendalam', ['tingkat' => 'SD']) }}" class="btn btn-sm rounded-pill {{ request('tingkat') == 'SD' ? 'btn-success' : 'btn-light border text-muted' }}">SD</a>
            <a href="{{ route('sakti.pembelajaran-mendalam', ['tingkat' => 'SMP']) }}" class="btn btn-sm rounded-pill {{ request('tingkat') == 'SMP' ? 'btn-primary' : 'btn-light border text-muted' }}">SMP</a>
            <a href="{{ route('sakti.pembelajaran-mendalam', ['tingkat' => 'SMA/K']) }}" class="btn btn-sm rounded-pill {{ request('tingkat') == 'SMA/K' ? 'btn-info text-white' : 'btn-light border text-muted' }}">SMA/K</a>
            <a href="{{ route('sakti.pembelajaran-mendalam', ['tingkat' => 'Umum']) }}" class="btn btn-sm rounded-pill {{ request('tingkat') == 'Umum' ? 'btn-secondary text-white' : 'btn-light border text-muted' }}">Umum</a>
        </div>
    </div>

    <!-- CONTENT GRID -->
    <div class="row g-4 mb-4">
        @forelse($contents as $item)
        <div class="col-md-6 col-lg-4">
            <div class="card card-custom h-100 bg-white border-0 shadow-sm overflow-hidden d-flex flex-column hover-shadow transition">
                <!-- Cover Image (Clickable directly to module link) -->
                <a href="{{ $item->file_url ?: route('sakti.show', $item->slug) }}" 
                   {!! $item->file_url ? 'target="_blank" rel="noopener noreferrer"' : '' !!} 
                   class="d-block text-decoration-none overflow-hidden position-relative group">
                    @if($item->image)
                        <img src="{{ $item->image }}" class="card-img-top object-fit-cover w-100" alt="{{ $item->title }}" style="height: 190px;">
                    @else
                        <div class="w-100 d-flex align-items-center justify-content-center text-white" style="height: 190px; background: linear-gradient(135deg, #0284c7, #0369a1);">
                            <i class="fa-solid fa-brain display-4 opacity-75"></i>
                        </div>
                    @endif
                    @if($item->file_url)
                        <span class="position-absolute top-0 end-0 m-3 badge bg-dark bg-opacity-75 text-white rounded-pill px-2.5 py-1 extra-small">
                            <i class="fa-solid fa-external-link-alt me-1"></i> Buka Tautan
                        </span>
                    @endif
                </a>

                <div class="card-body p-4 d-flex flex-column flex-grow-1">
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        @php
                            $badge = strtoupper($item->badge ?? 'UMUM');
                            $badgeStyle = match($badge) {
                                'PAUD' => 'background-color: #fce7f3; color: #be185d; border: 1px solid #fbcfe8;',
                                'TK' => 'background-color: #ffedd5; color: #c2410c; border: 1px solid #fed7aa;',
                                'SD' => 'background-color: #d1fae5; color: #047857; border: 1px solid #a7f3d0;',
                                'SMP' => 'background-color: #e0f2fe; color: #0369a1; border: 1px solid #bae6fd;',
                                'SMA/K', 'SMA', 'SMK' => 'background-color: #f3e8ff; color: #7e22ce; border: 1px solid #e9d5ff;',
                                default => 'background-color: #e0f2fe; color: #0284c7; border: 1px solid #bae6fd;',
                            };
                        @endphp
                        <span class="badge rounded-pill px-3 py-1 fw-bold" style="{{ $badgeStyle }}">
                            {{ $item->badge ?? 'Deep Learning' }}
                        </span>
                        <span class="small text-muted"><i class="fa-solid fa-eye me-1"></i> {{ $item->views }} views</span>
                    </div>

                    <!-- Title (Clickable directly to module link) -->
                    <h5 class="fw-bold mb-2">
                        <a href="{{ $item->file_url ?: route('sakti.show', $item->slug) }}" 
                           {!! $item->file_url ? 'target="_blank" rel="noopener noreferrer"' : '' !!} 
                           class="text-dark text-decoration-none hover-info">
                            {{ $item->title }}
                        </a>
                    </h5>

                    <p class="text-muted small mb-3 flex-grow-1">{{ Str::limit($item->summary, 120) }}</p>

                    <!-- Author & School Info -->
                    <div class="small text-muted mb-3">
                        <div class="d-flex align-items-center gap-1">
                            <i class="fa-solid fa-user-pen text-secondary me-1"></i>
                            <span>Penyusun: <strong>{{ $item->author ?? 'Pengurus PGRI' }}</strong></span>
                        </div>
                        @if($item->school_origin)
                            <div class="d-flex align-items-center gap-1 text-secondary mt-1" style="font-size: 0.8rem;">
                                <i class="fa-solid fa-school text-muted me-1"></i>
                                <span>{{ $item->school_origin }}</span>
                            </div>
                        @endif
                    </div>

                    <!-- Buttons: Buka Link Modul Direct Button -->
                    <div class="mt-auto d-flex align-items-center justify-content-between pt-3 border-top gap-2">
                        @if($item->file_url)
                            <a href="{{ $item->file_url }}" target="_blank" rel="noopener noreferrer" 
                               class="btn btn-sm rounded-pill fw-bold text-white px-3 flex-grow-1 text-center shadow-sm" 
                               style="background-color: #0284c7;">
                                <i class="fa-solid fa-arrow-up-right-from-square me-1"></i> Buka Link Modul
                            </a>
                            <a href="{{ route('sakti.show', $item->slug) }}" class="btn btn-sm btn-outline-secondary rounded-pill" title="Detail Informasi Lengkap">
                                <i class="fa-solid fa-circle-info"></i>
                            </a>
                        @else
                            <a href="{{ route('sakti.show', $item->slug) }}" class="btn btn-sm rounded-pill fw-bold text-white px-3 w-100 text-center" style="background-color: #0284c7;">
                                Pelajari Panduan <i class="fa-solid fa-arrow-right ms-1"></i>
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12 text-center py-5">
            <div class="text-muted fs-4 mb-2"><i class="fa-solid fa-circle-exclamation text-warning"></i></div>
            <h5 class="fw-bold text-dark">Modul Tidak Ditemukan</h5>
            <p class="text-muted small">Coba ubah kata kunci pencarian atau pilihan jenjang pendidikan Anda.</p>
        </div>
        @endforelse
    </div>

    {{ $contents->withQueryString()->links() }}
</div>
@endsection
