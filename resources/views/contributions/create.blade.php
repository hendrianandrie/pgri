@extends('layouts.app')

@section('title', 'Kirim Berita & Modul SAKTI — Sahabat Guru PGRI')

@section('content')
<!-- HERO HEADER -->
<div class="bg-dark text-white py-5 position-relative overflow-hidden" 
     style="background: linear-gradient(135deg, #090d16 0%, #1e1b4b 60%, #991b1b 100%);">
    <div class="container py-4 position-relative" style="z-index: 2;">
        <div class="row align-items-center g-4">
            <div class="col-lg-8">
                <div class="d-inline-flex align-items-center gap-2 px-3 py-1.5 rounded-pill bg-danger bg-opacity-25 border border-danger border-opacity-50 text-warning extra-small fw-bold mb-3">
                    <i class="fa-solid fa-feather-pointed"></i>
                    <span>Ruang Kontributor Sahabat Guru</span>
                </div>
                <h1 class="display-6 fw-extrabold text-white tracking-tight mb-3">
                    Bagikan Berita Kegiatan & Modul Ajar Anda
                </h1>
                <p class="lead text-white-50 fs-6 mb-0" style="max-width: 680px;">
                    PGRI membuka ruang bagi seluruh guru, tenaga kependidikan, dan pengurus untuk mempublikasikan reportase kegiatan positif sekolah serta modul pembelajaran inovatif agar menginspirasi ribuan pendidik lainnya.
                </p>
            </div>
            <div class="col-lg-4 text-lg-end d-none d-lg-block">
                <div class="p-3.5 rounded-4 bg-white bg-opacity-10 backdrop-blur border border-white border-opacity-15 text-start d-inline-block shadow-lg" style="max-width: 320px;">
                    <div class="d-flex align-items-center gap-3 mb-2">
                        <div class="rounded-circle bg-warning text-dark d-flex align-items-center justify-content-center flex-shrink-0" style="width: 36px; height: 36px;">
                            <i class="fa-solid fa-shield-halved"></i>
                        </div>
                        <h6 class="fw-bold text-white mb-0 small">Alur Cepat & Transparan</h6>
                    </div>
                    <p class="extra-small text-white-75 mb-0 leading-relaxed">
                        Naskah Anda akan langsung masuk ke antrean kurasi Tim Redaksi PGRI dan segera diterbitkan setelah verifikasi kelayakan.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- FORM SECTION -->
<div class="py-5 bg-slate-50 min-vh-100">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10 col-xl-9">

                <!-- Alert Messages -->
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show rounded-4 p-4 mb-4 border-0 shadow-sm d-flex align-items-start gap-3" role="alert">
                        <div class="rounded-circle bg-success text-white d-flex align-items-center justify-content-center flex-shrink-0 mt-0.5" style="width: 38px; height: 38px;">
                            <i class="fa-solid fa-check fs-5"></i>
                        </div>
                        <div class="flex-grow-1">
                            <h5 class="fw-bold text-success mb-1">Pengiriman Berhasil!</h5>
                            <p class="small mb-0 leading-relaxed text-dark">{{ session('success') }}</p>
                        </div>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show rounded-4 p-4 mb-4 border-0 shadow-sm" role="alert">
                        <div class="d-flex align-items-start gap-3">
                            <i class="fa-solid fa-triangle-exclamation fs-3 text-danger flex-shrink-0 mt-1"></i>
                            <div>
                                <h6 class="fw-bold text-danger mb-1">Mohon lengkapi formulir dengan benar:</h6>
                                <ul class="small mb-0 ps-3">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <form action="{{ route('contributions.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                    @csrf

                    <!-- Anti-spam Honeypot (Hidden) -->
                    <div style="display: none !important;" aria-hidden="true">
                        <label for="website_hp">Website Field</label>
                        <input type="text" name="website_hp" id="website_hp" tabindex="-1" autocomplete="off">
                    </div>

                    <!-- CARD 1: JENIS KONTEN -->
                    <div class="bg-white rounded-4 p-4 p-md-5 shadow-sm border border-slate-200 mb-4">
                        <div class="d-flex align-items-center gap-2 pb-3 mb-4 border-bottom">
                            <span class="badge bg-danger rounded-circle p-2 text-white fw-bold d-inline-flex align-items-center justify-content-center" style="width: 26px; height: 26px; font-size: 0.75rem;">1</span>
                            <h4 class="fs-6 fw-bold text-dark mb-0">Pilih Kategori Kontribusi Anda</h4>
                        </div>

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="card h-100 p-4 rounded-3 border-2 cursor-pointer transition text-start contribution-type-card {{ old('type', 'news') === 'news' ? 'border-danger bg-danger-subtle bg-opacity-10' : 'border-slate-200' }}" for="type_news">
                                    <div class="d-flex align-items-center justify-content-between mb-3">
                                        <div class="rounded-circle bg-danger text-white d-flex align-items-center justify-content-center" style="width: 44px; height: 44px;">
                                            <i class="fa-solid fa-newspaper fs-5"></i>
                                        </div>
                                        <input class="form-check-input mt-0 fs-5 text-danger" type="radio" name="type" id="type_news" value="news" {{ old('type', 'news') === 'news' ? 'checked' : '' }} onchange="toggleContributionType()">
                                    </div>
                                    <h5 class="fw-bold text-dark fs-6 mb-1">Berita & Reportase Kegiatan</h5>
                                    <p class="text-muted extra-small mb-0 leading-relaxed">
                                        Liputan acara sekolah, pelantikan pengurus PGRI, seminar, peringatan hari guru, aksi sosial, atau prestasi guru/siswa.
                                    </p>
                                </label>
                            </div>

                            <div class="col-md-6">
                                <label class="card h-100 p-4 rounded-3 border-2 cursor-pointer transition text-start contribution-type-card {{ old('type') === 'sakti' ? 'border-danger bg-danger-subtle bg-opacity-10' : 'border-slate-200' }}" for="type_sakti">
                                    <div class="d-flex align-items-center justify-content-between mb-3">
                                        <div class="rounded-circle bg-purple text-white d-flex align-items-center justify-content-center" style="width: 44px; height: 44px; background-color: #9333ea;">
                                            <i class="fa-solid fa-wand-magic-sparkles fs-5"></i>
                                        </div>
                                        <input class="form-check-input mt-0 fs-5 text-danger" type="radio" name="type" id="type_sakti" value="sakti" {{ old('type') === 'sakti' ? 'checked' : '' }} onchange="toggleContributionType()">
                                    </div>
                                    <h5 class="fw-bold text-dark fs-6 mb-1">Modul & Bahan Ajar SAKTI</h5>
                                    <p class="text-muted extra-small mb-0 leading-relaxed">
                                        Modul pembelajaran mendalam, media interaktif (PID), materi koding/AI, atau perangkat ajar di Rumah Pendidikan.
                                    </p>
                                </label>
                            </div>
                        </div>
                    </div>

                    <!-- CARD 2: DETAIL MATERI / BERITA -->
                    <div class="bg-white rounded-4 p-4 p-md-5 shadow-sm border border-slate-200 mb-4">
                        <div class="d-flex align-items-center gap-2 pb-3 mb-4 border-bottom">
                            <span class="badge bg-danger rounded-circle p-2 text-white fw-bold d-inline-flex align-items-center justify-content-center" style="width: 26px; height: 26px; font-size: 0.75rem;">2</span>
                            <h4 class="fs-6 fw-bold text-dark mb-0">Isi Naskah & Dokumen</h4>
                        </div>

                        <!-- SAKTI Specific Fields (Shown only when type=sakti) -->
                        <div id="sakti_fields" class="row g-3 mb-4 p-3 bg-light rounded-3 border border-slate-200" style="display: {{ old('type') === 'sakti' ? 'flex' : 'none' }};">
                            <div class="col-md-6">
                                <label for="sakti_category" class="form-label extra-small fw-bold text-dark mb-1">
                                    Pilar SAKTI PGRI <span class="text-danger">*</span>
                                </label>
                                <select name="sakti_category" id="sakti_category" class="form-select form-select-sm rounded-3">
                                    <option value="" disabled {{ old('sakti_category') ? '' : 'selected' }}>-- Pilih Pilar Modul --</option>
                                    <option value="pembelajaran_mendalam" {{ old('sakti_category') === 'pembelajaran_mendalam' ? 'selected' : '' }}>🧠 Pembelajaran Mendalam (Deep Learning)</option>
                                    <option value="rumah_pendidikan" {{ old('sakti_category') === 'rumah_pendidikan' ? 'selected' : '' }}>🏫 Rumah Pendidikan (Bahan Ajar & Modul)</option>
                                    <option value="pid" {{ old('sakti_category') === 'pid' ? 'selected' : '' }}>📢 Papan Interaktif Digital (PID)</option>
                                    <option value="koding_kka" {{ old('sakti_category') === 'koding_kka' ? 'selected' : '' }}>💻 Koding & Kecerdasan Buatan (KKA)</option>
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label for="badge" class="form-label extra-small fw-bold text-dark mb-1">
                                    Jenjang Target Pembaca <span class="text-danger">*</span>
                                </label>
                                <select name="badge" id="badge" class="form-select form-select-sm rounded-3">
                                    <option value="Umum" {{ old('badge') === 'Umum' ? 'selected' : '' }}>Umum (Semua Tingkat)</option>
                                    <option value="PAUD" {{ old('badge') === 'PAUD' ? 'selected' : '' }}>PAUD / TK</option>
                                    <option value="SD" {{ old('badge') === 'SD' ? 'selected' : '' }}>SD / MI</option>
                                    <option value="SMP" {{ old('badge') === 'SMP' ? 'selected' : '' }}>SMP / MTs</option>
                                    <option value="SMA" {{ old('badge') === 'SMA' ? 'selected' : '' }}>SMA / MA</option>
                                    <option value="SMK" {{ old('badge') === 'SMK' ? 'selected' : '' }}>SMK</option>
                                </select>
                            </div>

                            <div class="col-12">
                                <label for="file_url" class="form-label extra-small fw-bold text-dark mb-1">
                                    Tautan Dokumen / Modul Online (Opsional)
                                </label>
                                <div class="input-group input-group-sm">
                                    <span class="input-group-text bg-white"><i class="fa-solid fa-link text-muted"></i></span>
                                    <input type="url" name="file_url" id="file_url" value="{{ old('file_url') }}"
                                           class="form-control rounded-end-3" placeholder="https://drive.google.com/... atau https://canva.com/...">
                                </div>
                                <span class="text-muted extra-small" style="font-size: 0.72rem;">
                                    Tautkan Google Drive, Slide presentasi, atau PDF modul jika ada agar guru lain dapat langsung mengunduhnya.
                                </span>
                            </div>
                        </div>

                        <!-- News Specific Field (Shown only when type=news) -->
                        <div id="news_fields" class="mb-3" style="display: {{ old('type', 'news') === 'news' ? 'block' : 'none' }};">
                            <label for="event_date" class="form-label extra-small fw-bold text-dark mb-1">
                                Tanggal Pelaksanaan Kegiatan
                            </label>
                            <input type="date" name="event_date" id="event_date" value="{{ old('event_date', date('Y-m-d')) }}"
                                   class="form-control form-control-sm rounded-3" style="max-width: 250px;">
                        </div>

                        <!-- Title -->
                        <div class="mb-3">
                            <label for="title" class="form-label extra-small fw-bold text-dark mb-1">
                                Judul Naskah / Modul <span class="text-danger">*</span>
                            </label>
                            <input type="text" name="title" id="title" value="{{ old('title') }}" required
                                   class="form-control rounded-3" placeholder="Contoh: Workshop Integrasi Kecerdasan Artifisial dalam Pembelajaran Matematika SD">
                        </div>

                        <!-- Summary -->
                        <div class="mb-3">
                            <label for="summary" class="form-label extra-small fw-bold text-dark mb-1">
                                Ringkasan Singkat / Abstrak (1 - 2 Kalimat)
                            </label>
                            <textarea name="summary" id="summary" rows="2" class="form-control form-control-sm rounded-3"
                                      placeholder="Ringkasan inti yang akan muncul pada cuplikan beranda...">{{ old('summary') }}</textarea>
                        </div>

                        <!-- Content -->
                        <div class="mb-4">
                            <label for="content" class="form-label extra-small fw-bold text-dark mb-1">
                                Isi Lengkap Berita / Uraian Materi <span class="text-danger">*</span>
                            </label>
                            <textarea name="content" id="content" rows="9" required class="form-control rounded-3"
                                      placeholder="Tuliskan naskah lengkap berita (memuat 5W+1H: apa acaranya, siapa yang hadir, kapan, di mana, dan tujuannya) atau uraian panduan materi modul...">{{ old('content') }}</textarea>
                            <div class="d-flex justify-content-between text-muted extra-small mt-1">
                                <span>Gunakan pemisah enter antar-paragraf agar mudah dibaca.</span>
                                <span>Minimal 50 karakter</span>
                            </div>
                        </div>

                        <!-- Image File Upload -->
                        <div class="mb-2">
                            <label for="image_file" class="form-label extra-small fw-bold text-dark mb-1">
                                Foto Dokumentasi Kegiatan / Gambar Sampul Modul
                            </label>
                            <input type="file" name="image_file" id="image_file" accept="image/*"
                                   class="form-control form-control-sm rounded-3">
                            <span class="text-muted extra-small" style="font-size: 0.72rem;">
                                Format: JPG, PNG, atau WebP. Maksimal ukuran 5 MB. Pastikan foto memiliki orientasi horizontal (lanskap) dan pencahayaan yang jelas.
                            </span>
                        </div>

                    </div>

                    <!-- CARD 3: IDENTITAS KONTRIBUTOR -->
                    <div class="bg-white rounded-4 p-4 p-md-5 shadow-sm border border-slate-200 mb-4">
                        <div class="d-flex align-items-center gap-2 pb-3 mb-4 border-bottom">
                            <span class="badge bg-danger rounded-circle p-2 text-white fw-bold d-inline-flex align-items-center justify-content-center" style="width: 26px; height: 26px; font-size: 0.75rem;">3</span>
                            <h4 class="fs-6 fw-bold text-dark mb-0">Identitas Kontributor / Guru</h4>
                        </div>

                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label for="author_name" class="form-label extra-small fw-bold text-dark mb-1">
                                    Nama Lengkap Penulis <span class="text-danger">*</span>
                                </label>
                                <input type="text" name="author_name" id="author_name" value="{{ old('author_name') }}" required
                                       class="form-control form-control-sm rounded-3" placeholder="Contoh: Dra. Hj. Siti Rahmawati, M.Pd.">
                            </div>

                            <div class="col-md-6">
                                <label for="school_origin" class="form-label extra-small fw-bold text-dark mb-1">
                                    Asal Sekolah / Cabang PGRI <span class="text-danger">*</span>
                                </label>
                                <input type="text" name="school_origin" id="school_origin" value="{{ old('school_origin') }}" required
                                       class="form-control form-control-sm rounded-3" placeholder="Contoh: SMPN 1 Ciamis / PGRI Cabang Ciamis">
                            </div>

                            <div class="col-md-6">
                                <label for="author_email" class="form-label extra-small fw-bold text-dark mb-1">
                                    Alamat Email Aktif <span class="text-danger">*</span>
                                </label>
                                <input type="email" name="author_email" id="author_email" value="{{ old('author_email') }}" required
                                       class="form-control form-control-sm rounded-3" placeholder="siti.guru@gmail.com">
                            </div>

                            <div class="col-md-6">
                                <label for="author_phone" class="form-label extra-small fw-bold text-dark mb-1">
                                    Nomor WhatsApp Aktif <span class="text-danger">*</span>
                                </label>
                                <input type="tel" name="author_phone" id="author_phone" value="{{ old('author_phone') }}" required
                                       class="form-control form-control-sm rounded-3" placeholder="Contoh: 081234567890">
                                <span class="text-muted extra-small" style="font-size: 0.72rem;">
                                    Diperlukan agar tim redaksi dapat mengabari saat naskah Anda tayang atau jika memerlukan verifikasi.
                                </span>
                            </div>
                        </div>

                        <!-- Agreement Checkbox -->
                        <div class="p-3 bg-slate-50 border border-slate-200 rounded-3 mt-4">
                            <div class="form-check">
                                <input class="form-check-input text-danger" type="checkbox" name="agreement" id="agreement" value="1" {{ old('agreement') ? 'checked' : '' }} required>
                                <label class="form-check-label extra-small text-dark leading-relaxed" for="agreement">
                                    <strong>Pernyataan Keaslian & Kebijakan Redaksi:</strong> Saya menyatakan bahwa isi naskah dan dokumentasi ini merupakan karya yang orisinal, bebas dari unsur plagiarisme, tidak mengandung ujaran kebencian/SARA, dan bersedia disunting seperlunya oleh Tim Redaksi PGRI demi keselarasan tata bahasa.
                                </label>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="text-end pt-4">
                            <button type="submit" class="btn btn-danger rounded-pill px-5 py-2.5 fw-bold shadow d-inline-flex align-items-center gap-2">
                                <i class="fa-solid fa-paper-plane"></i>
                                <span>Kirim Naskah ke Redaksi PGRI</span>
                            </button>
                        </div>
                    </div>

                </form>

            </div>
        </div>
    </div>
</div>

<script>
    function toggleContributionType() {
        const isSakti = document.getElementById('type_sakti').checked;
        const saktiFields = document.getElementById('sakti_fields');
        const newsFields = document.getElementById('news_fields');
        const cards = document.querySelectorAll('.contribution-type-card');

        if (isSakti) {
            saktiFields.style.display = 'flex';
            newsFields.style.display = 'none';
        } else {
            saktiFields.style.display = 'none';
            newsFields.style.display = 'block';
        }

        cards.forEach(card => {
            const radio = card.querySelector('input[type="radio"]');
            if (radio.checked) {
                card.classList.add('border-danger', 'bg-danger-subtle', 'bg-opacity-10');
                card.classList.remove('border-slate-200');
            } else {
                card.classList.remove('border-danger', 'bg-danger-subtle', 'bg-opacity-10');
                card.classList.add('border-slate-200');
            }
        });
    }
</script>
@endsection
