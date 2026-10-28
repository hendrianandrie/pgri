@extends('admin.layout')

@section('title', 'Tinjau Kiriman Kontributor')
@section('page_title', 'Tinjau & Kurasi Naskah Kontributor')

@section('content')
<div class="space-y-6">

    <!-- Top Navigation & Action Strip -->
    <div class="flex flex-wrap items-center justify-between gap-4">
        <a href="{{ route('admin.submissions.index') }}" class="inline-flex items-center gap-2 text-xs font-bold text-slate-600 hover:text-red-600 transition">
            <i class="fa-solid fa-arrow-left"></i>
            <span>Kembali ke Daftar Kiriman</span>
        </a>

        <div class="flex items-center gap-2">
            @if($submission->status === 'approved')
                @if($submission->publishedNews)
                    <a href="{{ route('news.show', $submission->publishedNews->slug) }}" target="_blank" class="px-4 py-2 rounded-xl text-xs font-bold bg-emerald-600 text-white hover:bg-emerald-700 transition flex items-center gap-1.5 shadow-sm">
                        <i class="fa-solid fa-arrow-up-right-from-square"></i>
                        <span>Lihat Berita Live</span>
                    </a>
                @elseif($submission->publishedSakti)
                    <a href="{{ route('sakti.show', $submission->publishedSakti->slug) }}" target="_blank" class="px-4 py-2 rounded-xl text-xs font-bold bg-purple-600 text-white hover:bg-purple-700 transition flex items-center gap-1.5 shadow-sm">
                        <i class="fa-solid fa-arrow-up-right-from-square"></i>
                        <span>Lihat Modul Live</span>
                    </a>
                @endif
            @endif

            <form action="{{ route('admin.submissions.destroy', $submission->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus kiriman ini?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="px-3.5 py-2 rounded-xl text-xs font-bold bg-red-50 text-red-600 hover:bg-red-100 transition flex items-center gap-1.5">
                    <i class="fa-solid fa-trash"></i>
                    <span>Hapus</span>
                </button>
            </form>
        </div>
    </div>

    @if(session('success'))
        <div class="p-4 bg-emerald-50 border border-emerald-200 rounded-2xl text-emerald-800 text-sm flex items-center gap-2">
            <i class="fa-solid fa-circle-check text-emerald-600 fs-5 flex-shrink-0"></i>
            <div>{!! session('success') !!}</div>
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        <!-- LEFT COLUMN: Content Preview (2 Cols) -->
        <div class="lg:col-span-2 space-y-6">
            
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 space-y-5">
                
                <!-- Category, Status, & Event Date -->
                <div class="flex flex-wrap items-center justify-between gap-3 pb-4 border-b border-slate-100">
                    <div class="flex items-center gap-2">
                        @if($submission->type === 'news')
                            <span class="px-3 py-1 rounded-full text-xs font-bold bg-rose-100 text-rose-700 flex items-center gap-1.5">
                                <i class="fa-solid fa-newspaper text-xs"></i> Berita Kegiatan
                            </span>
                            @if($submission->event_date)
                                <span class="text-xs text-slate-500 font-medium">
                                    <i class="fa-regular fa-calendar me-1"></i> Pelaksanaan: {{ $submission->event_date->translatedFormat('d F Y') }}
                                </span>
                            @endif
                        @else
                            <span class="px-3 py-1 rounded-full text-xs font-bold bg-purple-100 text-purple-800 flex items-center gap-1.5">
                                <i class="fa-solid fa-wand-magic-sparkles text-xs"></i> SAKTI: {{ $submission->category_label }}
                            </span>
                            @if($submission->badge)
                                <span class="px-2.5 py-0.5 rounded text-xs font-bold bg-slate-100 text-slate-700">
                                    Jenjang {{ $submission->badge }}
                                </span>
                            @endif
                        @endif
                    </div>

                    <div>
                        @if($submission->status === 'approved')
                            <span class="px-3 py-1 rounded-full text-xs font-bold bg-emerald-100 text-emerald-800 flex items-center gap-1">
                                <i class="fa-solid fa-circle-check text-emerald-600"></i> Diterbitkan
                            </span>
                        @elseif($submission->status === 'rejected')
                            <span class="px-3 py-1 rounded-full text-xs font-bold bg-red-100 text-red-800 flex items-center gap-1">
                                <i class="fa-solid fa-circle-xmark text-red-600"></i> Ditolak
                            </span>
                        @else
                            <span class="px-3 py-1 rounded-full text-xs font-bold bg-amber-100 text-amber-800 flex items-center gap-1 animate-pulse">
                                <i class="fa-solid fa-clock text-amber-600"></i> Menunggu Kurasi
                            </span>
                        @endif
                    </div>
                </div>

                <!-- Title -->
                <h2 class="text-xl md:text-2xl font-black text-slate-900 leading-snug">
                    {{ $submission->title }}
                </h2>

                <!-- Image Banner if present -->
                @if($submission->image)
                    <div class="rounded-xl overflow-hidden border border-slate-200 bg-slate-100 max-h-96">
                        <img src="{{ $submission->image }}" alt="Dokumentasi" class="w-full h-full object-cover">
                    </div>
                @endif

                <!-- Summary Quote -->
                @if($submission->summary)
                    <div class="p-4 bg-slate-50 border-l-4 border-red-500 rounded-r-xl text-slate-700 text-sm leading-relaxed">
                        <strong class="text-slate-900 block mb-1 text-xs uppercase tracking-wider font-bold">Ringkasan / Abstrak:</strong>
                        {{ $submission->summary }}
                    </div>
                @endif

                <!-- Full Content Article -->
                <div class="space-y-4 pt-2">
                    <strong class="text-slate-900 block text-xs uppercase tracking-wider font-bold border-b border-slate-100 pb-2">Naskah Lengkap:</strong>
                    <div class="prose max-w-none text-slate-800 text-sm leading-relaxed whitespace-pre-line bg-slate-50/50 p-5 rounded-xl border border-slate-100">
                        {{ $submission->content }}
                    </div>
                </div>

                <!-- File link if present -->
                @if($submission->file_url)
                    <div class="p-4 bg-purple-50 border border-purple-200 rounded-xl flex items-center justify-between gap-3">
                        <div class="flex items-center gap-3">
                            <i class="fa-solid fa-cloud-arrow-down text-purple-600 text-2xl"></i>
                            <div>
                                <h5 class="text-xs font-bold text-slate-900 mb-0">Tautan Berkas Modul / Dokumen Eksternal</h5>
                                <a href="{{ $submission->file_url }}" target="_blank" class="text-xs text-purple-700 font-medium hover:underline truncate block max-w-xs md:max-w-md">
                                    {{ $submission->file_url }}
                                </a>
                            </div>
                        </div>
                        <a href="{{ $submission->file_url }}" target="_blank" class="px-3.5 py-1.5 rounded-lg text-xs font-bold bg-purple-600 text-white hover:bg-purple-700 transition flex-shrink-0">
                            Buka Link
                        </a>
                    </div>
                @endif

            </div>

        </div>

        <!-- RIGHT COLUMN: Contributor Details & Editorial Approval Actions (1 Col) -->
        <div class="space-y-6">

            <!-- Contributor Card -->
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-5 space-y-4">
                <h4 class="font-bold text-slate-900 text-sm border-b border-slate-100 pb-3 flex items-center gap-2">
                    <i class="fa-solid fa-id-card text-red-600"></i>
                    <span>Identitas Kontributor</span>
                </h4>

                <div class="space-y-3 text-xs">
                    <div>
                        <span class="text-slate-400 block font-medium">Nama Kontributor:</span>
                        <span class="font-bold text-slate-900 text-sm">{{ $submission->author_name }}</span>
                    </div>

                    @if($submission->school_origin)
                        <div>
                            <span class="text-slate-400 block font-medium">Asal Sekolah / Cabang:</span>
                            <span class="font-semibold text-slate-800">{{ $submission->school_origin }}</span>
                        </div>
                    @endif

                    <div>
                        <span class="text-slate-400 block font-medium">Email:</span>
                        <a href="mailto:{{ $submission->author_email }}" class="text-slate-700 hover:text-red-600 font-semibold">{{ $submission->author_email }}</a>
                    </div>

                    @if($submission->author_phone)
                        <div>
                            <span class="text-slate-400 block font-medium mb-1">WhatsApp / Telepon:</span>
                            <a href="{{ $submission->whatsapp_url }}" target="_blank" class="inline-flex items-center gap-2 px-3 py-1.5 rounded-xl bg-emerald-50 text-emerald-700 font-bold hover:bg-emerald-100 transition border border-emerald-200">
                                <i class="fa-brands fa-whatsapp text-emerald-600 text-base"></i>
                                <span>Hubungi via WhatsApp ({{ $submission->author_phone }})</span>
                            </a>
                        </div>
                    @endif

                    <div class="pt-2 border-t border-slate-100 text-[11px] text-slate-400 space-y-0.5">
                        <p>Dikirim pada: {{ $submission->created_at ? $submission->created_at->translatedFormat('d F Y - H:i') : '-' }} WIB</p>
                        @if($submission->ip_address)
                            <p class="font-mono">IP Address: {{ $submission->ip_address }}</p>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Approval / Publish Box -->
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-5 space-y-4">
                <h4 class="font-bold text-slate-900 text-sm border-b border-slate-100 pb-3 flex items-center gap-2">
                    <i class="fa-solid fa-stamp text-emerald-600"></i>
                    <span>Tindakan Redaksi PGRI</span>
                </h4>

                @if($submission->status !== 'approved')
                    <form action="{{ route('admin.submissions.approve', $submission->id) }}" method="POST" class="space-y-3">
                        @csrf
                        <div class="p-3 bg-emerald-50/60 border border-emerald-200 rounded-xl text-xs text-emerald-900 leading-relaxed">
                            <i class="fa-solid fa-circle-info text-emerald-600 me-1"></i>
                            Menyetujui naskah ini akan langsung membuat dan menerbitkan data resmi di portal <strong>{{ $submission->type_label }}</strong> PGRI dengan mencantumkan nama guru.
                        </div>

                        <!-- Editable Fields for Admin Adjustment -->
                        <div>
                            <label class="block text-[11px] font-bold text-slate-600 mb-1">Penyesuaian Judul (Jika Perlu):</label>
                            <input type="text" name="title" value="{{ $submission->title }}" class="w-full text-xs p-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-emerald-500">
                        </div>

                        <div>
                            <label class="block text-[11px] font-bold text-slate-600 mb-1">Nama Penulis & Asal:</label>
                            <input type="text" name="author_name" value="{{ $submission->author_name }}" class="w-full text-xs p-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-emerald-500 mb-1">
                            <input type="text" name="school_origin" value="{{ $submission->school_origin }}" placeholder="Asal Sekolah / Ranting" class="w-full text-xs p-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-emerald-500">
                        </div>

                        @if($submission->type === 'sakti')
                            <div>
                                <label class="block text-[11px] font-bold text-slate-600 mb-1">Pilar Modul SAKTI:</label>
                                <select name="sakti_category" class="w-full text-xs p-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-emerald-500">
                                    <option value="pembelajaran_mendalam" {{ $submission->sakti_category === 'pembelajaran_mendalam' ? 'selected' : '' }}>Pembelajaran Mendalam</option>
                                    <option value="rumah_pendidikan" {{ $submission->sakti_category === 'rumah_pendidikan' ? 'selected' : '' }}>Rumah Pendidikan</option>
                                    <option value="pid" {{ $submission->sakti_category === 'pid' ? 'selected' : '' }}>Papan Interaktif Digital (PID)</option>
                                    <option value="koding_kka" {{ $submission->sakti_category === 'koding_kka' ? 'selected' : '' }}>Koding & AI (KKA)</option>
                                </select>
                            </div>
                        @endif

                        <button type="submit" class="w-full py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs shadow-sm transition flex items-center justify-center gap-2">
                            <i class="fa-solid fa-check-double"></i>
                            <span>Setujui & Terbitkan Sekarang</span>
                        </button>
                    </form>

                    <!-- Reject Form -->
                    <div class="pt-3 border-t border-slate-100">
                        <form action="{{ route('admin.submissions.reject', $submission->id) }}" method="POST" class="space-y-2">
                            @csrf
                            <label class="block text-[11px] font-bold text-slate-600">Alasan Penolakan / Catatan:</label>
                            <textarea name="admin_notes" rows="2" required placeholder="Tuliskan alasan penolakan naskah..." class="w-full text-xs p-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-red-500">{{ $submission->admin_notes }}</textarea>
                            <button type="submit" class="w-full py-2 rounded-xl bg-red-50 hover:bg-red-100 text-red-600 font-bold text-xs transition flex items-center justify-center gap-1.5">
                                <i class="fa-solid fa-ban"></i>
                                <span>Tolak Naskah Ini</span>
                            </button>
                        </form>
                    </div>
                @else
                    <div class="p-4 bg-emerald-50 text-emerald-800 rounded-xl text-xs space-y-2">
                        <div class="flex items-center gap-2 font-bold text-sm">
                            <i class="fa-solid fa-circle-check text-emerald-600"></i>
                            <span>Naskah Ini Telah Terbit</span>
                        </div>
                        <p class="leading-relaxed">Konten ini telah sukses diverifikasi dan ditayangkan secara resmi pada website PGRI.</p>
                        @if($submission->admin_notes)
                            <div class="pt-1 text-[11px] text-emerald-700">Catatan: {{ $submission->admin_notes }}</div>
                        @endif
                    </div>
                @endif

            </div>

        </div>

    </div>

</div>
@endsection
