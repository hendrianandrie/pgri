@extends('admin.layout')

@section('title', 'Edit Berita: ' . $news->title)
@section('page_title', 'Edit Berita & Reportase')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">

    <div class="flex items-center justify-between">
        <a href="{{ route('admin.news.index') }}" class="text-xs font-bold text-slate-600 hover:text-slate-900 bg-white border border-slate-200 px-3.5 py-2 rounded-xl transition inline-flex items-center gap-1.5 shadow-sm">
            <i class="fa-solid fa-arrow-left"></i>
            <span>Kembali ke Daftar Berita</span>
        </a>
        <a href="{{ route('news.show', $news->slug) }}" target="_blank" class="text-xs font-bold text-red-700 bg-red-50 hover:bg-red-100 border border-red-200 px-3.5 py-2 rounded-xl transition inline-flex items-center gap-1.5">
            <i class="fa-solid fa-arrow-up-right-from-square"></i>
            <span>Lihat Halaman Publik</span>
        </a>
    </div>

    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 md:p-8">
        <div class="border-b border-slate-100 pb-4 mb-6 flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center font-bold text-lg border border-amber-100">
                <i class="fa-solid fa-pen-to-square"></i>
            </div>
            <div>
                <h3 class="text-base font-bold text-slate-800">Edit Berita Kegiatan</h3>
                <p class="text-xs text-slate-500">Perbarui informasi judul, nama penyusun, tanggal, gambar, atau isi berita</p>
            </div>
        </div>

        <form action="{{ route('admin.news.update', $news->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- Judul Berita -->
            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1 flex items-center gap-1.5">
                    <i class="fa-solid fa-heading text-red-600"></i>
                    <span>Judul Berita</span>
                    <span class="text-red-500">*</span>
                </label>
                <input type="text" name="title" value="{{ old('title', $news->title) }}" required 
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
                    <input type="text" name="author" value="{{ old('author', $news->author) }}" required 
                           class="w-full bg-slate-50 border border-slate-300 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-red-500 focus:bg-white transition">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1 flex items-center gap-1.5">
                        <i class="fa-solid fa-calendar-days text-emerald-600"></i>
                        <span>Tanggal Rilis Berita</span>
                        <span class="text-red-500">*</span>
                    </label>
                    <input type="date" name="published_at" value="{{ old('published_at', $news->published_at ? $news->published_at->format('Y-m-d') : date('Y-m-d')) }}" required 
                           class="w-full bg-slate-50 border border-slate-300 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-red-500 focus:bg-white transition">
                </div>
            </div>

            <!-- Gambar Cover Berita -->
            <div class="p-4 rounded-xl bg-slate-50 border border-slate-200 space-y-4">
                <div class="flex items-center gap-4">
                    @if($news->image)
                        <div class="w-24 h-16 rounded-lg overflow-hidden border border-slate-200 bg-slate-100 flex-shrink-0">
                            <img src="{{ $news->image }}" alt="Preview" class="w-full h-full object-cover">
                        </div>
                    @endif
                    <div class="flex-1">
                        <span class="text-xs font-bold text-slate-700 block mb-0.5">Gambar Cover Saat Ini</span>
                        <p class="text-[11px] text-slate-400">Pilih file baru di bawah jika ingin mengganti gambar cover berita.</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 pt-2 border-t border-slate-200">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1 flex items-center gap-1.5">
                            <i class="fa-solid fa-upload text-red-600"></i>
                            <span>Ganti File Gambar (Upload)</span>
                        </label>
                        <input type="file" name="image_file" accept="image/*" 
                               class="w-full text-xs text-slate-500 file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-red-700 file:text-white hover:file:bg-red-800 cursor-pointer">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1 flex items-center gap-1.5">
                            <i class="fa-solid fa-link text-slate-400"></i>
                            <span>Atau URL Gambar Baru</span>
                        </label>
                        <input type="text" name="image_url" value="{{ old('image_url') }}" 
                               placeholder="https://..." 
                               class="w-full bg-white border border-slate-300 rounded-xl px-3 py-2 text-sm focus:outline-none focus:border-red-500 transition">
                    </div>
                </div>
            </div>

            <!-- Ringkasan Singkat (Excerpt) -->
            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1 flex items-center gap-1.5">
                    <i class="fa-solid fa-paragraph text-sky-500"></i>
                    <span>Ringkasan Singkat (Excerpt)</span>
                </label>
                <textarea name="excerpt" rows="2" 
                          class="w-full bg-slate-50 border border-slate-300 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-red-500 focus:bg-white transition">{{ old('excerpt', $news->excerpt) }}</textarea>
            </div>

            <!-- Isi Berita Lengkap -->
            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1 flex items-center gap-1.5">
                    <i class="fa-solid fa-newspaper text-slate-800"></i>
                    <span>Isi Lengkap Reportase Berita</span>
                    <span class="text-red-500">*</span>
                </label>
                <textarea name="content" rows="14" required 
                          class="w-full bg-slate-50 border border-slate-300 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-red-500 focus:bg-white transition leading-relaxed">{{ old('content', $news->content) }}</textarea>
            </div>

            <!-- Status Publikasi -->
            <div class="flex items-center gap-2 pt-2">
                <input type="checkbox" name="is_published" id="is_published" value="1" {{ old('is_published', $news->is_published) ? 'checked' : '' }}
                       class="w-4 h-4 text-red-600 rounded border-slate-300 focus:ring-red-500">
                <label for="is_published" class="text-xs font-bold text-slate-700 cursor-pointer">
                    Publikasikan ke website utama
                </label>
            </div>

            <!-- Submit Button -->
            <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-100">
                <a href="{{ route('admin.news.index') }}" class="px-5 py-2.5 rounded-xl text-slate-600 hover:bg-slate-100 text-sm font-semibold transition">
                    Batal
                </a>
                <button type="submit" class="bg-red-700 hover:bg-red-800 text-white text-sm font-bold px-6 py-2.5 rounded-xl shadow-md transition flex items-center gap-2">
                    <i class="fa-solid fa-floppy-disk"></i>
                    <span>Simpan Perubahan</span>
                </button>
            </div>
        </form>
    </div>

</div>
@endsection
