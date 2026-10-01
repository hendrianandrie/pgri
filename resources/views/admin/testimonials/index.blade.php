@extends('admin.layout')

@section('title', 'Manajemen Testimoni Guru')
@section('page_title', 'Testimoni & Suara Guru Indonesia')

@section('content')
<div class="space-y-6">

    <!-- Header Actions -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-white p-5 rounded-2xl border border-slate-200 shadow-sm">
        <div>
            <h3 class="text-base font-bold text-slate-800 flex items-center gap-2">
                <i class="fa-solid fa-comments text-amber-500"></i>
                <span>Daftar Testimoni Guru (Kisah Dampak)</span>
                <span class="bg-amber-100 text-amber-800 text-xs px-2.5 py-0.5 rounded-full font-bold">{{ $testimonials->count() }}</span>
            </h3>
            <p class="text-xs text-slate-500 mt-0.5">Kelola testimoni guru yang tampil pada seksi Kisah Dampak PGRI & SAKTI di halaman Beranda</p>
        </div>
        <div class="flex items-center gap-2">
            <a href="{{ route('home') }}#suara-guru" target="_blank" class="text-xs font-bold text-slate-700 bg-slate-100 hover:bg-slate-200 px-3.5 py-2 rounded-xl transition inline-flex items-center gap-1.5">
                <i class="fa-solid fa-arrow-up-right-from-square"></i>
                <span>Lihat di Beranda</span>
            </a>
            <button onclick="document.getElementById('addSection').scrollIntoView({behavior: 'smooth'})" class="text-xs font-bold text-white bg-red-700 hover:bg-red-800 px-4 py-2 rounded-xl shadow-md transition inline-flex items-center gap-1.5">
                <i class="fa-solid fa-plus"></i>
                <span>Tambah Testimoni</span>
            </button>
        </div>
    </div>

    <!-- Testimonial Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
        @forelse($testimonials as $testi)
            <div class="bg-white rounded-2xl border border-slate-200 p-5 shadow-sm flex flex-col justify-between hover:shadow-md transition">
                <div>
                    <!-- Top Info: Rating & Order -->
                    <div class="flex items-center justify-between mb-3 pb-2 border-b border-slate-100">
                        <div class="flex text-amber-400 text-sm">
                            @for($i = 1; $i <= 5; $i++)
                                <i class="fa-solid fa-star {{ $i <= $testi->rating ? '' : 'text-slate-200' }}"></i>
                            @endfor
                        </div>
                        <span class="text-[11px] font-bold text-slate-400 bg-slate-100 px-2 py-0.5 rounded-md">Urutan: #{{ $testi->order }}</span>
                    </div>

                    <!-- Quote -->
                    <p class="text-sm text-slate-600 italic leading-relaxed mb-4">
                        "{{ $testi->quote }}"
                    </p>
                </div>

                <div class="pt-4 border-t border-slate-100">
                    <div class="flex items-center justify-between gap-3">
                        <div class="flex items-center gap-3 min-w-0">
                            <img src="{{ $testi->photo }}" alt="{{ $testi->name }}" class="w-11 h-11 rounded-full object-cover border border-slate-200 shadow-sm flex-shrink-0">
                            <div class="min-w-0">
                                <h4 class="text-sm font-bold text-slate-800 truncate">{{ $testi->name }}</h4>
                                <p class="text-xs text-slate-500 truncate">{{ $testi->role_origin }}</p>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex items-center gap-1.5 flex-shrink-0">
                            <button onclick='openEditModal(@json($testi))' class="w-8 h-8 rounded-lg bg-amber-50 hover:bg-amber-100 text-amber-700 flex items-center justify-center transition text-xs" title="Edit Testimoni">
                                <i class="fa-solid fa-pen-to-square"></i>
                            </button>
                            <form action="{{ route('admin.testimonials.destroy', $testi->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus testimoni dari {{ $testi->name }}?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="w-8 h-8 rounded-lg bg-red-50 hover:bg-red-100 text-red-600 flex items-center justify-center transition text-xs" title="Hapus Testimoni">
                                    <i class="fa-solid fa-trash-can"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full bg-white rounded-2xl border border-slate-200 p-12 text-center text-slate-400">
                <i class="fa-solid fa-comment-slash text-4xl mb-3 text-slate-300"></i>
                <p class="text-sm font-medium">Belum ada data testimoni guru yang ditambahkan.</p>
            </div>
        @endforelse
    </div>

    <!-- Form Tambah Testimoni Baru -->
    <div id="addSection" class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 md:p-8 mt-8">
        <div class="flex items-center gap-3 pb-4 mb-6 border-b border-slate-100">
            <div class="w-10 h-10 rounded-xl bg-red-50 text-red-600 flex items-center justify-center font-bold text-lg border border-red-100">
                <i class="fa-solid fa-plus"></i>
            </div>
            <div>
                <h3 class="text-base font-bold text-slate-800">Tambah Testimoni Baru</h3>
                <p class="text-xs text-slate-500">Masukkan data guru dan ulasan/dampak positif yang dirasakan</p>
            </div>
        </div>

        <form action="{{ route('admin.testimonials.store') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <!-- Nama Lengkap & Gelar -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1 flex items-center gap-1.5">
                        <i class="fa-solid fa-user text-red-600"></i>
                        <span>Nama Lengkap & Gelar</span>
                        <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="name" required value="{{ old('name') }}" 
                           placeholder="Contoh: Dewi Rahmawati, S.Pd." 
                           class="w-full bg-slate-50 border border-slate-300 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-red-500 focus:bg-white transition">
                </div>

                <!-- Posisi & Asal Sekolah -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1 flex items-center gap-1.5">
                        <i class="fa-solid fa-school text-emerald-600"></i>
                        <span>Posisi / Asal Sekolah & Wilayah</span>
                        <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="role_origin" required value="{{ old('role_origin') }}" 
                           placeholder="Contoh: Guru SD — Jawa Tengah" 
                           class="w-full bg-slate-50 border border-slate-300 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-red-500 focus:bg-white transition">
                </div>

                <!-- Rating Bintang & Urutan -->
                <div class="grid grid-cols-2 gap-2">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1 flex items-center gap-1.5">
                            <i class="fa-solid fa-star text-amber-500"></i>
                            <span>Rating Bintang</span>
                            <span class="text-red-500">*</span>
                        </label>
                        <select name="rating" required class="w-full bg-slate-50 border border-slate-300 rounded-xl px-3 py-2.5 text-sm focus:outline-none focus:border-red-500 focus:bg-white transition">
                            <option value="5" selected>⭐⭐⭐⭐⭐ (5 Bintang)</option>
                            <option value="4">⭐⭐⭐⭐ (4 Bintang)</option>
                            <option value="3">⭐⭐⭐ (3 Bintang)</option>
                            <option value="2">⭐⭐ (2 Bintang)</option>
                            <option value="1">⭐ (1 Bintang)</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1 flex items-center gap-1.5">
                            <i class="fa-solid fa-arrow-down-1-9 text-slate-500"></i>
                            <span>No. Urutan</span>
                        </label>
                        <input type="number" name="order" value="{{ old('order', $testimonials->count() + 1) }}" 
                               class="w-full bg-slate-50 border border-slate-300 rounded-xl px-3 py-2.5 text-sm focus:outline-none focus:border-red-500 focus:bg-white transition">
                    </div>
                </div>
            </div>

            <!-- Isi Testimoni / Kutipan -->
            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1 flex items-center gap-1.5">
                    <i class="fa-solid fa-quote-left text-sky-500"></i>
                    <span>Isi Testimoni / Kutipan Guru</span>
                    <span class="text-red-500">*</span>
                </label>
                <textarea name="quote" rows="3" required 
                          placeholder="Masukkan kata-kata testimoni atau pengalaman guru..." 
                          class="w-full bg-slate-50 border border-slate-300 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-red-500 focus:bg-white transition">{{ old('quote') }}</textarea>
            </div>

            <!-- Upload Foto Guru -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1 flex items-center gap-1.5">
                        <i class="fa-solid fa-camera text-red-600"></i>
                        <span>Upload Foto Guru (File)</span>
                    </label>
                    <input type="file" name="photo_file" accept="image/*" 
                           class="w-full bg-slate-50 border border-slate-300 rounded-xl px-4 py-2 text-sm focus:outline-none focus:border-red-500 transition file:mr-4 file:py-1 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-red-700 file:text-white hover:file:bg-red-800 cursor-pointer">
                    <p class="text-[11px] text-slate-400 mt-1">Format: JPG, PNG, WebP (Maks 5MB). Foto akan dipotong bulat secara otomatis.</p>
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1 flex items-center gap-1.5">
                        <i class="fa-solid fa-link text-slate-400"></i>
                        <span>Atau URL Foto (Opsional)</span>
                    </label>
                    <input type="text" name="photo_url" value="{{ old('photo_url') }}" 
                           placeholder="https://..." 
                           class="w-full bg-slate-50 border border-slate-300 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-red-500 focus:bg-white transition">
                </div>
            </div>

            <!-- Submit Button -->
            <div class="flex items-center justify-end pt-4 border-t border-slate-100">
                <button type="submit" class="bg-red-700 hover:bg-red-800 text-white text-sm font-bold px-6 py-2.5 rounded-xl shadow-md transition flex items-center gap-2">
                    <i class="fa-solid fa-plus"></i>
                    <span>Simpan Testimoni Baru</span>
                </button>
            </div>
        </form>
    </div>

</div>

<!-- Modal Edit Testimoni -->
<div id="editModal" class="fixed inset-0 z-50 bg-slate-900/60 backdrop-blur-sm hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl border border-slate-200 shadow-2xl max-w-2xl w-full max-h-[90vh] overflow-y-auto">
        <div class="p-5 border-b border-slate-100 flex items-center justify-between sticky top-0 bg-white z-10">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center font-bold text-base border border-amber-100">
                    <i class="fa-solid fa-pen-to-square"></i>
                </div>
                <div>
                    <h3 class="text-base font-bold text-slate-800">Edit Testimoni Guru</h3>
                    <p class="text-xs text-slate-500">Perbarui data atau foto testimoni</p>
                </div>
            </div>
            <button onclick="closeEditModal()" class="w-8 h-8 rounded-lg text-slate-400 hover:text-slate-600 hover:bg-slate-100 flex items-center justify-center transition">
                <i class="fa-solid fa-xmark text-lg"></i>
            </button>
        </div>

        <form id="editForm" method="POST" enctype="multipart/form-data" class="p-6 space-y-4">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Nama Guru & Gelar</label>
                    <input type="text" id="editName" name="name" required class="w-full bg-slate-50 border border-slate-300 rounded-xl px-4 py-2 text-sm focus:outline-none focus:border-red-500 focus:bg-white transition">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Posisi / Sekolah & Wilayah</label>
                    <input type="text" id="editRole" name="role_origin" required class="w-full bg-slate-50 border border-slate-300 rounded-xl px-4 py-2 text-sm focus:outline-none focus:border-red-500 focus:bg-white transition">
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Rating Bintang</label>
                    <select id="editRating" name="rating" required class="w-full bg-slate-50 border border-slate-300 rounded-xl px-3 py-2 text-sm focus:outline-none focus:border-red-500 focus:bg-white transition">
                        <option value="5">⭐⭐⭐⭐⭐ (5 Bintang)</option>
                        <option value="4">⭐⭐⭐⭐ (4 Bintang)</option>
                        <option value="3">⭐⭐⭐ (3 Bintang)</option>
                        <option value="2">⭐⭐ (2 Bintang)</option>
                        <option value="1">⭐ (1 Bintang)</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Nomor Urutan</label>
                    <input type="number" id="editOrder" name="order" class="w-full bg-slate-50 border border-slate-300 rounded-xl px-3 py-2 text-sm focus:outline-none focus:border-red-500 focus:bg-white transition">
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Isi Testimoni / Kutipan</label>
                <textarea id="editQuote" name="quote" rows="3" required class="w-full bg-slate-50 border border-slate-300 rounded-xl px-4 py-2 text-sm focus:outline-none focus:border-red-500 focus:bg-white transition"></textarea>
            </div>

            <!-- Foto Preview & Ganti Foto -->
            <div class="p-4 rounded-xl bg-slate-50 border border-slate-200 flex items-center gap-4">
                <img id="editPhotoPreview" src="" alt="Preview" class="w-14 h-14 rounded-full object-cover border-2 border-white shadow-sm flex-shrink-0">
                <div class="flex-1 space-y-2">
                    <div>
                        <label class="block text-[11px] font-bold text-slate-700 mb-0.5">Ganti Foto Guru (Upload File)</label>
                        <input type="file" name="photo_file" accept="image/*" class="w-full text-xs text-slate-500 file:mr-2 file:py-1 file:px-2.5 file:rounded-md file:border-0 file:text-[11px] file:font-semibold file:bg-red-700 file:text-white hover:file:bg-red-800 cursor-pointer">
                    </div>
                    <div>
                        <input type="text" id="editPhoto" name="photo_url" placeholder="Atau tautan URL foto (https://...)" class="w-full bg-white border border-slate-300 rounded-lg px-2.5 py-1 text-xs focus:outline-none focus:border-red-500">
                    </div>
                </div>
            </div>

            <div class="flex items-center justify-end gap-2 pt-4 border-t border-slate-100">
                <button type="button" onclick="closeEditModal()" class="px-4 py-2 rounded-xl text-slate-600 hover:bg-slate-100 text-sm font-semibold transition">Batal</button>
                <button type="submit" class="bg-red-700 hover:bg-red-800 text-white text-sm font-bold px-6 py-2 rounded-xl shadow-md transition flex items-center gap-2">
                    <i class="fa-solid fa-floppy-disk"></i>
                    <span>Simpan Perubahan</span>
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function openEditModal(testi) {
        const form = document.getElementById('editForm');
        form.action = `/admin/testimonials/${testi.id}`;
        
        document.getElementById('editName').value = testi.name || '';
        document.getElementById('editRole').value = testi.role_origin || '';
        document.getElementById('editRating').value = testi.rating || 5;
        document.getElementById('editOrder').value = testi.order || 1;
        document.getElementById('editQuote').value = testi.quote || '';
        document.getElementById('editPhoto').value = (testi.photo && testi.photo.startsWith('http')) ? testi.photo : '';
        document.getElementById('editPhotoPreview').src = testi.photo || 'https://images.unsplash.com/photo-1544005313-94ddf0286df2?auto=format&fit=crop&w=100&q=80';
        
        document.getElementById('editModal').classList.remove('hidden');
    }

    function closeEditModal() {
        document.getElementById('editModal').classList.add('hidden');
    }

    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeEditModal();
        }
    });
</script>
@endsection
