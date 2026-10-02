@extends('layouts.app')

@section('title', 'Kontak & Aspirasi — PGRI (Persatuan Guru Republik Indonesia)')

@section('content')
@php
    $igHandle = $office['instagram'] ?? '@pbpgri_official';
    $igUrl = str_starts_with($igHandle, 'http') ? $igHandle : 'https://www.instagram.com/' . ltrim($igHandle, '@');

    $ttHandle = $office['tiktok'] ?? '@pbpgri_official';
    $ttUrl = str_starts_with($ttHandle, 'http') ? $ttHandle : 'https://www.tiktok.com/@' . ltrim($ttHandle, '@');

    $waRaw = $office['whatsapp'] ?? '0812-3456-7890';
    $waNumber = preg_replace('/[^0-9]/', '', $waRaw);
    if (str_starts_with($waNumber, '0')) {
        $waNumber = '62' . substr($waNumber, 1);
    }
    $waUrl = !empty($waNumber) ? "https://wa.me/{$waNumber}" : "#";
@endphp

<!-- HEADER -->
<div class="bg-danger text-white py-5" style="background: linear-gradient(135deg, #0f172a 0%, #b91c1c 50%, #dc2626 100%);">
    <div class="container py-3 text-center">
        <span class="badge bg-warning text-dark rounded-pill px-3 py-2 fw-bold mb-3">LAYANAN KOMUNIKASI &amp; ASPIRASI</span>
        <h1 class="display-5 fw-extrabold text-white tracking-tight">Kontak Pengurus Besar PGRI</h1>
        <p class="lead opacity-90 max-w-2xl mx-auto mb-0" style="max-width: 750px;">
            Sekretariat PB PGRI melayani aspirasi, konsultasi perlindungan hukum, dan komunikasi anggota guru se-Indonesia.
        </p>
    </div>
</div>

<div class="container py-5">
    @if(session('success'))
    <div class="alert alert-success border-0 rounded-4 shadow-sm p-4 mb-4 d-flex align-items-center gap-3">
        <i class="fa-solid fa-circle-check fs-2 text-success"></i>
        <div>
            <h5 class="fw-bold mb-1">Berhasil Terkirim!</h5>
            <div class="small">{{ session('success') }}</div>
        </div>
    </div>
    @endif

    <div class="row g-5">
        <!-- FORM ASPIRASI -->
        <div class="col-lg-7">
            <div class="card card-custom p-4 p-md-5 bg-white shadow-sm rounded-4">
                <h3 class="fw-extrabold text-dark mb-2"><i class="fa-solid fa-paper-plane text-danger me-2"></i> Form Aspirasi &amp; Kontak</h3>
                <p class="text-muted small mb-4">Sampaikan pertanyaan, masukan, maupun permohonan advokasi guru kepada Pengurus Besar PGRI.</p>

                <form action="{{ route('contact.store') }}" method="POST">
                    @csrf
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold small text-dark">Nama Lengkap <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control bg-light border-0 py-2.5 rounded-3" placeholder="Nama Anda" value="{{ old('name') }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold small text-dark">Email Aktif <span class="text-danger">*</span></label>
                            <input type="email" name="email" class="form-control bg-light border-0 py-2.5 rounded-3" placeholder="email@contoh.com" value="{{ old('email') }}" required>
                        </div>
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold small text-dark">No. Telepon / WhatsApp</label>
                            <input type="text" name="phone" class="form-control bg-light border-0 py-2.5 rounded-3" placeholder="0812xxxxxxx" value="{{ old('phone') }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold small text-dark">Instansi / Unit Kerja Sekolah</label>
                            <input type="text" name="school_unit" class="form-control bg-light border-0 py-2.5 rounded-3" placeholder="SD/SMP/SMA Negeri..." value="{{ old('school_unit') }}">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold small text-dark">Subjek Pesan / Kategori Aspirasi <span class="text-danger">*</span></label>
                        <select name="subject" class="form-select bg-light border-0 py-2.5 rounded-3" required>
                            <option value="">-- Pilih Subjek Pesan --</option>
                            <option value="Aspirasi & Masukan Keanggotaan">Aspirasi &amp; Masukan Keanggotaan</option>
                            <option value="Konsultasi Perlindungan Hukum Guru">Konsultasi Perlindungan Hukum Guru</option>
                            <option value="Pertanyaan Layanan SAKTI">Pertanyaan Layanan SAKTI (Pembelajaran/Koding/AI)</option>
                            <option value="Undangan / Kerjasama Organisasi">Undangan / Kerjasama Organisasi</option>
                            <option value="Lainnya">Lainnya</option>
                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-bold small text-dark">Isi Pesan / Aspirasi <span class="text-danger">*</span></label>
                        <textarea name="message" rows="5" class="form-control bg-light border-0 p-3 rounded-3" placeholder="Tuliskan aspirasi atau detail pertanyaan Anda..." required>{{ old('message') }}</textarea>
                    </div>

                    <button type="submit" class="btn btn-danger btn-lg rounded-pill px-5 fw-bold shadow-sm">
                        <i class="fa-solid fa-paper-plane me-2"></i> Kirim Pesan / Aspirasi
                    </button>
                </form>
            </div>
        </div>

        <!-- INFO SEKRETARIAT & SOSIAL MEDIA -->
        <div class="col-lg-5">
            <div class="card card-custom p-4 bg-white mb-4 rounded-4 shadow-sm">
                <h4 class="fw-extrabold text-dark mb-4 pb-2 border-bottom d-flex items-center gap-2">
                    <i class="fa-solid fa-building text-danger"></i>
                    <span>Kantor Sekretariat</span>
                </h4>

                <div class="d-flex flex-column gap-3.5 small">
                    <!-- Alamat -->
                    <div class="d-flex align-items-start gap-3">
                        <div class="rounded-circle bg-danger bg-opacity-10 text-danger p-2 fs-5 flex-shrink-0 d-flex align-items-center justify-center" style="width: 42px; height: 42px;">
                            <i class="fa-solid fa-location-dot"></i>
                        </div>
                        <div>
                            <div class="fw-bold text-dark">Alamat Kantor</div>
                            <div class="text-muted leading-relaxed">{{ $office['address'] }}</div>
                        </div>
                    </div>

                    <!-- Telepon -->
                    <div class="d-flex align-items-start gap-3">
                        <div class="rounded-circle bg-warning bg-opacity-10 text-warning p-2 fs-5 flex-shrink-0 d-flex align-items-center justify-center" style="width: 42px; height: 42px;">
                            <i class="fa-solid fa-phone"></i>
                        </div>
                        <div>
                            <div class="fw-bold text-dark">Telepon Sekretariat</div>
                            <div class="text-muted">{{ $office['phone'] }}</div>
                        </div>
                    </div>

                    <!-- Email -->
                    <div class="d-flex align-items-start gap-3">
                        <div class="rounded-circle bg-info bg-opacity-10 text-info p-2 fs-5 flex-shrink-0 d-flex align-items-center justify-center" style="width: 42px; height: 42px;">
                            <i class="fa-solid fa-envelope"></i>
                        </div>
                        <div>
                            <div class="fw-bold text-dark">Email Resmi</div>
                            <a href="mailto:{{ $office['email'] }}" class="text-decoration-none text-info fw-semibold">{{ $office['email'] }}</a>
                        </div>
                    </div>

                    <!-- WhatsApp -->
                    <div class="d-flex align-items-start gap-3">
                        <div class="rounded-circle bg-success bg-opacity-10 text-success p-2 fs-5 flex-shrink-0 d-flex align-items-center justify-center" style="width: 42px; height: 42px;">
                            <i class="fa-brands fa-whatsapp"></i>
                        </div>
                        <div>
                            <div class="fw-bold text-dark">WhatsApp Center</div>
                            <a href="{{ $waUrl }}" target="_blank" class="text-decoration-none text-success fw-bold">
                                {{ $office['whatsapp'] }} <i class="fa-solid fa-arrow-up-right-from-square small ms-1" style="font-size: 0.7rem;"></i>
                            </a>
                        </div>
                    </div>

                    <!-- Instagram -->
                    <div class="d-flex align-items-start gap-3">
                        <div class="rounded-circle p-2 fs-5 text-white flex-shrink-0 d-flex align-items-center justify-center shadow-sm" style="width: 42px; height: 42px; background: linear-gradient(45deg, #f09433 0%, #e6683c 25%, #dc2743 50%, #cc2366 75%, #bc1888 100%);">
                            <i class="fa-brands fa-instagram"></i>
                        </div>
                        <div>
                            <div class="fw-bold text-dark">Instagram Resmi</div>
                            <a href="{{ $igUrl }}" target="_blank" class="text-decoration-none fw-bold" style="color: #bc1888;">
                                {{ $igHandle }} <i class="fa-solid fa-arrow-up-right-from-square small ms-1" style="font-size: 0.7rem;"></i>
                            </a>
                            <div class="text-muted extra-small" style="font-size: 0.72rem;">Dokumentasi &amp; informasi harian kegiatan</div>
                        </div>
                    </div>

                    <!-- TikTok -->
                    <div class="d-flex align-items-start gap-3">
                        <div class="rounded-circle p-2 fs-5 text-white bg-dark flex-shrink-0 d-flex align-items-center justify-center shadow-sm" style="width: 42px; height: 42px;">
                            <i class="fa-brands fa-tiktok"></i>
                        </div>
                        <div>
                            <div class="fw-bold text-dark">TikTok Resmi</div>
                            <a href="{{ $ttUrl }}" target="_blank" class="text-decoration-none text-dark fw-bold">
                                {{ $ttHandle }} <i class="fa-solid fa-arrow-up-right-from-square small ms-1" style="font-size: 0.7rem;"></i>
                            </a>
                            <div class="text-muted extra-small" style="font-size: 0.72rem;">Video edukasi, serba-serbi guru &amp; tren</div>
                        </div>
                    </div>

                    <!-- Jam Operasional -->
                    <div class="d-flex align-items-start gap-3 pt-2 border-top">
                        <div class="rounded-circle bg-primary bg-opacity-10 text-primary p-2 fs-5 flex-shrink-0 d-flex align-items-center justify-center" style="width: 42px; height: 42px;">
                            <i class="fa-solid fa-clock"></i>
                        </div>
                        <div>
                            <div class="fw-bold text-dark">Jam Operasional Sekretariat</div>
                            <div class="text-muted">{{ $office['hours'] }}</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- QUICK ACCESS MEDIA SOSIAL RESMI -->
            <div class="card card-custom p-4 bg-white mb-4 rounded-4 shadow-sm border-0">
                <h6 class="fw-bold text-dark mb-3 text-uppercase tracking-wider small">
                    <i class="fa-solid fa-share-nodes text-danger me-1"></i> Terhubung di Media Sosial
                </h6>
                <div class="d-grid gap-2">
                    <a href="{{ $igUrl }}" target="_blank" class="btn text-white fw-bold py-2 rounded-pill d-flex align-items-center justify-content-center gap-2 shadow-sm" style="background: linear-gradient(45deg, #f09433 0%, #e6683c 25%, #dc2743 50%, #cc2366 75%, #bc1888 100%);">
                        <i class="fa-brands fa-instagram fs-5"></i>
                        <span>Ikuti Kami di Instagram</span>
                    </a>
                    <a href="{{ $ttUrl }}" target="_blank" class="btn btn-dark text-white fw-bold py-2 rounded-pill d-flex align-items-center justify-content-center gap-2 shadow-sm">
                        <i class="fa-brands fa-tiktok fs-5"></i>
                        <span>Ikuti Kami di TikTok</span>
                    </a>
                    <a href="{{ $waUrl }}" target="_blank" class="btn btn-success text-white fw-bold py-2 rounded-pill d-flex align-items-center justify-content-center gap-2 shadow-sm">
                        <i class="fa-brands fa-whatsapp fs-5"></i>
                        <span>Chat WhatsApp Center</span>
                    </a>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
