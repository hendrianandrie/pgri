@extends('admin.layout')

@section('title', 'Tambah Akun Pengguna')
@section('page_title', 'Tambah Akun Pengguna Baru')

@section('content')
<div class="max-w-3xl mx-auto space-y-6">

    <div class="flex items-center justify-between">
        <a href="{{ route('admin.users.index') }}" class="text-xs font-bold text-slate-600 hover:text-slate-900 bg-white border border-slate-200 px-3.5 py-2 rounded-xl transition inline-flex items-center gap-1.5 shadow-sm">
            <i class="fa-solid fa-arrow-left"></i>
            <span>Kembali ke Daftar Akun</span>
        </a>
    </div>

    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 md:p-8">
        <div class="border-b border-slate-100 pb-4 mb-6 flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-red-50 text-red-600 flex items-center justify-center font-bold text-lg border border-red-100">
                <i class="fa-solid fa-user-plus"></i>
            </div>
            <div>
                <h3 class="text-base font-bold text-slate-800">Formulir Tambah Akun Baru</h3>
                <p class="text-xs text-slate-500">Pilih peran akun (Admin, Pengurus, atau Guru) beserta kredensial masuk</p>
            </div>
        </div>

        <form action="{{ route('admin.users.store') }}" method="POST" class="space-y-6">
            @csrf

            <!-- Pilihan Peran / Role (Visual Cards) -->
            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2 flex items-center gap-1.5">
                    <i class="fa-solid fa-shield-halved text-red-600"></i>
                    <span>Pilih Peran Akun (Hak Akses)</span>
                    <span class="text-red-500">*</span>
                </label>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                    <!-- Admin -->
                    <label class="relative flex flex-col p-4 bg-slate-50 border-2 rounded-xl cursor-pointer hover:border-red-400 transition role-card has-[:checked]:border-red-600 has-[:checked]:bg-red-50/40">
                        <input type="radio" name="role" value="admin" class="sr-only" {{ old('role') === 'admin' ? 'checked' : '' }} required>
                        <div class="flex items-center gap-2 mb-1">
                            <i class="fa-solid fa-user-shield text-red-600 text-lg"></i>
                            <span class="font-bold text-slate-800 text-sm">Akun Admin</span>
                        </div>
                        <p class="text-[11px] text-slate-500 leading-relaxed">
                            Akses menyeluruh terhadap panel admin, kelola akun, berita, modul SAKTI, dan pengaturan sistem.
                        </p>
                    </label>

                    <!-- Pengurus -->
                    <label class="relative flex flex-col p-4 bg-slate-50 border-2 rounded-xl cursor-pointer hover:border-sky-400 transition role-card has-[:checked]:border-sky-600 has-[:checked]:bg-sky-50/40">
                        <input type="radio" name="role" value="pengurus" class="sr-only" {{ old('role') === 'pengurus' ? 'checked' : '' }} required>
                        <div class="flex items-center gap-2 mb-1">
                            <i class="fa-solid fa-user-tie text-sky-600 text-lg"></i>
                            <span class="font-bold text-slate-800 text-sm">Akun Pengurus</span>
                        </div>
                        <p class="text-[11px] text-slate-500 leading-relaxed">
                            Akses khusus jajaran pengurus untuk mempublikasikan laporan kegiatan, agenda organisasi, dan modul.
                        </p>
                    </label>

                    <!-- Guru -->
                    <label class="relative flex flex-col p-4 bg-slate-50 border-2 rounded-xl cursor-pointer hover:border-emerald-400 transition role-card has-[:checked]:border-emerald-600 has-[:checked]:bg-emerald-50/40">
                        <input type="radio" name="role" value="guru" class="sr-only" {{ old('role', 'guru') === 'guru' ? 'checked' : '' }} required>
                        <div class="flex items-center gap-2 mb-1">
                            <i class="fa-solid fa-chalkboard-user text-emerald-600 text-lg"></i>
                            <span class="font-bold text-slate-800 text-sm">Akun Guru</span>
                        </div>
                        <p class="text-[11px] text-slate-500 leading-relaxed">
                            Akses anggota guru untuk unduh modul perangkat ajar, materi Koding & AI, serta layanan anggota.
                        </p>
                    </label>
                </div>
            </div>

            <!-- Nama Lengkap & Email -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1 flex items-center gap-1.5">
                        <i class="fa-solid fa-user text-slate-500"></i>
                        <span>Nama Lengkap & Gelar</span>
                        <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="name" value="{{ old('name') }}" required 
                           placeholder="Contoh: Dra. Hj. Siti Aminah, M.Pd." 
                           class="w-full bg-slate-50 border border-slate-300 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-red-500 focus:bg-white transition">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1 flex items-center gap-1.5">
                        <i class="fa-solid fa-envelope text-slate-500"></i>
                        <span>Alamat Email (Login)</span>
                        <span class="text-red-500">*</span>
                    </label>
                    <input type="email" name="email" value="{{ old('email') }}" required 
                           placeholder="Contoh: sitiaminah@pgri.or.id" 
                           class="w-full bg-slate-50 border border-slate-300 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-red-500 focus:bg-white transition">
                </div>
            </div>

            <!-- Password -->
            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1 flex items-center gap-1.5">
                    <i class="fa-solid fa-lock text-slate-500"></i>
                    <span>Kata Sandi (Password)</span>
                    <span class="text-red-500">*</span>
                </label>
                <input type="password" name="password" required minlength="6" 
                       placeholder="Minimal 6 karakter..." 
                       class="w-full bg-slate-50 border border-slate-300 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-red-500 focus:bg-white transition">
                <p class="text-[11px] text-slate-400 mt-1">Gunakan kombinasi huruf dan angka yang aman untuk password akun ini.</p>
            </div>

            <!-- Asal Sekolah / Unit Kerja & No HP -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1 flex items-center gap-1.5">
                        <i class="fa-solid fa-school text-slate-500"></i>
                        <span>Asal Sekolah / Instansi / Unit Kerja</span>
                    </label>
                    <input type="text" name="school_origin" value="{{ old('school_origin') }}" 
                           placeholder="Contoh: SMP Negeri 1 Ciamis / PB PGRI" 
                           class="w-full bg-slate-50 border border-slate-300 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-red-500 focus:bg-white transition">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1 flex items-center gap-1.5">
                        <i class="fa-brands fa-whatsapp text-emerald-600"></i>
                        <span>No. Telepon / WhatsApp</span>
                    </label>
                    <input type="text" name="phone" value="{{ old('phone') }}" 
                           placeholder="Contoh: 0812-3456-7890" 
                           class="w-full bg-slate-50 border border-slate-300 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-red-500 focus:bg-white transition">
                </div>
            </div>

            <!-- Status Aktif -->
            <div class="flex items-center gap-2 pt-2">
                <input type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}
                       class="w-4 h-4 text-red-600 rounded border-slate-300 focus:ring-red-500">
                <label for="is_active" class="text-xs font-bold text-slate-700 cursor-pointer">
                    Aktifkan akun ini (dapat langsung masuk ke sistem)
                </label>
            </div>

            <!-- Submit Button -->
            <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-100">
                <a href="{{ route('admin.users.index') }}" class="px-5 py-2.5 rounded-xl text-slate-600 hover:bg-slate-100 text-sm font-semibold transition">
                    Batal
                </a>
                <button type="submit" class="bg-red-700 hover:bg-red-800 text-white text-sm font-bold px-6 py-2.5 rounded-xl shadow-md transition flex items-center gap-2">
                    <i class="fa-solid fa-floppy-disk"></i>
                    <span>Simpan Akun Baru</span>
                </button>
            </div>
        </form>
    </div>

</div>
@endsection
