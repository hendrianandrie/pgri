@extends('layouts.app')

@section('title', ($profile['title'] ?? 'Profil Persatuan Guru Republik Indonesia') . ' — PGRI')

@section('content')
<!-- HEADER -->
<div class="bg-danger text-white py-5 position-relative" style="background: linear-gradient(135deg, #0f172a 0%, #991b1b 50%, #dc2626 100%);">
    <div class="container py-3 text-center">
        @if(!empty($profile['badge']))
        <span class="badge bg-warning text-dark rounded-pill px-3 py-2 fw-bold mb-3">{{ $profile['badge'] }}</span>
        @endif
        <h1 class="display-5 fw-extrabold text-white tracking-tight">{{ $profile['title'] ?? 'Profil Persatuan Guru Republik Indonesia' }}</h1>
        <p class="lead opacity-90 max-w-2xl mx-auto mb-0" style="max-width: 750px;">
            {{ $profile['subtitle'] ?? 'Mengenal Visi, Misi, dan Jajaran Pengurus PGRI Cabang Ciamis.' }}
        </p>

        @auth
            @if(Auth::user()->role === 'admin' || Auth::user()->role === 'pengurus')
            <div class="mt-4">
                <a href="{{ route('admin.profile-settings') }}" class="btn btn-sm btn-warning text-dark fw-bold rounded-pill px-3 shadow-sm d-inline-flex align-items-center gap-2">
                    <i class="fa-solid fa-pen-to-square"></i>
                    <span>Edit Konten Halaman Profil Ini</span>
                </a>
            </div>
            @endif
        @endauth
    </div>
</div>

<div class="container py-5">
    <!-- VISI & MISI -->
    <div class="row g-4 mb-5">
        <div class="col-lg-5">
            <div class="card card-custom p-4 bg-white h-100 border-start border-5 border-danger shadow-sm rounded-4">
                <div class="d-flex align-items-center gap-3 mb-3">
                    <div class="rounded-circle bg-danger bg-opacity-10 text-danger p-3 fs-3 d-flex align-items-center justify-content-center" style="width: 52px; height: 52px;">
                        <i class="fa-solid fa-eye"></i>
                    </div>
                    <div>
                        <h4 class="fw-extrabold text-dark mb-0">{{ $profile['visi_title'] ?? 'Visi PGRI' }}</h4>
                        <span class="small text-muted">{{ $profile['visi_subtitle'] ?? 'Arah & Cita-cita Organisasi' }}</span>
                    </div>
                </div>
                <p class="fs-5 text-dark fw-medium lh-base mb-0" style="font-style: italic;">
                    "{{ $profile['visi'] ?? $visiMisi['visi'] }}"
                </p>
            </div>
        </div>

        <div class="col-lg-7">
            <div class="card card-custom p-4 bg-white h-100 border-start border-5 border-warning shadow-sm rounded-4">
                <div class="d-flex align-items-center gap-3 mb-3">
                    <div class="rounded-circle bg-warning bg-opacity-10 text-warning p-3 fs-3 d-flex align-items-center justify-content-center" style="width: 52px; height: 52px;">
                        <i class="fa-solid fa-bullseye"></i>
                    </div>
                    <div>
                        <h4 class="fw-extrabold text-dark mb-0">{{ $profile['misi_title'] ?? 'Misi PGRI' }}</h4>
                        <span class="small text-muted">{{ $profile['misi_subtitle'] ?? 'Empat Pilar Pelaksanaan Kerja' }}</span>
                    </div>
                </div>
                <ul class="list-unstyled mb-0 d-flex flex-column gap-3">
                    @foreach($visiMisi['misi'] as $index => $misi)
                    <li class="d-flex align-items-start gap-3">
                        <span class="badge bg-danger rounded-circle p-2 d-flex align-items-center justify-content-center flex-shrink-0" style="width: 28px; height: 28px; font-size: 0.85rem;">{{ $index + 1 }}</span>
                        <span class="text-secondary fw-medium leading-relaxed">{{ $misi }}</span>
                    </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>

    <!-- PENGURUS BESAR PGRI -->
    <div>
        <div class="text-center max-w-2xl mx-auto mb-5">
            @if(!empty($profile['executives_badge']))
            <span class="badge bg-danger-subtle text-danger rounded-pill px-3 py-2 fw-bold mb-2">{{ $profile['executives_badge'] }}</span>
            @endif
            <h2 class="fw-extrabold text-dark tracking-tight">{{ $profile['executives_title'] ?? 'Struktur Pengurus PGRI Cabang Ciamis' }}</h2>
            <p class="text-muted">{{ $profile['executives_subtitle'] ?? 'Jajaran kepemimpinan yang mengabdi pada Pengurus PGRI Cabang Ciamis.' }}</p>
        </div>

        <div class="row g-4">
            @foreach($executives as $executive)
            <div class="col-md-6 col-lg-3">
                <div class="card card-custom text-center p-4 bg-white h-100 shadow-sm rounded-4">
                    <img src="{{ $executive->photo }}" alt="{{ $executive->name }}" class="rounded-circle mx-auto mb-3 object-fit-cover shadow-sm border border-3 border-danger" style="width: 110px; height: 110px;">
                    <h6 class="fw-bold text-dark mb-1">{{ $executive->name }}</h6>
                    <span class="badge bg-danger bg-opacity-10 text-danger rounded-pill px-3 py-1 mb-2 fw-semibold" style="font-size: 0.78rem;">{{ $executive->position }}</span>
                    <p class="text-muted extra-small mb-2">{{ $executive->unit }}</p>
                    <p class="small text-secondary mb-0" style="font-size: 0.82rem;">{{ $executive->bio }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
