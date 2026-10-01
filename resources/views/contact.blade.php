@extends('layouts.app')

@section('title', 'Kontak & Aspirasi — PGRI (Persatuan Guru Republik Indonesia)')

@section('content')
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
            <div class="card card-custom p-4 p-md-5 bg-white shadow-sm">
                <h3 class="fw-extrabold text-dark mb-2"><i class="fa-solid fa-paper-plane text-danger me-2"></i> Form Aspirasi &amp; Kontak</h3>
                <p class="text-muted small mb-4">Sampaikan pertanyaan, masukan, maupun permohonan advokasi guru kepada Pengurus Besar PGRI.</p>

                <form action="{{ route('contact.store') }}" method="POST">
                    @csrf
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold small text-dark">Nama Lengkap <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control bg-light border-0 py-2" placeholder="Nama Anda" value="{{ old('name') }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold small text-dark">Email Aktif <span class="text-danger">*</span></label>
                            <input type="email" name="email" class="form-control bg-light border-0 py-2" placeholder="email@contoh.com" value="{{ old('email') }}" required>
                        </div>
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold small text-dark">No. Telepon / WhatsApp</label>
                            <input type="text" name="phone" class="form-control bg-light border-0 py-2" placeholder="0812xxxxxxx" value="{{ old('phone') }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold small text-dark">Instansi / Unit Kerja Sekolah</label>
                            <input type="text" name="school_unit" class="form-control bg-light border-0 py-2" placeholder="SD/SMP/SMA Negeri..." value="{{ old('school_unit') }}">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold small text-dark">Subjek Pesan / Kategori Aspirasi <span class="text-danger">*</span></label>
                        <select name="subject" class="form-select bg-light border-0 py-2" required>
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
                        <textarea name="message" rows="5" class="form-control bg-light border-0 p-3" placeholder="Tuliskan aspirasi atau detail pertanyaan Anda..." required>{{ old('message') }}</textarea>
                    </div>

                    <button type="submit" class="btn btn-pgri btn-lg rounded-pill px-5">
                        <i class="fa-solid fa-paper-plane me-2"></i> Kirim Pesan / Aspirasi
                    </button>
                </form>
            </div>
        </div>

        <!-- INFO SEKRETARIAT -->
        <div class="col-lg-5">
            <div class="card card-custom p-4 bg-white mb-4">
                <h4 class="fw-extrabold text-dark mb-3"><i class="fa-solid fa-building text-danger me-2"></i> Kantor Sekretariat</h4>
                <div class="d-flex flex-column gap-3 small">
                    <div class="d-flex align-items-start gap-3">
                        <div class="rounded-circle bg-danger bg-opacity-10 text-danger p-2 fs-5">
                            <i class="fa-solid fa-location-dot"></i>
                        </div>
                        <div>
                            <div class="fw-bold text-dark">Alamat Kantor</div>
                            <div class="text-muted">{{ $office['address'] }}</div>
                        </div>
                    </div>

                    <div class="d-flex align-items-start gap-3">
                        <div class="rounded-circle bg-warning bg-opacity-10 text-warning p-2 fs-5">
                            <i class="fa-solid fa-phone"></i>
                        </div>
                        <div>
                            <div class="fw-bold text-dark">Telepon Sekretariat</div>
                            <div class="text-muted">{{ $office['phone'] }}</div>
                        </div>
                    </div>

                    <div class="d-flex align-items-start gap-3">
                        <div class="rounded-circle bg-info bg-opacity-10 text-info p-2 fs-5">
                            <i class="fa-solid fa-envelope"></i>
                        </div>
                        <div>
                            <div class="fw-bold text-dark">Email Resmi</div>
                            <div class="text-muted">{{ $office['email'] }}</div>
                        </div>
                    </div>

                    <div class="d-flex align-items-start gap-3">
                        <div class="rounded-circle bg-success bg-opacity-10 text-success p-2 fs-5">
                            <i class="fa-brands fa-whatsapp"></i>
                        </div>
                        <div>
                            <div class="fw-bold text-dark">WhatsApp Center</div>
                            <div class="text-muted">{{ $office['whatsapp'] }}</div>
                        </div>
                    </div>

                    <div class="d-flex align-items-start gap-3">
                        <div class="rounded-circle bg-primary bg-opacity-10 text-primary p-2 fs-5">
                            <i class="fa-solid fa-clock"></i>
                        </div>
                        <div>
                            <div class="fw-bold text-dark">Jam Operasional Sekretariat</div>
                            <div class="text-muted">{{ $office['hours'] }}</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- MAP / CALLOUT -->
            <div class="card card-custom p-4 text-white" style="background: linear-gradient(135deg, #0f172a 0%, #1e1b4b 100%);">
                <h5 class="fw-bold mb-2"><i class="fa-solid fa-shield-cat text-warning me-2"></i> LKBH PGRI</h5>
                <p class="small opacity-80 mb-3">Lembaga Konsultasi &amp; Bantuan Hukum (LKBH) PGRI memberikan pendampingan dan perlindungan hukum penuh bagi guru anggota PGRI.</p>
                <span class="badge bg-warning text-dark rounded-pill px-3 py-2 fw-bold me-auto">Layanan Bebas Biaya Anggota</span>
            </div>
        </div>
    </div>
</div>
@endsection
