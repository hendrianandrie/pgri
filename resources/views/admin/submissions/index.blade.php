@extends('admin.layout')

@section('title', 'Kiriman Kontributor Guru & Publik')
@section('page_title', 'Kurasi Kiriman Berita & Modul Guru')

@section('content')
<div class="space-y-6">

    <!-- Top Summary & Filter Bar -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-5 space-y-4">
        
        <!-- Status & Search Row -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <!-- Status Tabs -->
            <div class="flex items-center gap-2 overflow-x-auto pb-1 md:pb-0">
                <a href="{{ route('admin.submissions.index', ['status' => 'all', 'type' => $type, 'q' => $search]) }}"
                   class="px-3.5 py-2 rounded-xl text-xs font-bold transition flex items-center gap-2 whitespace-nowrap {{ $status === 'all' ? 'bg-slate-900 text-white shadow-sm' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                    <span>Semua Status</span>
                    <span class="px-2 py-0.5 rounded-full text-[10px] {{ $status === 'all' ? 'bg-white/20 text-white' : 'bg-white text-slate-700' }}">{{ $counts['all'] }}</span>
                </a>

                <a href="{{ route('admin.submissions.index', ['status' => 'pending', 'type' => $type, 'q' => $search]) }}"
                   class="px-3.5 py-2 rounded-xl text-xs font-bold transition flex items-center gap-2 whitespace-nowrap {{ $status === 'pending' ? 'bg-amber-500 text-white shadow-sm' : 'bg-amber-50 text-amber-700 hover:bg-amber-100' }}">
                    <i class="fa-solid fa-clock-rotate-left"></i>
                    <span>Menunggu Kurasi</span>
                    <span class="px-2 py-0.5 rounded-full text-[10px] {{ $status === 'pending' ? 'bg-white/20 text-white' : 'bg-amber-200 text-amber-900' }}">{{ $counts['pending'] }}</span>
                </a>

                <a href="{{ route('admin.submissions.index', ['status' => 'approved', 'type' => $type, 'q' => $search]) }}"
                   class="px-3.5 py-2 rounded-xl text-xs font-bold transition flex items-center gap-2 whitespace-nowrap {{ $status === 'approved' ? 'bg-emerald-600 text-white shadow-sm' : 'bg-emerald-50 text-emerald-700 hover:bg-emerald-100' }}">
                    <i class="fa-solid fa-circle-check"></i>
                    <span>Telah Diterbitkan</span>
                    <span class="px-2 py-0.5 rounded-full text-[10px] {{ $status === 'approved' ? 'bg-white/20 text-white' : 'bg-emerald-200 text-emerald-900' }}">{{ $counts['approved'] }}</span>
                </a>

                <a href="{{ route('admin.submissions.index', ['status' => 'rejected', 'type' => $type, 'q' => $search]) }}"
                   class="px-3.5 py-2 rounded-xl text-xs font-bold transition flex items-center gap-2 whitespace-nowrap {{ $status === 'rejected' ? 'bg-red-600 text-white shadow-sm' : 'bg-red-50 text-red-700 hover:bg-red-100' }}">
                    <i class="fa-solid fa-circle-xmark"></i>
                    <span>Ditolak</span>
                    <span class="px-2 py-0.5 rounded-full text-[10px] {{ $status === 'rejected' ? 'bg-white/20 text-white' : 'bg-red-200 text-red-900' }}">{{ $counts['rejected'] }}</span>
                </a>
            </div>

            <!-- Search Form -->
            <form action="{{ route('admin.submissions.index') }}" method="GET" class="flex items-center gap-2">
                <input type="hidden" name="status" value="{{ $status }}">
                <input type="hidden" name="type" value="{{ $type }}">
                <div class="relative w-full md:w-64">
                    <i class="fa-solid fa-magnifying-glass absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-xs"></i>
                    <input type="text" name="q" value="{{ $search }}" placeholder="Cari judul, penulis, sekolah..."
                           class="w-full pl-8 pr-3 py-2 text-xs rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500">
                </div>
                @if($search)
                    <a href="{{ route('admin.submissions.index', ['status' => $status, 'type' => $type]) }}" class="px-3 py-2 rounded-xl bg-slate-100 text-slate-600 hover:bg-slate-200 text-xs font-semibold" title="Reset pencarian">
                        <i class="fa-solid fa-xmark"></i>
                    </a>
                @endif
                <button type="submit" class="px-4 py-2 rounded-xl bg-red-600 text-white text-xs font-bold hover:bg-red-700 transition">
                    Cari
                </button>
            </form>
        </div>

        <!-- Type Filter Tabs -->
        <div class="pt-3 border-t border-slate-100 flex items-center gap-2 text-xs">
            <span class="text-slate-400 font-medium me-1">Kategori:</span>
            
            <a href="{{ route('admin.submissions.index', ['status' => $status, 'type' => 'all', 'q' => $search]) }}"
               class="px-3 py-1 rounded-lg font-bold transition flex items-center gap-1.5 {{ $type === 'all' ? 'bg-slate-800 text-white' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                <span>Semua Kategori</span>
                <span class="text-[10px] opacity-80">({{ $counts['all'] }})</span>
            </a>

            <a href="{{ route('admin.submissions.index', ['status' => $status, 'type' => 'news', 'q' => $search]) }}"
               class="px-3 py-1 rounded-lg font-bold transition flex items-center gap-1.5 {{ $type === 'news' ? 'bg-rose-600 text-white' : 'bg-rose-50 text-rose-700 hover:bg-rose-100' }}">
                <i class="fa-solid fa-newspaper text-xs"></i>
                <span>Berita Kegiatan</span>
                <span class="text-[10px] opacity-80">({{ $counts['news'] }})</span>
            </a>

            <a href="{{ route('admin.submissions.index', ['status' => $status, 'type' => 'sakti', 'q' => $search]) }}"
               class="px-3 py-1 rounded-lg font-bold transition flex items-center gap-1.5 {{ $type === 'sakti' ? 'bg-purple-600 text-white' : 'bg-purple-50 text-purple-700 hover:bg-purple-100' }}">
                <i class="fa-solid fa-wand-magic-sparkles text-xs"></i>
                <span>Modul SAKTI</span>
                <span class="text-[10px] opacity-80">({{ $counts['sakti'] }})</span>
            </a>
        </div>

    </div>

    <!-- Submissions List -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="p-5 border-b border-slate-100 flex items-center justify-between">
            <div>
                <h3 class="font-bold text-slate-800 text-base">Daftar Kiriman Guru & Publik</h3>
                <p class="text-xs text-slate-500">Tinjau naskah yang dikirim sebelum diterbitkan resmi ke portal berita atau modul SAKTI</p>
            </div>
            <span class="text-xs font-bold text-slate-500 bg-slate-100 px-3 py-1 rounded-full">
                Menampilkan {{ $submissions->count() }} dari {{ $submissions->total() }} Kiriman
            </span>
        </div>

        <div class="divide-y divide-slate-100">
            @forelse($submissions as $item)
                <div class="p-5 hover:bg-slate-50/70 transition space-y-3 {{ $item->status === 'pending' ? 'bg-amber-50/30' : '' }}">
                    
                    <div class="flex flex-col md:flex-row md:items-start justify-between gap-4">
                        
                        <!-- Left Info -->
                        <div class="flex-1 space-y-2">
                            <!-- Category and Status badges -->
                            <div class="flex flex-wrap items-center gap-2">
                                @if($item->type === 'news')
                                    <span class="px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-rose-100 text-rose-700 inline-flex items-center gap-1">
                                        <i class="fa-solid fa-newspaper text-[10px]"></i> Berita Kegiatan
                                    </span>
                                @else
                                    <span class="px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-purple-100 text-purple-800 inline-flex items-center gap-1">
                                        <i class="fa-solid fa-wand-magic-sparkles text-[10px]"></i> SAKTI: {{ $item->category_label }}
                                    </span>
                                    @if($item->badge)
                                        <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-slate-100 text-slate-700">
                                            Jenjang {{ $item->badge }}
                                        </span>
                                    @endif
                                @endif

                                @if($item->status === 'approved')
                                    <span class="px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-emerald-100 text-emerald-800 inline-flex items-center gap-1">
                                        <i class="fa-solid fa-circle-check text-emerald-600"></i> Diterbitkan
                                    </span>
                                @elseif($item->status === 'rejected')
                                    <span class="px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-red-100 text-red-800 inline-flex items-center gap-1">
                                        <i class="fa-solid fa-circle-xmark text-red-600"></i> Ditolak
                                    </span>
                                @else
                                    <span class="px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-amber-100 text-amber-800 inline-flex items-center gap-1 animate-pulse">
                                        <i class="fa-solid fa-clock text-amber-600"></i> Menunggu Kurasi
                                    </span>
                                @endif
                            </div>

                            <!-- Title -->
                            <h4 class="font-bold text-slate-900 text-base leading-snug">
                                <a href="{{ route('admin.submissions.show', $item->id) }}" class="hover:text-red-600 hover:underline">
                                    {{ $item->title }}
                                </a>
                            </h4>

                            <!-- Summary preview -->
                            <p class="text-xs text-slate-600 leading-relaxed line-clamp-2">
                                {{ $item->summary }}
                            </p>

                            <!-- Author info strip -->
                            <div class="flex flex-wrap items-center gap-x-4 gap-y-1 text-xs text-slate-500 pt-1">
                                <span class="font-bold text-slate-800 flex items-center gap-1.5">
                                    <i class="fa-solid fa-user-pen text-slate-400"></i>
                                    {{ $item->author_name }}
                                </span>
                                @if($item->school_origin)
                                    <span class="flex items-center gap-1 text-slate-600">
                                        <i class="fa-solid fa-school text-slate-400"></i>
                                        {{ $item->school_origin }}
                                    </span>
                                @endif
                                <span class="flex items-center gap-1">
                                    <i class="fa-solid fa-envelope text-slate-400"></i>
                                    {{ $item->author_email }}
                                </span>
                                @if($item->author_phone)
                                    <a href="{{ $item->whatsapp_url }}" target="_blank" class="flex items-center gap-1 text-emerald-700 font-bold hover:underline" title="Chat WhatsApp kontributor">
                                        <i class="fa-brands fa-whatsapp text-emerald-500 text-sm"></i>
                                        {{ $item->author_phone }}
                                    </a>
                                @endif
                                <span class="flex items-center gap-1 text-slate-400">
                                    <i class="fa-regular fa-clock"></i>
                                    {{ $item->created_at ? $item->created_at->translatedFormat('d M Y, H:i') : '-' }} WIB
                                </span>
                            </div>

                            <!-- Target live link if published -->
                            @if($item->status === 'approved')
                                <div class="pt-1">
                                    @if($item->publishedNews)
                                        <a href="{{ route('news.show', $item->publishedNews->slug) }}" target="_blank" class="inline-flex items-center gap-1 text-xs font-bold text-emerald-600 hover:underline">
                                            <i class="fa-solid fa-arrow-up-right-from-square"></i>
                                            <span>Buka Tayangan Berita Resmi</span>
                                        </a>
                                    @elseif($item->publishedSakti)
                                        <a href="{{ route('sakti.show', $item->publishedSakti->slug) }}" target="_blank" class="inline-flex items-center gap-1 text-xs font-bold text-purple-600 hover:underline">
                                            <i class="fa-solid fa-arrow-up-right-from-square"></i>
                                            <span>Buka Modul SAKTI Resmi</span>
                                        </a>
                                    @endif
                                </div>
                            @endif

                            @if($item->status === 'rejected' && $item->admin_notes)
                                <div class="p-2.5 bg-red-50 text-red-700 text-xs rounded-lg border border-red-100">
                                    <strong>Catatan Penolakan:</strong> {{ $item->admin_notes }}
                                </div>
                            @endif
                        </div>

                        <!-- Right Actions & Thumbnail -->
                        <div class="flex flex-row md:flex-col items-center md:items-end justify-between gap-3 flex-shrink-0">
                            @if($item->image)
                                <img src="{{ $item->image }}" alt="Thumbnail" class="w-20 h-16 rounded-xl object-cover border border-slate-200">
                            @endif

                            <div class="flex items-center gap-2">
                                <a href="{{ route('admin.submissions.show', $item->id) }}" class="px-3.5 py-1.5 rounded-lg text-xs font-bold bg-slate-900 text-white hover:bg-slate-800 transition flex items-center gap-1.5 shadow-sm">
                                    <i class="fa-solid fa-magnifying-glass-arrow-right"></i>
                                    <span>Tinjau Naskah</span>
                                </a>

                                <form action="{{ route('admin.submissions.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus kiriman ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-1.5 rounded-lg text-xs font-bold text-red-500 hover:bg-red-50 hover:text-red-700 transition" title="Hapus kiriman">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </div>

                    </div>

                </div>
            @empty
                <div class="py-16 text-center space-y-3">
                    <div class="w-12 h-12 bg-slate-100 rounded-full flex items-center justify-center mx-auto text-slate-400 text-lg">
                        <i class="fa-solid fa-inbox"></i>
                    </div>
                    <div class="text-slate-500 font-semibold text-sm">Belum ada kiriman dari publik.</div>
                    <p class="text-xs text-slate-400">Guru dan masyarakat dapat mengirimkan naskah melalui formulir publik website.</p>
                </div>
            @endforelse
        </div>

        @if($submissions->hasPages())
            <div class="p-4 border-t border-slate-100 bg-slate-50/50">
                {{ $submissions->links() }}
            </div>
        @endif
    </div>

</div>
@endsection
