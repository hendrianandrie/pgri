@extends('admin.layout')

@section('title', 'Pengaturan Profil & Visi Misi')
@section('page_title', 'Pengaturan Profil & Visi Misi PGRI')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">

    @if(session('success'))
    <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 px-4 py-3 rounded-xl flex items-center gap-3 shadow-sm">
        <i class="fa-solid fa-circle-check text-emerald-600 text-lg"></i>
        <span class="text-sm font-semibold">{{ session('success') }}</span>
    </div>
    @endif

    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 md:p-8">
        <div class="border-b border-slate-100 pb-4 mb-6 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div class="flex items-center gap-3">
                <div class="w-11 h-11 rounded-xl bg-red-50 text-red-600 flex items-center justify-center font-bold text-xl border border-red-100 flex-shrink-0">
                    <i class="fa-solid fa-address-card"></i>
                </div>
                <div>
                    <h2 class="text-lg font-bold text-slate-800">Profil, Visi, Misi & Pengurus</h2>
                    <p class="text-xs text-slate-500">Kelola narasi visi, pilar misi, serta teks header halaman profil organisasi</p>
                </div>
            </div>
            <a href="{{ route('profile') }}" target="_blank" class="text-xs font-bold text-red-700 hover:text-red-800 bg-red-50 hover:bg-red-100 px-3.5 py-2 rounded-lg border border-red-200 transition inline-flex items-center gap-1.5 self-start sm:self-auto">
                <i class="fa-solid fa-arrow-up-right-from-square"></i>
                <span>Lihat Halaman Profil Publik</span>
            </a>
        </div>

        <form action="{{ route('admin.profile-settings.update') }}" method="POST" class="space-y-8">
            @csrf

            <!-- BAGIAN 1: HEADER BANNER PROFIL -->
            <div class="space-y-4">
                <div class="flex items-center gap-2 pb-2 border-b border-slate-100">
                    <span class="w-6 h-6 rounded-full bg-red-100 text-red-700 flex items-center justify-center text-xs font-bold">1</span>
                    <h3 class="text-sm font-bold text-slate-800 uppercase tracking-wider">Header & Banner Halaman Profil</h3>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">
                            <span>Badge Header</span>
                        </label>
                        <input type="text" name="badge" value="{{ old('badge', $profile['badge']) }}" 
                               placeholder="Contoh: TENTANG ORGANISASI" 
                               class="w-full bg-slate-50 border border-slate-300 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-red-500 focus:bg-white transition">
                        <p class="text-[11px] text-slate-400 mt-1">Label pil kecil di atas judul utama</p>
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">
                            <span>Judul Utama Profil</span>
                            <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="title" required value="{{ old('title', $profile['title']) }}" 
                               placeholder="Contoh: Profil Persatuan Guru Republik Indonesia" 
                               class="w-full bg-slate-50 border border-slate-300 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-red-500 focus:bg-white transition">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">
                        <span>Subjudul / Pengantar Profil</span>
                        <span class="text-red-500">*</span>
                    </label>
                    <textarea name="subtitle" rows="2" required 
                              placeholder="Deskripsi singkat yang tampil di bawah judul..." 
                              class="w-full bg-slate-50 border border-slate-300 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-red-500 focus:bg-white transition">{{ old('subtitle', $profile['subtitle']) }}</textarea>
                </div>
            </div>

            <!-- BAGIAN 2: VISI ORGANISASI -->
            <div class="space-y-4 pt-4 border-t border-slate-100">
                <div class="flex items-center gap-2 pb-2 border-b border-slate-100">
                    <span class="w-6 h-6 rounded-full bg-red-100 text-red-700 flex items-center justify-center text-xs font-bold">2</span>
                    <h3 class="text-sm font-bold text-slate-800 uppercase tracking-wider flex items-center gap-1.5">
                        <i class="fa-solid fa-eye text-red-600"></i>
                        <span>Visi Organisasi</span>
                    </h3>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">
                            <span>Judul Blok Visi</span>
                        </label>
                        <input type="text" name="visi_title" value="{{ old('visi_title', $profile['visi_title']) }}" 
                               placeholder="Visi PGRI" 
                               class="w-full bg-slate-50 border border-slate-300 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-red-500 focus:bg-white transition">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">
                            <span>Subjudul Blok Visi</span>
                        </label>
                        <input type="text" name="visi_subtitle" value="{{ old('visi_subtitle', $profile['visi_subtitle']) }}" 
                               placeholder="Arah & Cita-cita Organisasi" 
                               class="w-full bg-slate-50 border border-slate-300 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-red-500 focus:bg-white transition">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">
                        <span>Pernyataan Visi</span>
                        <span class="text-red-500">*</span>
                    </label>
                    <textarea name="visi" rows="3" required 
                              placeholder="Tuliskan pernyataan visi resmi organisasi..." 
                              class="w-full bg-slate-50 border border-slate-300 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-red-500 focus:bg-white transition">{{ old('visi', $profile['visi']) }}</textarea>
                    <p class="text-[11px] text-slate-400 mt-1">Ditampilkan dengan format kutipan tebal pada kartu Visi.</p>
                </div>
            </div>

            <!-- BAGIAN 3: MISI ORGANISASI -->
            <div class="space-y-4 pt-4 border-t border-slate-100">
                <div class="flex items-center gap-2 pb-2 border-b border-slate-100">
                    <span class="w-6 h-6 rounded-full bg-red-100 text-red-700 flex items-center justify-center text-xs font-bold">3</span>
                    <h3 class="text-sm font-bold text-slate-800 uppercase tracking-wider flex items-center gap-1.5">
                        <i class="fa-solid fa-bullseye text-amber-500"></i>
                        <span>Misi Organisasi</span>
                    </h3>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">
                            <span>Judul Blok Misi</span>
                        </label>
                        <input type="text" name="misi_title" value="{{ old('misi_title', $profile['misi_title']) }}" 
                               placeholder="Misi PGRI" 
                               class="w-full bg-slate-50 border border-slate-300 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-red-500 focus:bg-white transition">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">
                            <span>Subjudul Blok Misi</span>
                        </label>
                        <input type="text" name="misi_subtitle" value="{{ old('misi_subtitle', $profile['misi_subtitle']) }}" 
                               placeholder="Empat Pilar Pelaksanaan Kerja" 
                               class="w-full bg-slate-50 border border-slate-300 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-red-500 focus:bg-white transition">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">
                        <span>Poin-Poin Misi (1 Baris per Misi)</span>
                        <span class="text-red-500">*</span>
                    </label>
                    <textarea name="misi" rows="6" required 
                              placeholder="Tuliskan setiap poin misi pada baris baru (tekan Enter untuk baris berikutnya)..." 
                              class="w-full bg-slate-50 border border-slate-300 rounded-xl px-4 py-2.5 text-sm font-sans focus:outline-none focus:border-red-500 focus:bg-white transition leading-relaxed">{{ old('misi', $profile['misi']) }}</textarea>
                    <div class="flex items-start gap-2 mt-1.5 text-[11px] text-slate-500 bg-amber-50/70 border border-amber-200/60 p-2.5 rounded-lg">
                        <i class="fa-solid fa-lightbulb text-amber-600 mt-0.5"></i>
                        <span><strong>Petunjuk:</strong> Cukup ketik 1 butir misi per baris (tekan Enter untuk poin baru). Sistem akan otomatis memberi nomor urut 1, 2, 3... pada tampilan website publik.</span>
                    </div>
                </div>
            </div>

            <!-- BAGIAN 4: STRUKTUR PENGURUS -->
            <div class="space-y-4 pt-4 border-t border-slate-100">
                <div class="flex items-center gap-2 pb-2 border-b border-slate-100">
                    <span class="w-6 h-6 rounded-full bg-red-100 text-red-700 flex items-center justify-center text-xs font-bold">4</span>
                    <h3 class="text-sm font-bold text-slate-800 uppercase tracking-wider flex items-center gap-1.5">
                        <i class="fa-solid fa-users text-emerald-600"></i>
                        <span>Bagian Struktur Pengurus</span>
                    </h3>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">
                            <span>Badge Pengurus</span>
                        </label>
                        <input type="text" name="executives_badge" value="{{ old('executives_badge', $profile['executives_badge']) }}" 
                               placeholder="JABATAN ORGANISASI" 
                               class="w-full bg-slate-50 border border-slate-300 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-red-500 focus:bg-white transition">
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">
                            <span>Judul Bagian Pengurus</span>
                        </label>
                        <input type="text" name="executives_title" value="{{ old('executives_title', $profile['executives_title']) }}" 
                               placeholder="Struktur Pengurus PGRI Cabang Ciamis" 
                               class="w-full bg-slate-50 border border-slate-300 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-red-500 focus:bg-white transition">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">
                        <span>Deskripsi Singkat Pengurus</span>
                    </label>
                    <input type="text" name="executives_subtitle" value="{{ old('executives_subtitle', $profile['executives_subtitle']) }}" 
                           placeholder="Jajaran kepemimpinan yang mengabdi pada Pengurus PGRI Cabang Ciamis." 
                           class="w-full bg-slate-50 border border-slate-300 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-red-500 focus:bg-white transition">
                </div>

                <!-- Card Pintasan Kelola Anggota Pengurus -->
                <div class="bg-slate-50 border border-slate-200 rounded-xl p-4 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-lg bg-emerald-100 text-emerald-700 flex items-center justify-center font-bold text-lg flex-shrink-0">
                            <i class="fa-solid fa-users-gear"></i>
                        </div>
                        <div>
                            <h4 class="text-xs font-bold text-slate-800">Daftar & Foto Pengurus PGRI</h4>
                            <p class="text-[11px] text-slate-500">Kelola foto, nama, jabatan, unit kerja, dan urutan tampil masing-masing pengurus</p>
                        </div>
                    </div>
                    <a href="{{ route('admin.executives.index') }}" class="bg-white hover:bg-slate-100 text-slate-800 border border-slate-300 text-xs font-bold px-3.5 py-2 rounded-lg transition inline-flex items-center gap-1.5 self-start sm:self-auto shadow-sm">
                        <i class="fa-solid fa-arrow-right text-emerald-600"></i>
                        <span>Buka Kelola Pengurus</span>
                    </a>
                </div>
            </div>

            <!-- Submit Button -->
            <div class="flex items-center justify-end pt-4 border-t border-slate-100 gap-3">
                <a href="{{ route('admin.dashboard') }}" class="text-xs font-bold text-slate-500 hover:text-slate-800 px-4 py-2.5 rounded-xl transition">
                    Batal
                </a>
                <button type="submit" class="bg-red-700 hover:bg-red-800 text-white text-sm font-bold px-6 py-2.5 rounded-xl shadow-md transition flex items-center gap-2">
                    <i class="fa-solid fa-floppy-disk"></i>
                    <span>Simpan Perubahan Profil</span>
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
