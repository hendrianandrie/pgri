@extends('admin.layout')

@section('title', 'Tulis Berita Baru')
@section('page_title', 'Tulis Berita & Reportase Baru')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">

    <div class="flex items-center justify-between">
        <a href="{{ route('admin.news.index') }}" class="text-xs font-bold text-slate-600 hover:text-slate-900 bg-white border border-slate-200 px-3.5 py-2 rounded-xl transition inline-flex items-center gap-1.5 shadow-sm">
            <i class="fa-solid fa-arrow-left"></i>
            <span>Kembali ke Daftar Berita</span>
        </a>
    </div>

    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 md:p-8">
        <div class="border-b border-slate-100 pb-4 mb-6 flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-red-50 text-red-600 flex items-center justify-center font-bold text-lg border border-red-100">
                <i class="fa-solid fa-pen-nib"></i>
            </div>
            <div>
                <h3 class="text-base font-bold text-slate-800">Formulir Reportase Berita Kegiatan</h3>
                <p class="text-xs text-slate-500">Lengkapi data judul, nama penyusun, tanggal, gambar cover, dan isi berita</p>
            </div>
        </div>

        <form action="{{ route('admin.news.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <!-- Judul Berita -->
            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1 flex items-center gap-1.5">
                    <i class="fa-solid fa-heading text-red-600"></i>
                    <span>Judul Berita</span>
                    <span class="text-red-500">*</span>
                </label>
                <input type="text" name="title" value="{{ old('title') }}" required 
                       placeholder="Contoh: Konferensi Kerja PGRI Bahas Penguatan Kesejahteraan Guru..." 
                       class="w-full bg-slate-50 border border-slate-300 rounded-xl px-4 py-2.5 text-sm font-medium focus:outline-none focus:border-red-500 focus:bg-white transition">
            </div>

            <!-- Nama Penyusun & Tanggal -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1 flex items-center gap-1.5">
                        <i class="fa-solid fa-user-pen text-amber-500"></i>
                        <span>Nama Penyusun / Redaksi</span>
                        <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="author" value="{{ old('author', Auth::user()->name ?? 'Tim Humas PGRI') }}" required 
                           placeholder="Contoh: Tim Humas PGRI / Nama Penyusun" 
                           class="w-full bg-slate-50 border border-slate-300 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-red-500 focus:bg-white transition">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1 flex items-center gap-1.5">
                        <i class="fa-solid fa-calendar-days text-emerald-600"></i>
                        <span>Tanggal Rilis Berita</span>
                        <span class="text-red-500">*</span>
                    </label>
                    <input type="date" name="published_at" value="{{ old('published_at', date('Y-m-d')) }}" required 
                           class="w-full bg-slate-50 border border-slate-300 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-red-500 focus:bg-white transition">
                </div>
            </div>

            <!-- Gambar Cover Berita -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 p-4 rounded-xl bg-slate-50 border border-slate-200">
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1 flex items-center gap-1.5">
                        <i class="fa-solid fa-image text-red-600"></i>
                        <span>Upload Gambar / Foto Cover</span>
                    </label>
                    <input type="file" name="image_file" accept="image/*" 
                           class="w-full text-xs text-slate-500 file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-red-700 file:text-white hover:file:bg-red-800 cursor-pointer">
                    <p class="text-[11px] text-slate-400 mt-1">Format: JPG, PNG, WebP (Maks 5MB). Resolusi rasio 16:9 disarankan.</p>
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1 flex items-center gap-1.5">
                        <i class="fa-solid fa-link text-slate-400"></i>
                        <span>Atau URL Gambar Eksternal</span>
                    </label>
                    <input type="text" name="image_url" value="{{ old('image_url') }}" 
                           placeholder="https://..." 
                           class="w-full bg-white border border-slate-300 rounded-xl px-3 py-2 text-sm focus:outline-none focus:border-red-500 transition">
                </div>
            </div>

            <!-- Ringkasan Singkat (Excerpt) -->
            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1 flex items-center gap-1.5">
                    <i class="fa-solid fa-paragraph text-sky-500"></i>
                    <span>Ringkasan Singkat (Excerpt)</span>
                </label>
                <textarea name="excerpt" rows="2" 
                          placeholder="Ringkasan 1-2 kalimat pengantar berita (opsional, otomatis diambil dari isi berita jika kosong)..." 
                          class="w-full bg-slate-50 border border-slate-300 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-red-500 focus:bg-white transition">{{ old('excerpt') }}</textarea>
            </div>

            <!-- Isi Berita Lengkap -->
            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1 flex items-center gap-1.5">
                    <i class="fa-solid fa-newspaper text-slate-800"></i>
                    <span>Isi Lengkap Reportase Berita</span>
                    <span class="text-red-500">*</span>
                </label>
                <textarea name="content" rows="12" required 
                          placeholder="Tuliskan isi laporan kegiatan secara lengkap di sini..." 
                          class="w-full bg-slate-50 border border-slate-300 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-red-500 focus:bg-white transition leading-relaxed">{{ old('content') }}</textarea>
            </div>

            <!-- Status Publikasi -->
            <div class="flex items-center gap-2 pt-2">
                <input type="checkbox" name="is_published" id="is_published" value="1" {{ old('is_published', true) ? 'checked' : '' }}
                       class="w-4 h-4 text-red-600 rounded border-slate-300 focus:ring-red-500">
                <label for="is_published" class="text-xs font-bold text-slate-700 cursor-pointer">
                    Langsung publikasikan ke website utama
                </label>
            </div>

            <!-- Submit Button -->
            <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-100">
                <a href="{{ route('admin.news.index') }}" class="px-5 py-2.5 rounded-xl text-slate-600 hover:bg-slate-100 text-sm font-semibold transition">
                    Batal
                </a>
                <button type="submit" class="bg-red-700 hover:bg-red-800 text-white text-sm font-bold px-6 py-2.5 rounded-xl shadow-md transition flex items-center gap-2">
                    <i class="fa-solid fa-paper-plane"></i>
                    <span>Simpan & Publikasikan Berita</span>
                </button>
            </div>
        </form>
    </div>

</div>
@endsection
