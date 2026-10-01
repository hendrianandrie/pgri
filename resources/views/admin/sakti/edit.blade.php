@extends('admin.layout')

@section('title', 'Edit ' . $meta['title'])
@section('page_title', 'Edit ' . $meta['title'])

@section('content')
<div class="max-w-4xl mx-auto space-y-6">

    <!-- Back Button -->
    <div>
        <a href="{{ route($meta['back_route']) }}" class="inline-flex items-center gap-2 text-xs font-bold text-slate-600 hover:text-slate-900 bg-white border border-slate-200 px-3.5 py-2 rounded-xl shadow-sm transition">
            <i class="fa-solid fa-arrow-left"></i>
            <span>Kembali ke Daftar {{ $meta['title'] }}</span>
        </a>
    </div>

    <!-- Edit Form Card -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 md:p-8">
        <div class="border-b border-slate-100 pb-4 mb-6 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl flex items-center justify-center font-bold text-lg
                    @if($meta['category'] === 'pembelajaran_mendalam') bg-sky-100 text-sky-700
                    @elseif($meta['category'] === 'rumah_pendidikan') bg-emerald-100 text-emerald-700
                    @elseif($meta['category'] === 'pid') bg-amber-100 text-amber-700
                    @else bg-purple-100 text-purple-700 @endif">
                    <i class="fa-solid fa-pen-to-square"></i>
                </div>
                <div>
                    <h2 class="text-lg font-bold text-slate-800">Edit Data: {{ $content->title }}</h2>
                    <p class="text-xs text-slate-500">Pilar {{ $meta['title'] }}</p>
                </div>
            </div>
            <span class="text-xs font-bold px-3 py-1 rounded-full bg-slate-100 text-slate-600 uppercase">
                ID: #{{ $content->id }}
            </span>
        </div>

        <form action="{{ route('admin.sakti.update', $content->id) }}" method="POST" enctype="multipart/form-data" class="grid grid-cols-1 md:grid-cols-2 gap-5">
            @csrf
            @method('PUT')

            <!-- 1. Nama Modul / Judul -->
            <div class="md:col-span-2">
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">
                    Nama Modul / Judul Konten <span class="text-red-500">*</span>
                </label>
                <input type="text" name="title" required value="{{ old('title', $content->title) }}" 
                       placeholder="Contoh: Modul Pembelajaran Berbasis Proyek" 
                       class="w-full bg-slate-50 border border-slate-300 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-red-500 focus:bg-white transition">
            </div>

            <!-- 2. Tingkat (PAUD, TK, SD, SMP, SMA/K, Umum) -->
            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">
                    Tingkat Pendidikan <span class="text-red-500">*</span>
                </label>
                <select name="tingkat" required class="w-full bg-slate-50 border border-slate-300 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-red-500 focus:bg-white transition font-medium">
                    <option value="">-- Pilih Tingkat --</option>
                    @php $currentTingkat = old('tingkat', $content->badge); @endphp
                    <option value="PAUD" {{ $currentTingkat == 'PAUD' ? 'selected' : '' }}>PAUD (Pendidikan Anak Usia Dini)</option>
                    <option value="TK" {{ $currentTingkat == 'TK' ? 'selected' : '' }}>TK (Taman Kanak-Kanak)</option>
                    <option value="SD" {{ $currentTingkat == 'SD' ? 'selected' : '' }}>SD (Sekolah Dasar)</option>
                    <option value="SMP" {{ $currentTingkat == 'SMP' ? 'selected' : '' }}>SMP (Sekolah Menengah Pertama)</option>
                    <option value="SMA/K" {{ $currentTingkat == 'SMA/K' ? 'selected' : '' }}>SMA/K (Sekolah Menengah Atas / Kejuruan)</option>
                    <option value="Umum" {{ $currentTingkat == 'Umum' ? 'selected' : '' }}>Umum (Semua Jenjang)</option>
                </select>
            </div>

            <!-- 3. Nama Penyusun Modul -->
            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">
                    Nama Penyusun Modul <span class="text-red-500">*</span>
                </label>
                <input type="text" name="author" required value="{{ old('author', $content->author) }}" 
                       placeholder="Contoh: Budi Santoso, S.Kom., M.Pd." 
                       class="w-full bg-slate-50 border border-slate-300 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-red-500 focus:bg-white transition">
            </div>

            <!-- 4. Asal Sekolah / Satuan Pendidikan -->
            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">
                    Asal Sekolah / Satuan Pendidikan
                </label>
                <div class="relative">
                    <i class="fa-solid fa-school absolute left-4 top-3 text-slate-400 text-sm"></i>
                    <input type="text" name="school_origin" value="{{ old('school_origin', $content->school_origin) }}" 
                           placeholder="Contoh: SMP Negeri 5 Palembang" 
                           class="w-full bg-slate-50 border border-slate-300 rounded-xl pl-10 pr-4 py-2.5 text-sm focus:outline-none focus:border-red-500 focus:bg-white transition">
                </div>
            </div>

            <!-- 5. Link Modul -->
            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">
                    Link Modul (Google Drive / Berkas / Web Materi) <span class="text-red-500">*</span>
                </label>
                <div class="relative">
                    <i class="fa-solid fa-link absolute left-4 top-3 text-slate-400 text-sm"></i>
                    <input type="url" name="file_url" required value="{{ old('file_url', $content->file_url) }}" 
                           placeholder="https://drive.google.com/... atau tautan berkas modul" 
                           class="w-full bg-slate-50 border border-slate-300 rounded-xl pl-10 pr-4 py-2.5 text-sm focus:outline-none focus:border-red-500 focus:bg-white transition">
                </div>
            </div>

            <!-- 6. Upload Gambar / Sampul -->
            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">
                    Ganti Gambar Sampul (Upload File Baru)
                </label>
                <input type="file" name="image_file" accept="image/*" 
                       class="w-full bg-slate-50 border border-slate-300 rounded-xl px-3 py-2 text-xs text-slate-600 file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-red-50 file:text-red-700 hover:file:bg-red-100 transition">
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">
                    Atau URL Gambar
                </label>
                <input type="text" name="image" value="{{ old('image', $content->image) }}" 
                       placeholder="https://images.unsplash.com/..." 
                       class="w-full bg-slate-50 border border-slate-300 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-red-500 focus:bg-white transition">
            </div>

            <!-- Pratinjau Gambar Saat Ini -->
            @if($content->image)
                <div class="md:col-span-2 flex items-center gap-3 p-3 bg-slate-50 border border-slate-200 rounded-xl">
                    <img src="{{ $content->image }}" alt="{{ $content->title }}" class="w-16 h-16 object-cover rounded-lg border border-slate-200 shadow-sm">
                    <div>
                        <span class="text-xs font-bold text-slate-700 block">Gambar Sampul Saat Ini</span>
                        <span class="text-[11px] text-slate-400 break-all">{{ Str::limit($content->image, 80) }}</span>
                    </div>
                </div>
            @endif

            <!-- 7. Ringkasan / Keterangan Singkat -->
            <div class="md:col-span-2">
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">
                    Ringkasan / Keterangan Singkat (Opsional)
                </label>
                <textarea name="summary" rows="2" 
                          placeholder="Ringkasan isi atau sasaran pembelajaran modul..." 
                          class="w-full bg-slate-50 border border-slate-300 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-red-500 focus:bg-white transition">{{ old('summary', $content->summary) }}</textarea>
            </div>

            <!-- 8. Unggulan Checkbox -->
            <div class="md:col-span-2 flex items-center gap-2 pt-2">
                <label class="flex items-center gap-2 cursor-pointer text-sm font-semibold text-slate-700">
                    <input type="checkbox" name="is_featured" value="1" {{ old('is_featured', $content->is_featured) ? 'checked' : '' }} 
                           class="rounded border-slate-300 text-red-600 focus:ring-red-500">
                    <span>Tandai sebagai Modul Unggulan (Featured)</span>
                </label>
            </div>

            <!-- Submit & Cancel Buttons -->
            <div class="md:col-span-2 flex items-center justify-end gap-3 pt-4 border-t border-slate-100">
                <a href="{{ route($meta['back_route']) }}" class="px-5 py-2.5 text-xs font-bold text-slate-600 hover:text-slate-800 bg-slate-100 hover:bg-slate-200 rounded-xl transition">
                    Batal
                </a>
                <button type="submit" 
                        class="text-white text-sm font-bold px-6 py-2.5 rounded-xl shadow-md transition flex items-center gap-2
                        @if($meta['category'] === 'pembelajaran_mendalam') bg-sky-700 hover:bg-sky-800
                        @elseif($meta['category'] === 'rumah_pendidikan') bg-emerald-700 hover:bg-emerald-800
                        @elseif($meta['category'] === 'pid') bg-amber-700 hover:bg-amber-800
                        @else bg-purple-700 hover:bg-purple-800 @endif">
                    <i class="fa-solid fa-floppy-disk"></i>
                    <span>Simpan Perubahan</span>
                </button>
            </div>
        </form>
    </div>

</div>
@endsection
