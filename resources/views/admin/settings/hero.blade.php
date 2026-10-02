@extends('admin.layout')

@section('title', 'Pengaturan Banner Beranda')
@section('page_title', 'Pengaturan Banner Beranda (Hero Section)')

@section('content')
<div class="max-w-5xl mx-auto space-y-6">

    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 md:p-8">
        <div class="border-b border-slate-100 pb-4 mb-6 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
            <div class="flex items-center gap-3">
                <div class="w-11 h-11 rounded-xl bg-red-50 text-red-600 flex items-center justify-center font-bold text-xl border border-red-100">
                    <i class="fa-solid fa-panorama"></i>
                </div>
                <div>
                    <h2 class="text-lg font-bold text-slate-800">Banner & Hero Beranda</h2>
                    <p class="text-xs text-slate-500">Kelola judul, deskripsi, foto banner utama, tombol aksi, dan badge di beranda website</p>
                </div>
            </div>
            <a href="{{ route('home') }}" target="_blank" class="text-xs font-bold text-red-700 hover:text-red-800 bg-red-50 hover:bg-red-100 px-3 py-2 rounded-lg border border-red-200 transition inline-flex items-center gap-1.5 self-start sm:self-center">
                <i class="fa-solid fa-arrow-up-right-from-square"></i>
                <span>Lihat Halaman Beranda</span>
            </a>
        </div>

        <form action="{{ route('admin.hero-settings.update') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
            @csrf

            <!-- 1. KONTEN TEKS UTAMA -->
            <div class="space-y-4">
                <div class="flex items-center gap-2 pb-2 border-b border-slate-100">
                    <span class="w-6 h-6 rounded-full bg-red-100 text-red-700 font-bold text-xs flex items-center justify-center">1</span>
                    <h3 class="text-sm font-bold text-slate-800 uppercase tracking-wide">Judul & Teks Utama</h3>
                </div>

                <!-- Badge Atas -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1 flex items-center gap-1.5">
                        <i class="fa-solid fa-tag text-amber-500"></i>
                        <span>Teks Badge Atas</span>
                    </label>
                    <input type="text" name="badge" value="{{ old('badge', $hero['badge']) }}" 
                           placeholder="Contoh: Platform Transformasi Edukasi & Profesi Guru" 
                           class="w-full bg-slate-50 border border-slate-300 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-red-500 focus:bg-white transition">
                </div>

                <!-- Judul Utama -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1 flex items-center gap-1.5">
                        <i class="fa-solid fa-heading text-red-600"></i>
                        <span>Judul Utama (Headline)</span>
                        <span class="text-red-500">*</span>
                    </label>
                    <textarea name="title" rows="2" required 
                              placeholder="Masukkan judul utama..." 
                              class="w-full bg-slate-50 border border-slate-300 rounded-xl px-4 py-2.5 text-sm font-medium focus:outline-none focus:border-red-500 focus:bg-white transition">{{ old('title', $hero['title']) }}</textarea>
                    <div class="mt-1 flex flex-wrap items-center gap-2 text-[11px] text-slate-500">
                        <span>Tips warna kata:</span>
                        <code class="bg-red-50 text-red-600 px-1.5 py-0.5 rounded border border-red-200">&lt;span class="text-danger"&gt;Kata&lt;/span&gt;</code> (Merah)
                        <code class="bg-emerald-50 text-emerald-700 px-1.5 py-0.5 rounded border border-emerald-200">&lt;span class="text-success"&gt;Kata&lt;/span&gt;</code> (Hijau)
                        <code class="bg-amber-50 text-amber-700 px-1.5 py-0.5 rounded border border-amber-200">&lt;span class="text-warning"&gt;Kata&lt;/span&gt;</code> (Kuning)
                    </div>
                </div>

                <!-- Paragraf Deskripsi -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1 flex items-center gap-1.5">
                        <i class="fa-solid fa-align-left text-sky-500"></i>
                        <span>Paragraf Deskripsi</span>
                        <span class="text-red-500">*</span>
                    </label>
                    <textarea name="description" rows="3" required 
                              placeholder="Masukkan paragraf pengantar singkat..." 
                              class="w-full bg-slate-50 border border-slate-300 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-red-500 focus:bg-white transition">{{ old('description', $hero['description']) }}</textarea>
                </div>
            </div>

            <!-- 2. TOMBOL AKSI -->
            <div class="space-y-4">
                <div class="flex items-center gap-2 pb-2 border-b border-slate-100">
                    <span class="w-6 h-6 rounded-full bg-red-100 text-red-700 font-bold text-xs flex items-center justify-center">2</span>
                    <h3 class="text-sm font-bold text-slate-800 uppercase tracking-wide">Tombol Aksi (Call To Action)</h3>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Tombol 1 (Merah) -->
                    <div class="p-4 rounded-xl bg-red-50/50 border border-red-100 space-y-3">
                        <div class="flex items-center gap-2 text-xs font-bold text-red-800">
                            <i class="fa-solid fa-circle-dot text-red-600"></i>
                            <span>Tombol Utama (Merah)</span>
                        </div>
                        <div>
                            <label class="block text-[11px] font-bold text-slate-600 mb-1">Teks Tombol</label>
                            <input type="text" name="btn1_text" value="{{ old('btn1_text', $hero['btn1_text']) }}" 
                                   placeholder="Contoh: Jelajahi SAKTI PGRI" 
                                   class="w-full bg-white border border-slate-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-red-500 transition">
                        </div>
                        <div>
                            <label class="block text-[11px] font-bold text-slate-600 mb-1">Tautan / URL Tujuan</label>
                            <input type="text" name="btn1_url" value="{{ old('btn1_url', $hero['btn1_url']) }}" 
                                   placeholder="Contoh: /sakti atau https://..." 
                                   class="w-full bg-white border border-slate-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-red-500 transition">
                        </div>
                    </div>

                    <!-- Tombol 2 (Hijau) -->
                    <div class="p-4 rounded-xl bg-emerald-50/50 border border-emerald-100 space-y-3">
                        <div class="flex items-center gap-2 text-xs font-bold text-emerald-800">
                            <i class="fa-solid fa-circle-dot text-emerald-600"></i>
                            <span>Tombol Sekunder (Hijau)</span>
                        </div>
                        <div>
                            <label class="block text-[11px] font-bold text-slate-600 mb-1">Teks Tombol</label>
                            <input type="text" name="btn2_text" value="{{ old('btn2_text', $hero['btn2_text']) }}" 
                                   placeholder="Contoh: Profil & Sejarah" 
                                   class="w-full bg-white border border-slate-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-emerald-500 transition">
                        </div>
                        <div>
                            <label class="block text-[11px] font-bold text-slate-600 mb-1">Tautan / URL Tujuan</label>
                            <input type="text" name="btn2_url" value="{{ old('btn2_url', $hero['btn2_url']) }}" 
                                   placeholder="Contoh: /profile atau https://..." 
                                   class="w-full bg-white border border-slate-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-emerald-500 transition">
                        </div>
                    </div>
                </div>
            </div>

            <!-- 3. FOTO SLIDER BANNER (FULL-WIDTH HERO BACKGROUND) & KARTU MELAYANG -->
            <div class="space-y-4">
                <div class="flex items-center gap-2 pb-2 border-b border-slate-100">
                    <span class="w-6 h-6 rounded-full bg-red-100 text-red-700 font-bold text-xs flex items-center justify-center">3</span>
                    <h3 class="text-sm font-bold text-slate-800 uppercase tracking-wide flex items-center gap-1.5">
                        <i class="fa-solid fa-images text-red-600"></i>
                        <span>Koleksi Foto Slider Banner (Full-Width Hero Background)</span>
                    </h3>
                </div>

                <!-- Daftar Slide Banner Saat Ini -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2 flex items-center justify-between">
                        <span>Foto Slide Banner yang Sedang Aktif ({{ count($hero['slides'] ?? []) }} Slide)</span>
                        <span class="text-[11px] text-slate-400 font-normal">Otomatis berganti slide tiap 4.5 detik di beranda</span>
                    </label>

                    <div id="slides-container" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 mb-4">
                        @foreach($hero['slides'] ?? [$hero['image']] as $idx => $slideImg)
                        <div class="slide-card bg-slate-50 border border-slate-200 rounded-xl overflow-hidden shadow-sm relative group p-2.5">
                            <div class="relative rounded-lg overflow-hidden h-36 bg-slate-900">
                                <img src="{{ $slideImg }}" alt="Slide {{ $idx + 1 }}" class="w-full h-full object-cover">
                                <span class="absolute top-2 left-2 bg-slate-900/80 backdrop-blur-sm text-white text-[10px] font-bold px-2 py-0.5 rounded-full border border-white/20">
                                    Slide {{ $idx + 1 }} {{ $idx === 0 ? ' (Utama)' : '' }}
                                </span>
                            </div>
                            <input type="hidden" name="existing_slides[]" value="{{ $slideImg }}">
                            <div class="mt-2 flex items-center justify-between">
                                <span class="text-[10px] text-slate-400 truncate max-w-[170px]" title="{{ $slideImg }}">{{ basename($slideImg) }}</span>
                                <button type="button" onclick="this.closest('.slide-card').remove()" class="text-xs font-bold text-red-600 hover:text-red-800 bg-red-50 hover:bg-red-100 px-2.5 py-1 rounded-lg border border-red-200 transition flex items-center gap-1">
                                    <i class="fa-solid fa-trash-can text-[10px]"></i>
                                    <span>Hapus</span>
                                </button>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

                <!-- Tambah Foto Slide Baru -->
                <div class="p-4 rounded-2xl bg-red-50/40 border border-red-100 space-y-4">
                    <h4 class="text-xs font-bold text-red-800 uppercase tracking-wider flex items-center gap-1.5">
                        <i class="fa-solid fa-plus-circle text-red-600"></i>
                        <span>Tambah Foto ke Slider Banner</span>
                    </h4>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1 flex items-center gap-1.5">
                                <i class="fa-solid fa-cloud-arrow-up text-red-600"></i>
                                <span>Upload Foto Baru (Bisa Banyak File)</span>
                            </label>
                            <input type="file" name="new_slide_files[]" multiple accept="image/*" 
                                   class="w-full bg-white border border-slate-300 rounded-xl px-4 py-2 text-sm focus:outline-none focus:border-red-500 transition file:mr-4 file:py-1 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-red-700 file:text-white hover:file:bg-red-800 cursor-pointer">
                            <p class="text-[11px] text-slate-400 mt-1">Pilih satu atau beberapa foto sekaligus (JPG, PNG, WebP). Rekomendasi: format landscape horizontal 1920x1080 atau 16:9.</p>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1 flex items-center gap-1.5">
                                <i class="fa-solid fa-link text-slate-400"></i>
                                <span>Atau Masukkan URL Gambar</span>
                            </label>
                            <textarea name="new_slide_url" rows="2" 
                                      placeholder="https://images.unsplash.com/... (1 URL per baris jika lebih dari satu)" 
                                      class="w-full bg-white border border-slate-300 rounded-xl px-4 py-2 text-sm focus:outline-none focus:border-red-500 transition"></textarea>
                            <p class="text-[11px] text-slate-400 mt-0.5">Tautan gambar online beresolusi tinggi.</p>
                        </div>
                    </div>
                </div>

                <!-- Kartu Melayang (Floating Badges) -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 pt-2">
                    <!-- Floating Card 1 (Atas Kanan) -->
                    <div class="p-4 rounded-xl bg-slate-50 border border-slate-200 space-y-3">
                        <div class="flex items-center gap-2 text-xs font-bold text-slate-800">
                            <i class="fa-solid fa-circle-check text-emerald-600"></i>
                            <span>Kartu Melayang 1 (Atas Kanan Foto)</span>
                        </div>
                        <div>
                            <label class="block text-[11px] font-bold text-slate-600 mb-1">Judul / Angka</label>
                            <input type="text" name="card1_title" value="{{ old('card1_title', $hero['card1_title']) }}" 
                                   placeholder="Contoh: 500+ Modul SAKTI" 
                                   class="w-full bg-white border border-slate-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-red-500 transition">
                        </div>
                        <div>
                            <label class="block text-[11px] font-bold text-slate-600 mb-1">Subjudul / Keterangan</label>
                            <input type="text" name="card1_subtitle" value="{{ old('card1_subtitle', $hero['card1_subtitle']) }}" 
                                   placeholder="Contoh: Deep Learning, Koding & AI" 
                                   class="w-full bg-white border border-slate-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-red-500 transition">
                        </div>
                    </div>

                    <!-- Floating Card 2 (Bawah Kiri) -->
                    <div class="p-4 rounded-xl bg-slate-50 border border-slate-200 space-y-3">
                        <div class="flex items-center gap-2 text-xs font-bold text-slate-800">
                            <i class="fa-solid fa-code text-purple-600"></i>
                            <span>Kartu Melayang 2 (Bawah Kiri Foto)</span>
                        </div>
                        <div>
                            <label class="block text-[11px] font-bold text-slate-600 mb-1">Judul / Program</label>
                            <input type="text" name="card2_title" value="{{ old('card2_title', $hero['card2_title']) }}" 
                                   placeholder="Contoh: Pelatihan Koding & AI" 
                                   class="w-full bg-white border border-slate-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-red-500 transition">
                        </div>
                        <div>
                            <label class="block text-[11px] font-bold text-slate-600 mb-1">Subjudul / Keterangan</label>
                            <input type="text" name="card2_subtitle" value="{{ old('card2_subtitle', $hero['card2_subtitle']) }}" 
                                   placeholder="Contoh: Berpikir Komputasional Guru" 
                                   class="w-full bg-white border border-slate-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-red-500 transition">
                        </div>
                    </div>
                </div>
            </div>

            <!-- 4. STATISTIK GURU TERHUBUNG -->
            <div class="space-y-4">
                <div class="flex items-center gap-2 pb-2 border-b border-slate-100">
                    <span class="w-6 h-6 rounded-full bg-red-100 text-red-700 font-bold text-xs flex items-center justify-center">4</span>
                    <h3 class="text-sm font-bold text-slate-800 uppercase tracking-wide">Indikator Guru Terhubung</h3>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1 flex items-center gap-1.5">
                            <i class="fa-solid fa-users text-red-600"></i>
                            <span>Angka Counter / Badge</span>
                        </label>
                        <input type="text" name="stat_number" value="{{ old('stat_number', $hero['stat_number']) }}" 
                               placeholder="Contoh: 3.4M+" 
                               class="w-full bg-slate-50 border border-slate-300 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-red-500 focus:bg-white transition">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1 flex items-center gap-1.5">
                            <i class="fa-solid fa-star text-amber-500"></i>
                            <span>Label Keterangan Bintang</span>
                        </label>
                        <input type="text" name="stat_label" value="{{ old('stat_label', $hero['stat_label']) }}" 
                               placeholder="Contoh: Guru & Tenaga Kependidikan Terhubung" 
                               class="w-full bg-slate-50 border border-slate-300 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-red-500 focus:bg-white transition">
                    </div>
                </div>
            </div>

            <!-- Submit Button -->
            <div class="flex items-center justify-end pt-4 border-t border-slate-100">
                <button type="submit" class="bg-red-700 hover:bg-red-800 text-white text-sm font-bold px-7 py-3 rounded-xl shadow-md transition flex items-center gap-2">
                    <i class="fa-solid fa-floppy-disk"></i>
                    <span>Simpan Perubahan Banner Beranda</span>
                </button>
            </div>
        </form>
    </div>

</div>
@endsection
