@extends('admin.layout')

@section('title', 'Pengaturan Kontak & Sekretariat')
@section('page_title', 'Pengaturan Kontak & Kantor Sekretariat')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">

    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 md:p-8">
        <div class="border-b border-slate-100 pb-4 mb-6 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="w-11 h-11 rounded-xl bg-red-50 text-red-600 flex items-center justify-center font-bold text-xl border border-red-100">
                    <i class="fa-solid fa-building"></i>
                </div>
                <div>
                    <h2 class="text-lg font-bold text-slate-800">Informasi Kantor Sekretariat</h2>
                    <p class="text-xs text-slate-500">Kelola alamat, kontak resmi, WhatsApp, dan jam layanan yang tampil pada halaman website</p>
                </div>
            </div>
            <a href="{{ route('contact.index') }}" target="_blank" class="text-xs font-bold text-red-700 hover:text-red-800 bg-red-50 hover:bg-red-100 px-3 py-1.5 rounded-lg border border-red-200 transition inline-flex items-center gap-1.5">
                <i class="fa-solid fa-arrow-up-right-from-square"></i>
                <span>Lihat Halaman Kontak</span>
            </a>
        </div>

        <form action="{{ route('admin.contact-settings.update') }}" method="POST" class="space-y-5">
            @csrf

            <!-- Alamat Kantor -->
            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1 flex items-center gap-1.5">
                    <i class="fa-solid fa-location-dot text-red-600"></i>
                    <span>Alamat Kantor Sekretariat</span>
                    <span class="text-red-500">*</span>
                </label>
                <textarea name="address" rows="3" required 
                          placeholder="Masukkan alamat lengkap kantor sekretariat..." 
                          class="w-full bg-slate-50 border border-slate-300 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-red-500 focus:bg-white transition">{{ old('address', $office['address']) }}</textarea>
                <p class="text-[11px] text-slate-400 mt-1">Alamat ini tampil pada kartu Kantor Sekretariat dan footer situs web.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <!-- Telepon Sekretariat -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1 flex items-center gap-1.5">
                        <i class="fa-solid fa-phone text-amber-500"></i>
                        <span>Telepon Sekretariat</span>
                        <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="phone" required value="{{ old('phone', $office['phone']) }}" 
                           placeholder="Contoh: (021) 3844932 / 3846665" 
                           class="w-full bg-slate-50 border border-slate-300 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-red-500 focus:bg-white transition">
                </div>

                <!-- Email Resmi -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1 flex items-center gap-1.5">
                        <i class="fa-solid fa-envelope text-sky-500"></i>
                        <span>Email Resmi Organisasi</span>
                        <span class="text-red-500">*</span>
                    </label>
                    <input type="email" name="email" required value="{{ old('email', $office['email']) }}" 
                           placeholder="Contoh: sekretariat@pgri.or.id" 
                           class="w-full bg-slate-50 border border-slate-300 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-red-500 focus:bg-white transition">
                </div>

                <!-- WhatsApp Center -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1 flex items-center gap-1.5">
                        <i class="fa-brands fa-whatsapp text-emerald-600"></i>
                        <span>WhatsApp Center</span>
                        <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="whatsapp" required value="{{ old('whatsapp', $office['whatsapp']) }}" 
                           placeholder="Contoh: 0812-3456-7890" 
                           class="w-full bg-slate-50 border border-slate-300 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-red-500 focus:bg-white transition">
                </div>

                <!-- Jam Operasional -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1 flex items-center gap-1.5">
                        <i class="fa-solid fa-clock text-blue-600"></i>
                        <span>Jam Operasional Sekretariat</span>
                        <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="hours" required value="{{ old('hours', $office['hours']) }}" 
                           placeholder="Contoh: Senin - Jumat: 08:00 - 16:00 WIB" 
                           class="w-full bg-slate-50 border border-slate-300 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-red-500 focus:bg-white transition">
                </div>
            </div>

            <!-- Submit Button -->
            <div class="flex items-center justify-end pt-4 border-t border-slate-100">
                <button type="submit" class="bg-red-700 hover:bg-red-800 text-white text-sm font-bold px-6 py-2.5 rounded-xl shadow-md transition flex items-center gap-2">
                    <i class="fa-solid fa-floppy-disk"></i>
                    <span>Simpan Perubahan Kontak</span>
                </button>
            </div>
        </form>
    </div>

</div>
@endsection
