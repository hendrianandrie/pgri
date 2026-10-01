@extends('admin.layout')

@section('title', 'Kelola Pengurus PGRI')
@section('page_title', 'Struktur Pengurus & Organisasi PGRI')

@section('content')
<div class="space-y-6">

    <!-- Add Form -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6">
        <h3 class="text-base font-bold text-slate-800 mb-4 flex items-center gap-2">
            <i class="fa-solid fa-user-plus text-red-600"></i>
            <span>Tambah Pengurus Baru</span>
        </h3>

        <form action="{{ route('admin.executives.store') }}" method="POST" enctype="multipart/form-data" class="grid grid-cols-1 md:grid-cols-3 gap-4">
            @csrf
            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">
                    Nama Lengkap & Gelar <span class="text-red-500">*</span>
                </label>
                <input type="text" name="name" required value="{{ old('name') }}" 
                       placeholder="Contoh: Prof. Dr. Unifah Rosyidi, M.Pd." 
                       class="w-full bg-slate-50 border border-slate-300 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-red-500 focus:bg-white transition">
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">
                    Jabatan dalam Organisasi <span class="text-red-500">*</span>
                </label>
                <input type="text" name="position" required value="{{ old('position') }}" 
                       placeholder="Contoh: Ketua Umum / Sekretaris Jenderal" 
                       class="w-full bg-slate-50 border border-slate-300 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-red-500 focus:bg-white transition">
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">
                    Bidang / Departemen
                </label>
                <input type="text" name="unit" value="{{ old('unit') }}" 
                       placeholder="Contoh: Pengurus Besar / Bidang Organisasi" 
                       class="w-full bg-slate-50 border border-slate-300 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-red-500 focus:bg-white transition">
            </div>

            <!-- Upload Foto Pengurus (File) -->
            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">
                    Upload Foto Pengurus (File)
                </label>
                <input type="file" name="photo_file" accept="image/*" 
                       class="w-full bg-slate-50 border border-slate-300 rounded-xl px-3 py-2 text-xs text-slate-600 file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-red-50 file:text-red-700 hover:file:bg-red-100 transition">
            </div>

            <!-- Atau URL Foto -->
            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">
                    Atau URL Foto (Opsional)
                </label>
                <input type="text" name="photo" value="{{ old('photo') }}" 
                       placeholder="https://images.unsplash.com/photo-..." 
                       class="w-full bg-slate-50 border border-slate-300 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-red-500 focus:bg-white transition">
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">
                    Urutan Tampilan
                </label>
                <input type="number" name="order" value="{{ old('order', $executives->count() + 1) }}" min="1" 
                       class="w-full bg-slate-50 border border-slate-300 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-red-500 focus:bg-white transition">
            </div>

            <div class="md:col-span-3">
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">
                    Biografi Singkat / Pengalaman (Opsional)
                </label>
                <textarea name="bio" rows="2" 
                          placeholder="Catatan pengalaman kerja, pengabdian, atau kutipan..." 
                          class="w-full bg-slate-50 border border-slate-300 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-red-500 focus:bg-white transition">{{ old('bio') }}</textarea>
            </div>

            <div class="md:col-span-3 flex justify-end">
                <button type="submit" class="bg-red-700 hover:bg-red-800 text-white text-sm font-bold px-6 py-2.5 rounded-xl shadow-md transition flex items-center gap-2">
                    <i class="fa-solid fa-floppy-disk"></i>
                    <span>Simpan Data Pengurus</span>
                </button>
            </div>
        </form>
    </div>

    <!-- Table List -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="p-5 border-b border-slate-100 flex items-center justify-between">
            <div>
                <h3 class="font-bold text-slate-800 text-base flex items-center gap-2">
                    <i class="fa-solid fa-users text-red-600"></i>
                    <span>Daftar Pengurus Terdaftar</span>
                </h3>
                <p class="text-xs text-slate-500">Struktur pengurus ditampilkan pada profil & beranda</p>
            </div>
            <span class="text-xs font-extrabold px-3 py-1 bg-red-50 text-red-700 rounded-full border border-red-200">
                Total: {{ $executives->count() }} Pengurus
            </span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-200 text-xs font-bold uppercase tracking-wider text-slate-500">
                        <th class="py-3.5 px-4 w-16 text-center">Urutan</th>
                        <th class="py-3.5 px-4">Foto & Nama Pengurus</th>
                        <th class="py-3.5 px-4">Jabatan</th>
                        <th class="py-3.5 px-4">Bidang / Unit</th>
                        <th class="py-3.5 px-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-sm">
                    @forelse($executives as $person)
                        <tr class="hover:bg-slate-50/80 transition">
                            <td class="py-3.5 px-4 font-extrabold text-slate-500 text-center">
                                #{{ $person->order }}
                            </td>
                            <td class="py-3.5 px-4">
                                <div class="flex items-center gap-3">
                                    <img src="{{ $person->photo ?? 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&w=150&q=80' }}" 
                                         alt="{{ $person->name }}" 
                                         class="w-12 h-12 rounded-full object-cover border-2 border-red-100 shadow-sm flex-shrink-0">
                                    <div>
                                        <div class="font-bold text-slate-800">{{ $person->name }}</div>
                                        <div class="text-xs text-slate-400 line-clamp-1">{{ $person->bio ?? '-' }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="py-3.5 px-4 font-semibold text-slate-700">
                                <span class="inline-block text-xs font-bold text-red-700 bg-red-50 px-2.5 py-1 rounded-lg border border-red-200">
                                    {{ $person->position }}
                                </span>
                            </td>
                            <td class="py-3.5 px-4 text-xs font-medium text-slate-600">
                                {{ $person->unit ?? 'Pengurus Besar' }}
                            </td>
                            <td class="py-3.5 px-4 text-right whitespace-nowrap">
                                <div class="inline-flex items-center gap-1.5">
                                    <!-- Edit Button (Opens Modal) -->
                                    <button type="button" 
                                            onclick='openEditModal(@json($person))'
                                            class="text-amber-600 hover:text-amber-800 text-xs font-bold p-1.5 bg-amber-50 hover:bg-amber-100 rounded-lg transition inline-flex items-center gap-1"
                                            title="Edit Pengurus">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                        <span>Edit</span>
                                    </button>

                                    <!-- Delete Button -->
                                    <form action="{{ route('admin.executives.destroy', $person->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin menghapus pengurus ini?')" class="inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-800 text-xs font-bold p-1.5 bg-red-50 hover:bg-red-100 rounded-lg transition inline-flex items-center gap-1"
                                                title="Hapus Pengurus">
                                            <i class="fa-solid fa-trash"></i>
                                            <span>Hapus</span>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-10 text-center text-slate-400 text-sm">
                                <i class="fa-solid fa-users text-3xl mb-2 text-slate-300 block"></i>
                                Belum ada data pengurus yang ditambahkan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>

<!-- EDIT MODAL -->
<div id="editModal" class="fixed inset-0 z-50 bg-slate-900/60 backdrop-blur-sm hidden flex items-center justify-center p-4 overflow-y-auto">
    <div class="bg-white rounded-2xl max-w-2xl w-full p-6 shadow-2xl border border-slate-200 relative my-8">
        <div class="flex items-center justify-between border-b border-slate-100 pb-3 mb-5">
            <h3 class="font-bold text-slate-800 text-base flex items-center gap-2">
                <i class="fa-solid fa-user-pen text-red-600"></i>
                <span>Edit Data Pengurus</span>
            </h3>
            <button type="button" onclick="closeEditModal()" class="text-slate-400 hover:text-slate-600 p-1 rounded-lg">
                <i class="fa-solid fa-xmark text-lg"></i>
            </button>
        </div>

        <form id="editForm" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="md:col-span-2">
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">
                        Nama Lengkap & Gelar <span class="text-red-500">*</span>
                    </label>
                    <input type="text" id="editName" name="name" required 
                           class="w-full bg-slate-50 border border-slate-300 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-red-500 focus:bg-white transition">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">
                        Jabatan <span class="text-red-500">*</span>
                    </label>
                    <input type="text" id="editPosition" name="position" required 
                           class="w-full bg-slate-50 border border-slate-300 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-red-500 focus:bg-white transition">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">
                        Bidang / Unit
                    </label>
                    <input type="text" id="editUnit" name="unit" 
                           class="w-full bg-slate-50 border border-slate-300 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-red-500 focus:bg-white transition">
                </div>

                <!-- Foto Saat Ini -->
                <div class="md:col-span-2 p-3 bg-slate-50 border border-slate-200 rounded-xl flex items-center gap-4">
                    <img id="editPhotoPreview" src="" alt="Foto Pengurus" class="w-14 h-14 rounded-full object-cover border-2 border-red-200 shadow-sm flex-shrink-0">
                    <div>
                        <span class="text-xs font-bold text-slate-700 block">Foto Pengurus Saat Ini</span>
                        <span class="text-[11px] text-slate-400">Unggah foto baru di bawah jika ingin mengganti</span>
                    </div>
                </div>

                <!-- Upload Foto Baru (File) -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">
                        Ganti Foto (Upload File Baru)
                    </label>
                    <input type="file" name="photo_file" accept="image/*" 
                           class="w-full bg-slate-50 border border-slate-300 rounded-xl px-3 py-2 text-xs text-slate-600 file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-red-50 file:text-red-700 hover:file:bg-red-100 transition">
                </div>

                <!-- Atau URL Foto Baru -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">
                        Atau URL Foto
                    </label>
                    <input type="text" id="editPhoto" name="photo" 
                           placeholder="https://..." 
                           class="w-full bg-slate-50 border border-slate-300 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-red-500 focus:bg-white transition">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">
                        Urutan Tampilan
                    </label>
                    <input type="number" id="editOrder" name="order" min="1" 
                           class="w-full bg-slate-50 border border-slate-300 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-red-500 focus:bg-white transition">
                </div>

                <div class="md:col-span-2">
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">
                        Biografi Singkat
                    </label>
                    <textarea id="editBio" name="bio" rows="2" 
                              class="w-full bg-slate-50 border border-slate-300 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-red-500 focus:bg-white transition"></textarea>
                </div>
            </div>

            <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-100">
                <button type="button" onclick="closeEditModal()" class="px-5 py-2.5 text-xs font-bold text-slate-600 hover:text-slate-800 bg-slate-100 hover:bg-slate-200 rounded-xl transition">
                    Batal
                </button>
                <button type="submit" class="bg-red-700 hover:bg-red-800 text-white text-sm font-bold px-6 py-2.5 rounded-xl shadow-md transition flex items-center gap-2">
                    <i class="fa-solid fa-floppy-disk"></i>
                    <span>Simpan Perubahan</span>
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function openEditModal(person) {
        const form = document.getElementById('editForm');
        form.action = `/admin/executives/${person.id}`;
        
        document.getElementById('editName').value = person.name || '';
        document.getElementById('editPosition').value = person.position || '';
        document.getElementById('editUnit').value = person.unit || '';
        document.getElementById('editOrder').value = person.order || 1;
        document.getElementById('editBio').value = person.bio || '';
        document.getElementById('editPhoto').value = person.photo || '';
        document.getElementById('editPhotoPreview').src = person.photo || 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&w=150&q=80';
        
        document.getElementById('editModal').classList.remove('hidden');
    }

    function closeEditModal() {
        document.getElementById('editModal').classList.add('hidden');
    }

    // Close on escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeEditModal();
        }
    });
</script>
@endsection
