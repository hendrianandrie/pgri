@extends('layouts.app')

@section('title', 'Ekosistem SAKTI — PGRI')

@section('content')
<!-- HEADER -->
<div class="bg-gradient text-white py-5" style="background: linear-gradient(135deg, #0f172a 0%, #1e1b4b 40%, #b91c1c 85%, #dc2626 100%);">
    <div class="container py-3 text-center">
        <span class="badge bg-warning text-dark rounded-pill px-3 py-2 fw-bold mb-3">SISTEM AKSES KOMUNITAS &amp; TRANSFORMASI INOVASI</span>
        <h1 class="display-5 fw-extrabold text-white tracking-tight">Ekosistem SAKTI PGRI</h1>
        <p class="lead opacity-90 max-w-2xl mx-auto mb-0" style="max-width: 750px;">
            Portal terpadu untuk pembelajaran mendalam, repositori perangkat ajar, pusat informasi digital, serta pengembangan koding &amp; AI bagi seluruh guru di Indonesia.
        </p>
    </div>
</div>

<div class="container py-5">
    <!-- FOUR MODULES GRID -->
    <div class="row g-4 mb-5">
        <!-- Module 1: Pembelajaran Mendalam -->
        <div class="col-md-6">
            <div class="card card-custom p-4 bg-white h-100 border-start border-5 border-info">
                <div class="d-flex align-items-center gap-3 mb-3">
                    <div class="rounded-4 bg-info bg-opacity-10 text-info p-3 fs-3">
                        <i class="fa-solid fa-brain"></i>
                    </div>
                    <div>
                        <h4 class="fw-extrabold text-dark mb-0">Pembelajaran Mendalam</h4>
                        <span class="badge badge-sakti badge-sakti-deep">Deep Learning &amp; Pedagogi</span>
                    </div>
                </div>
                <p class="text-secondary mb-4">Pengembangan modul pedagogi berkesadaran (Mindful, Meaningful, Joyful), strategi tanya jawab berjenjang kognitif tinggi, dan asesmen formatif.</p>
                <div class="mt-auto pt-2 border-top d-flex justify-content-between align-items-center">
                    <span class="small text-muted">{{ $deepLearning->count() }} Konten Tersedia</span>
                    <a href="{{ route('sakti.pembelajaran-mendalam') }}" class="btn btn-info text-white btn-sm rounded-pill px-4 fw-bold">
                        Masuk Modul <i class="fa-solid fa-arrow-right ms-1"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- Module 2: Rumah Pendidikan -->
        <div class="col-md-6">
            <div class="card card-custom p-4 bg-white h-100 border-start border-5 border-success">
                <div class="d-flex align-items-center gap-3 mb-3">
                    <div class="rounded-4 bg-success bg-opacity-10 text-success p-3 fs-3">
                        <i class="fa-solid fa-folder-open"></i>
                    </div>
                    <div>
                        <h4 class="fw-extrabold text-dark mb-0">Rumah Pendidikan</h4>
                        <span class="badge badge-sakti badge-sakti-rumah">Perangkat &amp; Modul Ajar</span>
                    </div>
                </div>
                <p class="text-secondary mb-4">Repositori publik berbagi Perangkat Ajar, Modul Tematik, Lembar Kerja Peserta Didik (LKPD), Alur Tujuan Pembelajaran, dan E-Book.</p>
                <div class="mt-auto pt-2 border-top d-flex justify-content-between align-items-center">
                    <span class="small text-muted">{{ $rumahPendidikan->count() }} Perangkat Ajar</span>
                    <a href="{{ route('sakti.rumah-pendidikan') }}" class="btn btn-success btn-sm rounded-pill px-4 fw-bold">
                        Masuk Modul <i class="fa-solid fa-arrow-right ms-1"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- Module 3: PID -->
        <div class="col-md-6">
            <div class="card card-custom p-4 bg-white h-100 border-start border-5 border-warning">
                <div class="d-flex align-items-center gap-3 mb-3">
                    <div class="rounded-4 bg-warning bg-opacity-10 text-warning p-3 fs-3">
                        <i class="fa-solid fa-bullhorn"></i>
                    </div>
                    <div>
                        <h4 class="fw-extrabold text-dark mb-0">PID (Pusat Informasi Digital)</h4>
                        <span class="badge badge-sakti badge-sakti-pid">Portal Berita &amp; Edaran</span>
                    </div>
                </div>
                <p class="text-secondary mb-4">Pusat siaran berita resmi Pengurus Besar PGRI, rilis edaran organisasi, artikel isu pendidikan nasional, dan advokasi hukum guru.</p>
                <div class="mt-auto pt-2 border-top d-flex justify-content-between align-items-center">
                    <span class="small text-muted">{{ $pid->count() }} Berita &amp; Rilis</span>
                    <a href="{{ route('sakti.pid') }}" class="btn btn-warning text-dark btn-sm rounded-pill px-4 fw-bold">
                        Masuk Modul <i class="fa-solid fa-arrow-right ms-1"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- Module 4: Koding / KKA -->
        <div class="col-md-6">
            <div class="card card-custom p-4 bg-white h-100 border-start border-5 border-purple" style="border-start-color: #9333ea !important;">
                <div class="d-flex align-items-center gap-3 mb-3">
                    <div class="rounded-4 bg-purple bg-opacity-10 p-3 fs-3" style="color: #9333ea; background-color: #f3e8ff;">
                        <i class="fa-solid fa-code"></i>
                    </div>
                    <div>
                        <h4 class="fw-extrabold text-dark mb-0">Koding / KKA &amp; AI</h4>
                        <span class="badge badge-sakti badge-sakti-koding">Berpikir Komputasional</span>
                    </div>
                </div>
                <p class="text-secondary mb-4">Modul pelatihan Berpikir Komputasional (KKA), dasar koding Scratch/Python, dan pemanfaatan Generative AI dalam proses pembelajaran.</p>
                <div class="mt-auto pt-2 border-top d-flex justify-content-between align-items-center">
                    <span class="small text-muted">{{ $kodingKka->count() }} Panduan Koding</span>
                    <a href="{{ route('sakti.koding-kka') }}" class="btn btn-primary btn-sm rounded-pill px-4 fw-bold" style="background-color: #9333ea; border-color: #9333ea;">
                        Masuk Modul <i class="fa-solid fa-arrow-right ms-1"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
