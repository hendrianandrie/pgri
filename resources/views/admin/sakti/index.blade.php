@extends('admin.layout')

@section('title', 'Kelola ' . $meta['title'])
@section('page_title', $meta['title'])

@section('content')
<div class="space-y-6">

    <!-- Pillar Quick Switch Tabs -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-3">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-2 text-xs font-bold">
            <a href="{{ route('admin.sakti.pembelajaran-mendalam') }}" 
               class="flex items-center justify-center gap-2 py-2.5 px-3 rounded-xl transition {{ $meta['category'] === 'pembelajaran_mendalam' ? 'bg-sky-600 text-white shadow-md' : 'bg-slate-50 text-slate-600 hover:bg-slate-100' }}">
                <i class="fa-solid fa-brain {{ $meta['category'] === 'pembelajaran_mendalam' ? 'text-white' : 'text-sky-500' }}"></i>
                <span>Pembelajaran Mendalam</span>
            </a>

            <a href="{{ route('admin.sakti.rumah-pendidikan') }}" 
               class="flex items-center justify-center gap-2 py-2.5 px-3 rounded-xl transition {{ $meta['category'] === 'rumah_pendidikan' ? 'bg-emerald-600 text-white shadow-md' : 'bg-slate-50 text-slate-600 hover:bg-slate-100' }}">
                <i class="fa-solid fa-folder-open {{ $meta['category'] === 'rumah_pendidikan' ? 'text-white' : 'text-emerald-500' }}"></i>
                <span>Rumah Pendidikan</span>
            </a>

            <a href="{{ route('admin.sakti.pid') }}" 
               class="flex items-center justify-center gap-2 py-2.5 px-3 rounded-xl transition {{ $meta['category'] === 'pid' ? 'bg-amber-600 text-white shadow-md' : 'bg-slate-50 text-slate-600 hover:bg-slate-100' }}">
                <i class="fa-solid fa-bullhorn {{ $meta['category'] === 'pid' ? 'text-white' : 'text-amber-500' }}"></i>
                <span>Pusat Informasi & Data</span>
            </a>

            <a href="{{ route('admin.sakti.koding-kka') }}" 
               class="flex items-center justify-center gap-2 py-2.5 px-3 rounded-xl transition {{ $meta['category'] === 'koding_kka' ? 'bg-purple-600 text-white shadow-md' : 'bg-slate-50 text-slate-600 hover:bg-slate-100' }}">
                <i class="fa-solid fa-code {{ $meta['category'] === 'koding_kka' ? 'text-white' : 'text-purple-500' }}"></i>
                <span>Koding & AI (KKA)</span>
            </a>
        </div>
    </div>

    <!-- Active Pillar Header / Banner -->
    <div class="bg-gradient-to-r 
        @if($meta['category'] === 'pembelajaran_mendalam') from-sky-900 via-sky-800 to-slate-900
        @elseif($meta['category'] === 'rumah_pendidikan') from-emerald-900 via-emerald-800 to-slate-900
        @elseif($meta['category'] === 'pid') from-amber-900 via-amber-800 to-slate-900
        @else from-purple-900 via-purple-800 to-slate-900 @endif
        text-white rounded-2xl p-6 shadow-md relative overflow-hidden flex flex-col md:flex-row md:items-center justify-between gap-4">
        
        <div class="relative z-10 flex items-center gap-4">
            <div class="w-14 h-14 rounded-2xl bg-white/10 backdrop-blur border border-white/20 flex items-center justify-center text-2xl shadow-inner">
                <i class="fa-solid fa-{{ $meta['icon'] }} 
                    @if($meta['category'] === 'pembelajaran_mendalam') text-sky-300
                    @elseif($meta['category'] === 'rumah_pendidikan') text-emerald-300
                    @elseif($meta['category'] === 'pid') text-amber-300
                    @else text-purple-300 @endif"></i>
            </div>
            <div>
                <div class="flex items-center gap-2">
                    <span class="text-[10px] font-black uppercase tracking-wider px-2 py-0.5 rounded bg-white/20 text-white">
                        Pilar SAKTI
                    </span>
                    <span class="text-xs text-slate-300">{{ $meta['subtitle'] }}</span>
                </div>
                <h1 class="text-xl md:text-2xl font-extrabold text-white mt-1">{{ $meta['title'] }}</h1>
            </div>
        </div>

        <div class="relative z-10 flex items-center gap-3">
            <div class="bg-white/10 backdrop-blur rounded-xl px-4 py-2 border border-white/15 text-center">
                <span class="block text-2xl font-extrabold text-white">{{ $meta['count'] }}</span>
                <span class="text-[10px] text-slate-300 font-semibold uppercase tracking-wider">Total Konten</span>
            </div>
        </div>
    </div>

    <!-- FORM INPUT KONTEN (SERAGAM UNTUK SEMUA PILAR) -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6">
        <div class="border-b border-slate-100 pb-4 mb-5">
            <h3 class="text-base font-bold text-slate-800 flex items-center gap-2">
                <i class="fa-solid fa-circle-plus 
                    @if($meta['category'] === 'pembelajaran_mendalam') text-sky-600
                    @elseif($meta['category'] === 'rumah_pendidikan') text-emerald-600
                    @elseif($meta['category'] === 'pid') text-amber-600
                    @else text-purple-600 @endif"></i>
                <span>Tambah Data Modul: <span class="font-extrabold">{{ $meta['title'] }}</span></span>
            </h3>
            <p class="text-xs text-slate-500 mt-1">Lengkapi formulir modul termasuk jenjang pendidikan, nama penyusun, asal sekolah, dan tautan modul.</p>
        </div>

        <form action="{{ route('admin.sakti.store') }}" method="POST" enctype="multipart/form-data" class="grid grid-cols-1 md:grid-cols-2 gap-4">
            @csrf
            <input type="hidden" name="category" value="{{ $meta['category'] }}">

            <!-- 1. Nama Modul / Judul -->
            <div class="md:col-span-2">
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">
                    Nama Modul / Judul Konten <span class="text-red-500">*</span>
                </label>
                <input type="text" name="title" required value="{{ old('title') }}" 
                       placeholder="Contoh: Modul {{ $meta['title'] }} Berbasis Proyek Abad 21" 
                       class="w-full bg-slate-50 border border-slate-300 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-red-500 focus:bg-white transition">
            </div>

            <!-- 2. Tingkat (PAUD, TK, SD, SMP, SMA/K, Umum) -->
            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">
                    Tingkat Pendidikan <span class="text-red-500">*</span>
                </label>
                <select name="tingkat" required class="w-full bg-slate-50 border border-slate-300 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-red-500 focus:bg-white transition font-medium">
                    <option value="">-- Pilih Tingkat --</option>
                    <option value="PAUD" {{ old('tingkat') == 'PAUD' ? 'selected' : '' }}>PAUD (Pendidikan Anak Usia Dini)</option>
                    <option value="TK" {{ old('tingkat') == 'TK' ? 'selected' : '' }}>TK (Taman Kanak-Kanak)</option>
                    <option value="SD" {{ old('tingkat') == 'SD' ? 'selected' : '' }}>SD (Sekolah Dasar)</option>
                    <option value="SMP" {{ old('tingkat') == 'SMP' ? 'selected' : '' }}>SMP (Sekolah Menengah Pertama)</option>
                    <option value="SMA/K" {{ old('tingkat') == 'SMA/K' ? 'selected' : '' }}>SMA/K (Sekolah Menengah Atas / Kejuruan)</option>
                    <option value="Umum" {{ old('tingkat') == 'Umum' ? 'selected' : '' }}>Umum (Semua Jenjang)</option>
                </select>
            </div>

            <!-- 3. Nama Penyusun Modul -->
            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">
                    Nama Penyusun Modul <span class="text-red-500">*</span>
                </label>
                <input type="text" name="author" required value="{{ old('author') }}" 
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
                    <input type="text" name="school_origin" value="{{ old('school_origin') }}" 
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
                    <input type="url" name="file_url" required value="{{ old('file_url') }}" 
                           placeholder="https://drive.google.com/... atau tautan berkas modul" 
                           class="w-full bg-slate-50 border border-slate-300 rounded-xl pl-10 pr-4 py-2.5 text-sm focus:outline-none focus:border-red-500 focus:bg-white transition">
                </div>
            </div>

            <!-- 6. Upload Gambar Modul -->
            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">
                    Upload Gambar Modul / Sampul (File)
                </label>
                <input type="file" name="image_file" accept="image/*" 
                       class="w-full bg-slate-50 border border-slate-300 rounded-xl px-3 py-2 text-xs text-slate-600 file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-red-50 file:text-red-700 hover:file:bg-red-100 transition">
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">
                    Atau URL Gambar (Opsional)
                </label>
                <input type="text" name="image" value="{{ old('image') }}" 
                       placeholder="https://images.unsplash.com/..." 
                       class="w-full bg-slate-50 border border-slate-300 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-red-500 focus:bg-white transition">
            </div>

            <!-- 7. Ringkasan / Keterangan Singkat -->
            <div class="md:col-span-2">
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">
                    Ringkasan / Keterangan Singkat (Opsional)
                </label>
                <input type="text" name="summary" value="{{ old('summary') }}" 
                       placeholder="Ringkasan isi atau sasaran pembelajaran modul..." 
                       class="w-full bg-slate-50 border border-slate-300 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-red-500 focus:bg-white transition">
            </div>

            <div class="md:col-span-2 flex items-center justify-between pt-2">
                <label class="flex items-center gap-2 cursor-pointer text-sm font-semibold text-slate-700">
                    <input type="checkbox" name="is_featured" value="1" class="rounded border-slate-300 text-red-600 focus:ring-red-500">
                    <span>Tandai sebagai Modul Unggulan (Featured)</span>
                </label>

                <button type="submit" 
                        class="text-white text-sm font-bold px-6 py-2.5 rounded-xl shadow-md transition flex items-center gap-2
                        @if($meta['category'] === 'pembelajaran_mendalam') bg-sky-700 hover:bg-sky-800
                        @elseif($meta['category'] === 'rumah_pendidikan') bg-emerald-700 hover:bg-emerald-800
                        @elseif($meta['category'] === 'pid') bg-amber-700 hover:bg-amber-800
                        @else bg-purple-700 hover:bg-purple-800 @endif">
                    <i class="fa-solid fa-floppy-disk"></i>
                    <span>Simpan Modul {{ $meta['title'] }}</span>
                </button>
            </div>
        </form>
    </div>

    <!-- Table List (SERAGAM UNTUK SEMUA PILAR) -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="p-5 border-b border-slate-100 flex flex-col md:flex-row items-center justify-between gap-4">
            <div>
                <h3 class="font-bold text-slate-800 text-base flex items-center gap-2">
                    <i class="fa-solid fa-table-list text-slate-500"></i>
                    <span>Daftar Konten {{ $meta['title'] }}</span>
                </h3>
                <p class="text-xs text-slate-500">Menampilkan {{ $contents->total() }} modul dalam pilar ini</p>
            </div>

            <!-- Search & Filters -->
            <form method="GET" class="w-full md:w-auto flex flex-wrap items-center gap-2">
                <!-- Filter Tingkat -->
                <select name="tingkat" onchange="this.form.submit()" class="bg-slate-50 border border-slate-300 rounded-xl px-3 py-2 text-xs font-semibold focus:outline-none focus:border-red-500">
                    <option value="">Semua Tingkat</option>
                    <option value="PAUD" {{ request('tingkat') == 'PAUD' ? 'selected' : '' }}>PAUD</option>
                    <option value="TK" {{ request('tingkat') == 'TK' ? 'selected' : '' }}>TK</option>
                    <option value="SD" {{ request('tingkat') == 'SD' ? 'selected' : '' }}>SD</option>
                    <option value="SMP" {{ request('tingkat') == 'SMP' ? 'selected' : '' }}>SMP</option>
                    <option value="SMA/K" {{ request('tingkat') == 'SMA/K' ? 'selected' : '' }}>SMA/K</option>
                    <option value="Umum" {{ request('tingkat') == 'Umum' ? 'selected' : '' }}>Umum</option>
                </select>

                <div class="flex items-center gap-2 flex-1 md:w-64">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari judul, penyusun, sekolah..." class="w-full bg-slate-50 border border-slate-300 rounded-xl px-3 py-2 text-xs focus:outline-none focus:border-red-500">
                    <button type="submit" class="bg-slate-800 hover:bg-slate-900 text-white px-3 py-2 rounded-xl text-xs font-semibold">
                        <i class="fa-solid fa-search"></i>
                    </button>
                </div>

                @if(request('search') || request('tingkat'))
                    <a href="{{ url()->current() }}" class="text-xs text-red-600 hover:underline">Reset</a>
                @endif
            </form>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-200 text-xs font-bold uppercase tracking-wider text-slate-500">
                        <th class="py-3.5 px-4 w-16">Sampul</th>
                        <th class="py-3.5 px-4">Nama Modul</th>
                        <th class="py-3.5 px-4">Tingkat</th>
                        <th class="py-3.5 px-4">Penyusun & Asal Sekolah</th>
                        <th class="py-3.5 px-4">Link Modul</th>
                        <th class="py-3.5 px-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-sm">
                    @forelse($contents as $item)
                        <tr class="hover:bg-slate-50/80 transition">
                            <!-- Sampul -->
                            <td class="py-3.5 px-4">
                                @if($item->image)
                                    <img src="{{ $item->image }}" alt="{{ $item->title }}" class="w-12 h-12 object-cover rounded-lg border border-slate-200 shadow-sm">
                                @else
                                    <div class="w-12 h-12 rounded-lg flex items-center justify-center font-bold text-xs border
                                        @if($meta['category'] === 'pembelajaran_mendalam') bg-sky-50 text-sky-600 border-sky-200
                                        @elseif($meta['category'] === 'rumah_pendidikan') bg-emerald-50 text-emerald-600 border-emerald-200
                                        @elseif($meta['category'] === 'pid') bg-amber-50 text-amber-600 border-amber-200
                                        @else bg-purple-50 text-purple-600 border-purple-200 @endif">
                                        <i class="fa-solid fa-{{ $meta['icon'] }} text-base"></i>
                                    </div>
                                @endif
                            </td>

                            <!-- Nama Modul -->
                            <td class="py-3.5 px-4">
                                <div class="font-bold text-slate-800">{{ $item->title }}</div>
                                @if($item->summary)
                                    <div class="text-xs text-slate-400 line-clamp-1 mt-0.5">{{ $item->summary }}</div>
                                @endif
                                @if($item->is_featured)
                                    <span class="inline-flex items-center gap-1 text-[10px] font-bold text-amber-600 bg-amber-50 px-2 py-0.5 rounded-full border border-amber-200 mt-1">
                                        <i class="fa-solid fa-star text-[9px]"></i> Featured
                                    </span>
                                @endif
                            </td>

                            <!-- Tingkat -->
                            <td class="py-3.5 px-4 whitespace-nowrap">
                                @php
                                    $badge = strtoupper($item->badge ?? 'UMUM');
                                    $badgeClass = match($badge) {
                                        'PAUD' => 'bg-pink-100 text-pink-700 border-pink-200',
                                        'TK' => 'bg-orange-100 text-orange-700 border-orange-200',
                                        'SD' => 'bg-emerald-100 text-emerald-700 border-emerald-200',
                                        'SMP' => 'bg-sky-100 text-sky-700 border-sky-200',
                                        'SMA/K', 'SMA', 'SMK' => 'bg-purple-100 text-purple-700 border-purple-200',
                                        default => 'bg-slate-100 text-slate-700 border-slate-200',
                                    };
                                @endphp
                                <span class="inline-block text-xs font-extrabold px-2.5 py-1 rounded-lg border {{ $badgeClass }}">
                                    {{ $item->badge ?? 'Umum' }}
                                </span>
                            </td>

                            <!-- Nama Penyusun & Asal Sekolah -->
                            <td class="py-3.5 px-4 text-xs font-semibold text-slate-700">
                                <div class="flex items-center gap-1.5 font-bold text-slate-800">
                                    <i class="fa-solid fa-user-pen text-slate-400"></i>
                                    <span>{{ $item->author ?? 'Pengurus PGRI' }}</span>
                                </div>
                                @if($item->school_origin)
                                    <div class="flex items-center gap-1.5 text-[11px] text-slate-500 mt-1 font-medium">
                                        <i class="fa-solid fa-school text-slate-400 text-[10px]"></i>
                                        <span>{{ $item->school_origin }}</span>
                                    </div>
                                @endif
                            </td>

                            <!-- Link Modul -->
                            <td class="py-3.5 px-4 whitespace-nowrap">
                                @if($item->file_url)
                                    <a href="{{ $item->file_url }}" target="_blank" rel="noopener noreferrer" 
                                       class="inline-flex items-center gap-1.5 text-xs font-bold px-3 py-1.5 rounded-lg border transition
                                       @if($meta['category'] === 'pembelajaran_mendalam') text-sky-700 bg-sky-50 hover:bg-sky-100 border-sky-200
                                       @elseif($meta['category'] === 'rumah_pendidikan') text-emerald-700 bg-emerald-50 hover:bg-emerald-100 border-emerald-200
                                       @elseif($meta['category'] === 'pid') text-amber-700 bg-amber-50 hover:bg-amber-100 border-amber-200
                                       @else text-purple-700 bg-purple-50 hover:bg-purple-100 border-purple-200 @endif">
                                        <i class="fa-solid fa-arrow-up-right-from-square text-[10px]"></i>
                                        <span>Buka Link</span>
                                    </a>
                                @else
                                    <span class="text-xs text-slate-400 italic">Tidak ada link</span>
                                @endif
                            </td>

                            <!-- Aksi -->
                            <td class="py-3.5 px-4 text-right whitespace-nowrap">
                                <div class="inline-flex items-center gap-1.5">
                                    <a href="{{ route('admin.sakti.edit', $item->id) }}" 
                                       class="text-amber-600 hover:text-amber-800 text-xs font-bold p-1.5 bg-amber-50 hover:bg-amber-100 rounded-lg transition inline-flex items-center gap-1"
                                       title="Edit Modul">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                        <span>Edit</span>
                                    </a>

                                    <form action="{{ route('admin.sakti.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus modul ini?')" class="inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-800 text-xs font-bold p-1.5 bg-red-50 hover:bg-red-100 rounded-lg transition inline-flex items-center gap-1"
                                                title="Hapus Modul">
                                            <i class="fa-solid fa-trash"></i>
                                            <span>Hapus</span>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-10 text-center text-slate-400 text-sm">
                                <i class="fa-solid fa-inbox text-3xl mb-2 text-slate-300 block"></i>
                                Belum ada data modul pada pilar {{ $meta['title'] }}.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($contents->hasPages())
            <div class="p-4 border-t border-slate-100">
                {{ $contents->links() }}
            </div>
        @endif
    </div>

</div>
@endsection
