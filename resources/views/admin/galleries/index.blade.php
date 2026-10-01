@extends('admin.layout')

@section('title', 'Kelola Dokumentasi & Galeri Foto')
@section('page_title', 'Dokumentasi & Galeri PGRI')

@section('content')
<div class="space-y-6">

    @if(session('success'))
    <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 px-4 py-3 rounded-xl flex items-center gap-3 shadow-sm">
        <i class="fa-solid fa-circle-check text-emerald-600 text-lg"></i>
        <span class="text-sm font-semibold">{{ session('success') }}</span>
    </div>
    @endif

    @if($errors->any())
    <div class="bg-rose-50 border border-rose-200 text-rose-800 px-4 py-3 rounded-xl shadow-sm">
        <div class="flex items-center gap-2 font-bold text-sm mb-1">
            <i class="fa-solid fa-triangle-exclamation text-rose-600"></i>
            <span>Terdapat beberapa kesalahan input:</span>
        </div>
        <ul class="list-disc list-inside text-xs space-y-0.5 text-rose-700">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <!-- Form Tambah Dokumentasi & Galeri Baru -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="p-6 border-b border-slate-100 bg-slate-50/60 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-red-100 text-red-600 flex items-center justify-center font-bold text-lg shadow-sm">
                    <i class="fa-solid fa-camera-retro"></i>
                </div>
                <div>
                    <h3 class="text-base font-bold text-slate-800">Tambah Dokumentasi & Galeri Baru</h3>
                    <p class="text-xs text-slate-500">Unggah foto sampul utama dan foto-foto dokumentasi kegiatan PGRI</p>
                </div>
            </div>
            <span class="text-xs font-semibold text-slate-400 bg-white px-3 py-1.5 rounded-lg border border-slate-200">
                Maksimal 5MB per file foto
            </span>
        </div>

        <form action="{{ route('admin.galleries.store') }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-6">
            @csrf

            <!-- Informasi Kegiatan -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                <div class="lg:col-span-2">
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">
                        Judul Kegiatan / Dokumentasi <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="title" required value="{{ old('title') }}" placeholder="Contoh: Konferensi Kerja PGRI & Hari Guru Nasional" class="w-full bg-slate-50 border border-slate-300 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-red-500 focus:bg-white transition">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Kategori Kegiatan</label>
                    <input list="categoryList" name="category" value="{{ old('category', 'Kegiatan PGRI') }}" placeholder="Pilih atau ketik kategori..." class="w-full bg-slate-50 border border-slate-300 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-red-500 focus:bg-white transition">
                    <datalist id="categoryList">
                        <option value="Kegiatan PGRI">
                        <option value="Konferensi & Raker">
                        <option value="Workshop & Diklat">
                        <option value="HUT PGRI & HGN">
                        <option value="Kemanusiaan & Sosial">
                        <option value="Advokasi & Hukum">
                    </datalist>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Tanggal Kegiatan</label>
                    <input type="date" name="event_date" value="{{ old('event_date', date('Y-m-d')) }}" class="w-full bg-slate-50 border border-slate-300 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-red-500 focus:bg-white transition">
                </div>

                <div class="lg:col-span-2">
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Lokasi Kegiatan</label>
                    <input type="text" name="location" value="{{ old('location') }}" placeholder="Contoh: Gedung Guru PGRI Pusat / Stadion GBK" class="w-full bg-slate-50 border border-slate-300 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-red-500 focus:bg-white transition">
                </div>

                <div class="lg:col-span-2">
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Deskripsi Singkat</label>
                    <input type="text" name="description" value="{{ old('description') }}" placeholder="Keterangan singkat mengenai dokumentasi kegiatan..." class="w-full bg-slate-50 border border-slate-300 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-red-500 focus:bg-white transition">
                </div>
            </div>

            <!-- Upload Section: Foto Sampul & Foto Dokumentasi -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 pt-4 border-t border-slate-100">
                
                <!-- 1. Upload Foto Sampul -->
                <div class="bg-slate-50/80 rounded-2xl p-5 border border-slate-200">
                    <div class="flex items-center justify-between mb-3">
                        <label class="block text-xs font-bold text-slate-800 uppercase tracking-wider flex items-center gap-1.5">
                            <i class="fa-solid fa-image text-red-600"></i>
                            <span>1. Upload Foto Sampul (Cover Utama)</span>
                        </label>
                        <span class="text-[11px] font-semibold text-amber-700 bg-amber-50 px-2 py-0.5 rounded border border-amber-200">Wajib / Utama</span>
                    </div>
                    <p class="text-xs text-slate-500 mb-3">Foto ini akan tampil sebagai thumbnail utama di kartu galeri dan halaman beranda.</p>

                    <div class="relative border-2 border-dashed border-slate-300 hover:border-red-400 bg-white rounded-xl p-4 text-center cursor-pointer transition" onclick="document.getElementById('cover_file_input').click()">
                        <input type="file" id="cover_file_input" name="cover_file" accept="image/*" class="hidden" onchange="previewCoverImage(event)">
                        
                        <div id="cover_placeholder">
                            <div class="w-12 h-12 rounded-full bg-red-50 text-red-600 flex items-center justify-center mx-auto mb-2">
                                <i class="fa-solid fa-cloud-arrow-up text-xl"></i>
                            </div>
                            <span class="text-xs font-bold text-slate-700 block">Klik untuk Pilih Foto Sampul</span>
                            <span class="text-[11px] text-slate-400">JPG, PNG, WebP (Maksimal 5MB)</span>
                        </div>

                        <div id="cover_preview_container" class="hidden relative">
                            <img id="cover_preview_img" src="#" alt="Preview Sampul" class="w-full h-44 object-cover rounded-lg shadow-sm">
                            <div class="absolute top-2 right-2 flex gap-1">
                                <span class="bg-emerald-600 text-white text-[10px] font-bold px-2 py-1 rounded shadow">Foto Sampul Terpilih</span>
                                <button type="button" onclick="event.stopPropagation(); removeCoverPreview();" class="bg-rose-600 hover:bg-rose-700 text-white text-xs w-6 h-6 rounded-full flex items-center justify-center shadow">
                                    <i class="fa-solid fa-xmark"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Opsional: Alternatif Input URL Foto Sampul -->
                    <div class="mt-3">
                        <button type="button" onclick="document.getElementById('cover_url_box').classList.toggle('hidden')" class="text-[11px] font-semibold text-slate-500 hover:text-slate-800 flex items-center gap-1">
                            <i class="fa-solid fa-link text-xs"></i>
                            <span>Atau gunakan link URL Foto Sampul (opsional)</span>
                        </button>
                        <div id="cover_url_box" class="hidden mt-2">
                            <input type="url" name="cover_url" placeholder="https://images.unsplash.com/..." class="w-full bg-white border border-slate-300 rounded-lg px-3 py-2 text-xs focus:outline-none focus:border-red-500">
                        </div>
                    </div>
                </div>

                <!-- 2. Upload Foto-foto Dokumentasi (Multiple) -->
                <div class="bg-slate-50/80 rounded-2xl p-5 border border-slate-200">
                    <div class="flex items-center justify-between mb-3">
                        <label class="block text-xs font-bold text-slate-800 uppercase tracking-wider flex items-center gap-1.5">
                            <i class="fa-solid fa-images text-indigo-600"></i>
                            <span>2. Upload Foto-foto Dokumentasi Kegiatan</span>
                        </label>
                        <span class="text-[11px] font-semibold text-indigo-700 bg-indigo-50 px-2 py-0.5 rounded border border-indigo-200">Bisa Multi-upload</span>
                    </div>
                    <p class="text-xs text-slate-500 mb-3">Pilih satu atau sekaligus banyak foto dokumentasi kegiatan untuk album ini.</p>

                    <div class="relative border-2 border-dashed border-slate-300 hover:border-indigo-400 bg-white rounded-xl p-4 text-center cursor-pointer transition min-h-[140px] flex flex-col justify-center" onclick="document.getElementById('photo_files_input').click()">
                        <input type="file" id="photo_files_input" name="photo_files[]" multiple accept="image/*" class="hidden" onchange="previewMultiplePhotos(event)">
                        
                        <div id="photos_placeholder">
                            <div class="w-12 h-12 rounded-full bg-indigo-50 text-indigo-600 flex items-center justify-center mx-auto mb-2">
                                <i class="fa-solid fa-folder-open text-xl"></i>
                            </div>
                            <span class="text-xs font-bold text-slate-700 block">Klik untuk Pilih Foto Dokumentasi (Bisa Sekaligus Banyak)</span>
                            <span class="text-[11px] text-slate-400">Tekan Ctrl / Shift untuk memilih beberapa foto sekaligus</span>
                        </div>

                        <div id="photos_preview_container" class="hidden text-left">
                            <div class="flex items-center justify-between mb-2">
                                <span id="photos_count_badge" class="text-xs font-bold text-indigo-700 bg-indigo-50 px-2.5 py-1 rounded-md border border-indigo-200">
                                    0 Foto Terpilih
                                </span>
                                <button type="button" onclick="event.stopPropagation(); removePhotosPreview();" class="text-xs font-bold text-rose-600 hover:text-rose-800 flex items-center gap-1">
                                    <i class="fa-solid fa-trash-can"></i> Hapus Semua Pilihan
                                </button>
                            </div>
                            <div id="photos_grid_preview" class="grid grid-cols-4 sm:grid-cols-6 gap-2 max-h-36 overflow-y-auto p-1 bg-slate-50 rounded-lg border border-slate-200">
                                <!-- Thumbnails injected here -->
                            </div>
                        </div>
                    </div>

                    <!-- Opsional: Alternatif URL Foto Tambahan -->
                    <div class="mt-3">
                        <button type="button" onclick="document.getElementById('photos_url_box').classList.toggle('hidden')" class="text-[11px] font-semibold text-slate-500 hover:text-slate-800 flex items-center gap-1">
                            <i class="fa-solid fa-link text-xs"></i>
                            <span>Atau input URL foto dokumentasi tambahan (opsional)</span>
                        </button>
                        <div id="photos_url_box" class="hidden mt-2">
                            <textarea name="photo_urls" rows="2" placeholder="Masukkan URL foto tambahan (pisahkan tiap URL dengan baris baru)..." class="w-full bg-white border border-slate-300 rounded-lg px-3 py-2 text-xs focus:outline-none focus:border-indigo-500"></textarea>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Submit Button -->
            <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-100">
                <button type="reset" onclick="removeCoverPreview(); removePhotosPreview();" class="px-5 py-2.5 rounded-xl border border-slate-300 text-slate-600 hover:bg-slate-100 text-sm font-semibold transition">
                    Reset Form
                </button>
                <button type="submit" class="bg-gradient-to-r from-red-600 to-red-700 hover:from-red-500 hover:to-red-600 text-white text-sm font-bold px-7 py-2.5 rounded-xl shadow-lg shadow-red-900/20 transition flex items-center gap-2">
                    <i class="fa-solid fa-cloud-arrow-up"></i>
                    <span>Simpan & Unggah Dokumentasi</span>
                </button>
            </div>
        </form>
    </div>

    <!-- Gallery Grid List -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6">
        <!-- Header & Filters -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6 pb-4 border-b border-slate-100">
            <div>
                <h3 class="font-bold text-slate-800 text-base flex items-center gap-2">
                    <span>Dokumentasi Kegiatan Terpublikasi</span>
                    <span class="text-xs font-semibold px-2.5 py-0.5 rounded-full bg-slate-100 text-slate-600 border border-slate-200">
                        {{ $galleries->total() }} Album Kegiatan
                    </span>
                </h3>
                <p class="text-xs text-slate-500 mt-0.5">Kelola foto sampul, lihat semua foto dokumentasi, dan perbarui data kegiatan</p>
            </div>

            <!-- Filter Category & Search -->
            <form action="{{ route('admin.galleries.index') }}" method="GET" class="flex flex-wrap items-center gap-2">
                <select name="category" onchange="this.form.submit()" class="bg-slate-50 border border-slate-300 rounded-xl px-3 py-2 text-xs font-medium text-slate-700 focus:outline-none focus:border-red-500">
                    <option value="all">Semua Kategori</option>
                    @foreach($categories as $key => $label)
                        <option value="{{ $key }}" {{ request('category') == $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>

                <div class="relative">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari kegiatan..." class="bg-slate-50 border border-slate-300 rounded-xl pl-8 pr-3 py-2 text-xs text-slate-700 focus:outline-none focus:border-red-500 w-44 sm:w-56">
                    <i class="fa-solid fa-magnifying-glass absolute left-3 top-2.5 text-xs text-slate-400"></i>
                </div>

                @if(request('search') || (request('category') && request('category') != 'all'))
                    <a href="{{ route('admin.galleries.index') }}" class="text-xs font-bold text-red-600 hover:text-red-700 bg-red-50 hover:bg-red-100 px-3 py-2 rounded-xl transition">
                        Reset
                    </a>
                @endif
            </form>
        </div>

        <!-- Grid of Galleries -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($galleries as $gallery)
                <div class="group bg-slate-50 rounded-2xl overflow-hidden border border-slate-200 hover:border-slate-300 hover:shadow-md transition duration-300 flex flex-col justify-between">
                    
                    <!-- Cover Image Container -->
                    <div class="relative h-48 w-full bg-slate-200 overflow-hidden cursor-pointer" onclick="openPreviewModal({{ json_encode($gallery) }})">
                        <img src="{{ $gallery->cover_photo }}" alt="{{ $gallery->title }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-500" onerror="this.src='https://images.unsplash.com/photo-1524178232363-1fb2b075b655?auto=format&fit=crop&q=80&w=800'">
                        
                        <!-- Badges -->
                        <div class="absolute top-3 left-3 flex flex-col gap-1.5">
                            <span class="bg-slate-900/85 backdrop-blur text-white text-[10px] font-bold px-2.5 py-1 rounded-md uppercase tracking-wider shadow">
                                {{ $gallery->category ?? 'Kegiatan PGRI' }}
                            </span>
                        </div>

                        <!-- Foto Count Badge -->
                        <div class="absolute bottom-3 right-3 bg-black/75 backdrop-blur text-white text-[11px] font-bold px-2.5 py-1 rounded-lg flex items-center gap-1.5 shadow">
                            <i class="fa-solid fa-images text-amber-400"></i>
                            <span>{{ $gallery->photos_count }} Foto</span>
                        </div>
                    </div>

                    <!-- Content -->
                    <div class="p-5 flex-1 flex flex-col justify-between">
                        <div>
                            <h4 class="font-bold text-slate-800 text-sm line-clamp-1 mb-1.5 hover:text-red-700 transition cursor-pointer" onclick="openPreviewModal({{ json_encode($gallery) }})">
                                {{ $gallery->title }}
                            </h4>
                            <p class="text-xs text-slate-500 line-clamp-2 leading-relaxed mb-3">
                                {{ $gallery->description ?? 'Dokumentasi resmi kegiatan PGRI.' }}
                            </p>
                        </div>
                        
                        <div>
                            <div class="flex items-center gap-2 text-[11px] text-slate-400 font-medium mb-3">
                                <span><i class="fa-regular fa-calendar text-red-500 mr-1"></i> {{ $gallery->event_date ? $gallery->event_date->format('d M Y') : '-' }}</span>
                                <span>•</span>
                                <span class="line-clamp-1"><i class="fa-solid fa-location-dot text-amber-500 mr-1"></i> {{ $gallery->location ?? 'Indonesia' }}</span>
                            </div>

                            <!-- Buttons: Preview, Edit, Delete -->
                            <div class="pt-3 border-t border-slate-200/80 flex items-center justify-between gap-2">
                                <button type="button" onclick="openPreviewModal({{ json_encode($gallery) }})" class="text-xs font-bold text-indigo-700 hover:text-indigo-900 bg-indigo-50 hover:bg-indigo-100 px-3 py-1.5 rounded-lg transition flex items-center gap-1.5">
                                    <i class="fa-solid fa-eye text-[11px]"></i>
                                    <span>Lihat Foto ({{ $gallery->photos_count }})</span>
                                </button>

                                <div class="flex items-center gap-1.5">
                                    <button type="button" onclick="openEditModal({{ json_encode($gallery) }})" class="text-xs font-bold text-slate-700 hover:text-slate-900 bg-slate-200/70 hover:bg-slate-200 px-3 py-1.5 rounded-lg transition flex items-center gap-1">
                                        <i class="fa-solid fa-pen-to-square text-[11px]"></i>
                                        <span>Edit</span>
                                    </button>

                                    <form action="{{ route('admin.galleries.destroy', $gallery->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus album foto dokumentasi ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-xs font-bold text-rose-600 hover:text-rose-800 bg-rose-50 hover:bg-rose-100 px-2.5 py-1.5 rounded-lg transition" title="Hapus Album">
                                            <i class="fa-solid fa-trash-can"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            @empty
                <div class="col-span-full py-16 text-center">
                    <div class="w-16 h-16 rounded-full bg-slate-100 text-slate-400 flex items-center justify-center mx-auto mb-3 text-2xl">
                        <i class="fa-solid fa-images"></i>
                    </div>
                    <h4 class="font-bold text-slate-700 text-sm">Belum ada foto dalam galeri</h4>
                    <p class="text-xs text-slate-400 mt-1">Gunakan formulir di atas untuk mengunggah foto sampul dan foto dokumentasi kegiatan.</p>
                </div>
            @endforelse
        </div>

        <div class="mt-8 pt-4 border-t border-slate-100">
            {{ $galleries->links() }}
        </div>
    </div>

</div>

<!-- MODAL LIHAT SEMUA FOTO DOKUMENTASI (PREVIEW) -->
<div id="previewModal" class="fixed inset-0 z-50 bg-slate-900/80 backdrop-blur-sm hidden items-center justify-center p-4">
    <div class="bg-white rounded-2xl max-w-4xl w-full max-h-[90vh] flex flex-col overflow-hidden shadow-2xl animate-in fade-in zoom-in duration-200">
        
        <!-- Header Modal -->
        <div class="p-5 border-b border-slate-100 flex items-center justify-between bg-slate-50">
            <div>
                <span id="previewModalCategory" class="text-[10px] font-bold uppercase tracking-wider text-red-700 bg-red-50 border border-red-200 px-2.5 py-0.5 rounded-md inline-block mb-1">
                    Kategori
                </span>
                <h3 id="previewModalTitle" class="font-bold text-slate-800 text-base leading-snug">Judul Kegiatan</h3>
                <p id="previewModalMeta" class="text-xs text-slate-500 mt-0.5">Tanggal • Lokasi</p>
            </div>
            <button type="button" onclick="closePreviewModal()" class="w-9 h-9 rounded-xl bg-slate-200 hover:bg-slate-300 text-slate-600 flex items-center justify-center text-sm transition">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>

        <!-- Body: Foto Utama & Grid Foto Dokumentasi -->
        <div class="p-6 overflow-y-auto space-y-6 flex-1">
            <!-- Foto Utama Terpilih -->
            <div class="rounded-xl overflow-hidden bg-slate-900 flex items-center justify-center min-h-[300px] max-h-[460px]">
                <img id="previewModalFeatured" src="#" alt="Foto Terpilih" class="max-h-[460px] w-auto max-w-full object-contain">
            </div>

            <!-- Keterangan -->
            <div id="previewModalDesc" class="text-xs text-slate-600 bg-slate-50 p-4 rounded-xl border border-slate-200 leading-relaxed">
                Keterangan kegiatan...
            </div>

            <!-- Daftar Thumbnail Foto Dokumentasi -->
            <div>
                <h4 class="text-xs font-bold text-slate-700 uppercase tracking-wider mb-2 flex items-center justify-between">
                    <span>Semua Foto dalam Album Ini (<span id="previewModalCount">0</span>)</span>
                    <span class="text-[11px] font-normal text-slate-400">Klik salah satu foto untuk memperbesar</span>
                </h4>
                <div id="previewModalThumbnails" class="grid grid-cols-4 sm:grid-cols-6 md:grid-cols-8 gap-2">
                    <!-- Thumbnails dynamically rendered -->
                </div>
            </div>
        </div>

        <!-- Footer Modal -->
        <div class="p-4 border-t border-slate-100 bg-slate-50 flex justify-end">
            <button type="button" onclick="closePreviewModal()" class="px-5 py-2 rounded-xl bg-slate-800 hover:bg-slate-900 text-white text-xs font-bold transition">
                Tutup Pratinjau
            </button>
        </div>
    </div>
</div>

<!-- MODAL EDIT DOKUMENTASI & FOTO -->
<div id="editModal" class="fixed inset-0 z-50 bg-slate-900/80 backdrop-blur-sm hidden items-center justify-center p-4">
    <div class="bg-white rounded-2xl max-w-3xl w-full max-h-[92vh] flex flex-col overflow-hidden shadow-2xl">
        
        <!-- Header Modal -->
        <div class="p-5 border-b border-slate-100 flex items-center justify-between bg-slate-50">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-xl bg-amber-100 text-amber-700 flex items-center justify-center font-bold text-sm">
                    <i class="fa-solid fa-pen-to-square"></i>
                </div>
                <div>
                    <h3 class="font-bold text-slate-800 text-base">Edit Dokumentasi & Galeri Foto</h3>
                    <p class="text-xs text-slate-500">Perbarui rincian kegiatan, ganti sampul, atau tambah foto dokumentasi</p>
                </div>
            </div>
            <button type="button" onclick="closeEditModal()" class="w-9 h-9 rounded-xl bg-slate-200 hover:bg-slate-300 text-slate-600 flex items-center justify-center text-sm transition">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>

        <!-- Form Edit -->
        <form id="editForm" action="" method="POST" enctype="multipart/form-data" class="flex-1 overflow-y-auto p-6 space-y-5">
            @csrf
            @method('PUT')

            <!-- Data Umum -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="md:col-span-2">
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">
                        Judul Kegiatan <span class="text-red-500">*</span>
                    </label>
                    <input type="text" id="edit_title" name="title" required class="w-full bg-slate-50 border border-slate-300 rounded-xl px-4 py-2 text-sm focus:outline-none focus:border-red-500">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Kategori Kegiatan</label>
                    <input type="text" id="edit_category" name="category" class="w-full bg-slate-50 border border-slate-300 rounded-xl px-4 py-2 text-sm focus:outline-none focus:border-red-500">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Tanggal Kegiatan</label>
                    <input type="date" id="edit_event_date" name="event_date" class="w-full bg-slate-50 border border-slate-300 rounded-xl px-4 py-2 text-sm focus:outline-none focus:border-red-500">
                </div>

                <div class="md:col-span-2">
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Lokasi Kegiatan</label>
                    <input type="text" id="edit_location" name="location" class="w-full bg-slate-50 border border-slate-300 rounded-xl px-4 py-2 text-sm focus:outline-none focus:border-red-500">
                </div>

                <div class="md:col-span-2">
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Deskripsi Kegiatan</label>
                    <textarea id="edit_description" name="description" rows="2" class="w-full bg-slate-50 border border-slate-300 rounded-xl px-4 py-2 text-sm focus:outline-none focus:border-red-500"></textarea>
                </div>
            </div>

            <!-- Ganti Foto Sampul -->
            <div class="p-4 bg-slate-50 rounded-xl border border-slate-200">
                <label class="block text-xs font-bold text-slate-800 uppercase tracking-wider mb-2 flex items-center gap-1.5">
                    <i class="fa-solid fa-image text-red-600"></i>
                    <span>Ganti Foto Sampul Utama (Cover)</span>
                </label>
                
                <div class="flex items-center gap-4">
                    <div class="w-24 h-16 rounded-lg bg-slate-200 overflow-hidden flex-shrink-0 border border-slate-300">
                        <img id="edit_cover_current" src="#" alt="Sampul Saat Ini" class="w-full h-full object-cover">
                    </div>
                    <div class="flex-1">
                        <input type="file" name="cover_file" accept="image/*" class="w-full text-xs text-slate-500 file:mr-3 file:py-2 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-red-50 file:text-red-700 hover:file:bg-red-100">
                        <span class="text-[11px] text-slate-400 mt-1 block">Biarkan kosong jika tidak ingin mengganti foto sampul</span>
                    </div>
                </div>
            </div>

            <!-- Tambah Foto Dokumentasi Baru -->
            <div class="p-4 bg-slate-50 rounded-xl border border-slate-200">
                <label class="block text-xs font-bold text-slate-800 uppercase tracking-wider mb-2 flex items-center gap-1.5">
                    <i class="fa-solid fa-plus-circle text-indigo-600"></i>
                    <span>Tambah Foto-foto Dokumentasi Baru (Multi-upload)</span>
                </label>
                <input type="file" name="photo_files[]" multiple accept="image/*" class="w-full text-xs text-slate-500 file:mr-3 file:py-2 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                <span class="text-[11px] text-slate-400 mt-1 block">Pilih satu atau beberapa foto baru untuk ditambahkan ke album ini</span>
            </div>

            <!-- Kelola Foto yang Sudah Ada -->
            <div class="p-4 bg-slate-50 rounded-xl border border-slate-200">
                <label class="block text-xs font-bold text-slate-800 uppercase tracking-wider mb-2 flex items-center justify-between">
                    <span>Foto Dokumentasi Tersimpan Saat Ini</span>
                    <span class="text-[11px] font-normal text-rose-600">Centang kotak merah untuk menghapus foto tertentu</span>
                </label>
                <div id="edit_existing_photos_grid" class="grid grid-cols-3 sm:grid-cols-4 md:grid-cols-6 gap-3">
                    <!-- Existing photo items with delete checkbox rendered here -->
                </div>
            </div>

            <!-- Modal Action Buttons -->
            <div class="flex items-center justify-end gap-3 pt-3 border-t border-slate-100">
                <button type="button" onclick="closeEditModal()" class="px-5 py-2.5 rounded-xl border border-slate-300 text-slate-600 hover:bg-slate-100 text-xs font-semibold transition">
                    Batal
                </button>
                <button type="submit" class="bg-red-700 hover:bg-red-800 text-white text-xs font-bold px-6 py-2.5 rounded-xl shadow-md transition flex items-center gap-2">
                    <i class="fa-solid fa-check"></i>
                    <span>Simpan Perubahan</span>
                </button>
            </div>
        </form>
    </div>
</div>

<script>
// Cover preview
function previewCoverImage(event) {
    const input = event.target;
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('cover_preview_img').src = e.target.result;
            document.getElementById('cover_placeholder').classList.add('hidden');
            document.getElementById('cover_preview_container').classList.remove('hidden');
        }
        reader.readAsDataURL(input.files[0]);
    }
}

function removeCoverPreview() {
    const input = document.getElementById('cover_file_input');
    input.value = '';
    document.getElementById('cover_preview_img').src = '#';
    document.getElementById('cover_preview_container').classList.add('hidden');
    document.getElementById('cover_placeholder').classList.remove('hidden');
}

// Multiple photos preview
function previewMultiplePhotos(event) {
    const input = event.target;
    const grid = document.getElementById('photos_grid_preview');
    grid.innerHTML = '';

    if (input.files && input.files.length > 0) {
        document.getElementById('photos_count_badge').innerText = `${input.files.length} Foto Terpilih`;
        document.getElementById('photos_placeholder').classList.add('hidden');
        document.getElementById('photos_preview_container').classList.remove('hidden');

        Array.from(input.files).forEach((file, index) => {
            const reader = new FileReader();
            reader.onload = function(e) {
                const div = document.createElement('div');
                div.className = 'relative aspect-square rounded-md overflow-hidden bg-slate-200 border border-slate-300 shadow-sm';
                div.innerHTML = `<img src="${e.target.result}" class="w-full h-full object-cover">`;
                grid.appendChild(div);
            };
            reader.readAsDataURL(file);
        });
    }
}

function removePhotosPreview() {
    const input = document.getElementById('photo_files_input');
    input.value = '';
    document.getElementById('photos_grid_preview').innerHTML = '';
    document.getElementById('photos_preview_container').classList.add('hidden');
    document.getElementById('photos_placeholder').classList.remove('hidden');
}

// Preview Modal
function openPreviewModal(gallery) {
    const modal = document.getElementById('previewModal');
    document.getElementById('previewModalTitle').innerText = gallery.title;
    document.getElementById('previewModalCategory').innerText = gallery.category || 'Kegiatan PGRI';
    
    const dateFormatted = gallery.event_date ? new Date(gallery.event_date).toLocaleDateString('id-ID', {day: 'numeric', month: 'short', year: 'numeric'}) : '-';
    document.getElementById('previewModalMeta').innerText = `${dateFormatted} • ${gallery.location || 'Indonesia'}`;
    document.getElementById('previewModalDesc').innerText = gallery.description || 'Tidak ada deskripsi.';

    const photos = (Array.isArray(gallery.photos) && gallery.photos.length > 0) ? gallery.photos : [gallery.cover_image || gallery.image];
    const cleanPhotos = photos.filter(p => !!p);

    document.getElementById('previewModalCount').innerText = cleanPhotos.length;
    
    // Set featured image
    const featuredImg = document.getElementById('previewModalFeatured');
    featuredImg.src = cleanPhotos[0] || (gallery.cover_image || gallery.image);

    // Render thumbnails
    const thumbContainer = document.getElementById('previewModalThumbnails');
    thumbContainer.innerHTML = '';

    cleanPhotos.forEach((photo, idx) => {
        const btn = document.createElement('button');
        btn.type = 'button';
        btn.className = 'aspect-square rounded-lg overflow-hidden border-2 border-slate-200 hover:border-red-500 focus:border-red-600 transition duration-150';
        btn.innerHTML = `<img src="${photo}" class="w-full h-full object-cover">`;
        btn.onclick = () => {
            featuredImg.src = photo;
        };
        thumbContainer.appendChild(btn);
    });

    modal.classList.remove('hidden');
    modal.classList.add('flex');
}

function closePreviewModal() {
    const modal = document.getElementById('previewModal');
    modal.classList.add('hidden');
    modal.classList.remove('flex');
}

// Edit Modal
function openEditModal(gallery) {
    const modal = document.getElementById('editModal');
    const form = document.getElementById('editForm');
    
    form.action = `/admin/galleries/${gallery.id}`;
    document.getElementById('edit_title').value = gallery.title || '';
    document.getElementById('edit_category').value = gallery.category || '';
    
    if (gallery.event_date) {
        document.getElementById('edit_event_date').value = gallery.event_date.split('T')[0];
    } else {
        document.getElementById('edit_event_date').value = '';
    }
    
    document.getElementById('edit_location').value = gallery.location || '';
    document.getElementById('edit_description').value = gallery.description || '';

    // Set current cover
    const coverUrl = gallery.cover_image || gallery.image || 'https://images.unsplash.com/photo-1524178232363-1fb2b075b655?auto=format&fit=crop&q=80&w=800';
    document.getElementById('edit_cover_current').src = coverUrl;

    // Render existing photos with remove checkboxes
    const existingContainer = document.getElementById('edit_existing_photos_grid');
    existingContainer.innerHTML = '';

    const photos = (Array.isArray(gallery.photos) && gallery.photos.length > 0) ? gallery.photos : [gallery.cover_image || gallery.image];
    const cleanPhotos = photos.filter(p => !!p);

    if (cleanPhotos.length === 0) {
        existingContainer.innerHTML = '<span class="text-xs text-slate-400 col-span-full">Belum ada foto tersimpan.</span>';
    } else {
        cleanPhotos.forEach((photo, idx) => {
            const card = document.createElement('div');
            card.className = 'relative aspect-square rounded-lg overflow-hidden border border-slate-300 bg-white group shadow-sm';
            card.innerHTML = `
                <img src="${photo}" class="w-full h-full object-cover">
                <label class="absolute inset-0 bg-slate-900/60 opacity-0 group-hover:opacity-100 flex flex-col items-center justify-center text-white cursor-pointer transition p-1 text-center">
                    <input type="checkbox" name="remove_photos[]" value="${photo}" class="w-4 h-4 text-red-600 rounded mb-1">
                    <span class="text-[10px] font-bold text-rose-300">Centang Hapus</span>
                </label>
            `;
            existingContainer.appendChild(card);
        });
    }

    modal.classList.remove('hidden');
    modal.classList.add('flex');
}

function closeEditModal() {
    const modal = document.getElementById('editModal');
    modal.classList.add('hidden');
    modal.classList.remove('flex');
}

// Close modals when clicking outside
window.onclick = function(event) {
    const pModal = document.getElementById('previewModal');
    const eModal = document.getElementById('editModal');
    if (event.target === pModal) closePreviewModal();
    if (event.target === eModal) closeEditModal();
};
</script>
@endsection
