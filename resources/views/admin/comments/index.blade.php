@extends('admin.layout')

@section('title', 'Moderasi Komentar & Diskusi')
@section('page_title', 'Moderasi Komentar (Berita & Modul SAKTI)')

@section('content')
<div class="space-y-6">

    <!-- Top Summary & Filter Bar -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-5 space-y-4">
        
        <!-- Status & Search Row -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <!-- Status Tabs -->
            <div class="flex items-center gap-2 overflow-x-auto pb-1 md:pb-0">
                <a href="{{ route('admin.comments.index', ['status' => 'all', 'source' => $source, 'q' => $search]) }}"
                   class="px-3.5 py-2 rounded-xl text-xs font-bold transition flex items-center gap-2 whitespace-nowrap {{ $status === 'all' ? 'bg-slate-900 text-white shadow-sm' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                    <span>Semua Status</span>
                    <span class="px-2 py-0.5 rounded-full text-[10px] {{ $status === 'all' ? 'bg-white/20 text-white' : 'bg-white text-slate-700' }}">{{ $counts['all'] }}</span>
                </a>

                <a href="{{ route('admin.comments.index', ['status' => 'pending', 'source' => $source, 'q' => $search]) }}"
                   class="px-3.5 py-2 rounded-xl text-xs font-bold transition flex items-center gap-2 whitespace-nowrap {{ $status === 'pending' ? 'bg-amber-500 text-white shadow-sm' : 'bg-amber-50 text-amber-700 hover:bg-amber-100' }}">
                    <i class="fa-solid fa-clock-rotate-left"></i>
                    <span>Menunggu Persetujuan</span>
                    <span class="px-2 py-0.5 rounded-full text-[10px] {{ $status === 'pending' ? 'bg-white/20 text-white' : 'bg-amber-200 text-amber-900' }}">{{ $counts['pending'] }}</span>
                </a>

                <a href="{{ route('admin.comments.index', ['status' => 'approved', 'source' => $source, 'q' => $search]) }}"
                   class="px-3.5 py-2 rounded-xl text-xs font-bold transition flex items-center gap-2 whitespace-nowrap {{ $status === 'approved' ? 'bg-emerald-600 text-white shadow-sm' : 'bg-emerald-50 text-emerald-700 hover:bg-emerald-100' }}">
                    <i class="fa-solid fa-circle-check"></i>
                    <span>Disetujui / Tayang</span>
                    <span class="px-2 py-0.5 rounded-full text-[10px] {{ $status === 'approved' ? 'bg-white/20 text-white' : 'bg-emerald-200 text-emerald-900' }}">{{ $counts['approved'] }}</span>
                </a>
            </div>

            <!-- Search Form -->
            <form action="{{ route('admin.comments.index') }}" method="GET" class="flex items-center gap-2">
                <input type="hidden" name="status" value="{{ $status }}">
                <input type="hidden" name="source" value="{{ $source }}">
                <div class="relative w-full md:w-64">
                    <i class="fa-solid fa-magnifying-glass absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-xs"></i>
                    <input type="text" name="q" value="{{ $search }}" placeholder="Cari nama, email, modul, berita..."
                           class="w-full pl-8 pr-3 py-2 text-xs rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500">
                </div>
                @if($search)
                    <a href="{{ route('admin.comments.index', ['status' => $status, 'source' => $source]) }}" class="px-3 py-2 rounded-xl bg-slate-100 text-slate-600 hover:bg-slate-200 text-xs font-semibold" title="Reset pencarian">
                        <i class="fa-solid fa-xmark"></i>
                    </a>
                @endif
                <button type="submit" class="px-4 py-2 rounded-xl bg-red-600 text-white text-xs font-bold hover:bg-red-700 transition">
                    Cari
                </button>
            </form>
        </div>

        <!-- Source / Platform Filter Badges -->
        <div class="pt-3 border-t border-slate-100 flex items-center gap-2 text-xs">
            <span class="text-slate-400 font-medium me-1">Filter Sumber:</span>
            
            <a href="{{ route('admin.comments.index', ['status' => $status, 'source' => 'all', 'q' => $search]) }}"
               class="px-3 py-1 rounded-lg font-bold transition flex items-center gap-1.5 {{ $source === 'all' ? 'bg-slate-800 text-white' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                <span>Semua Sumber</span>
                <span class="text-[10px] opacity-80">({{ $counts['all'] }})</span>
            </a>

            <a href="{{ route('admin.comments.index', ['status' => $status, 'source' => 'news', 'q' => $search]) }}"
               class="px-3 py-1 rounded-lg font-bold transition flex items-center gap-1.5 {{ $source === 'news' ? 'bg-rose-600 text-white' : 'bg-rose-50 text-rose-700 hover:bg-rose-100' }}">
                <i class="fa-solid fa-newspaper text-xs"></i>
                <span>Berita Saja</span>
                <span class="text-[10px] opacity-80">({{ $counts['news'] }})</span>
            </a>

            <a href="{{ route('admin.comments.index', ['status' => $status, 'source' => 'sakti', 'q' => $search]) }}"
               class="px-3 py-1 rounded-lg font-bold transition flex items-center gap-1.5 {{ $source === 'sakti' ? 'bg-purple-600 text-white' : 'bg-purple-50 text-purple-700 hover:bg-purple-100' }}">
                <i class="fa-solid fa-graduation-cap text-xs"></i>
                <span>Modul SAKTI Saja</span>
                <span class="text-[10px] opacity-80">({{ $counts['sakti'] }})</span>
            </a>
        </div>

    </div>

    <!-- Comments List -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="p-5 border-b border-slate-100 flex items-center justify-between">
            <div>
                <h3 class="font-bold text-slate-800 text-base">Daftar Komentar Masuk</h3>
                <p class="text-xs text-slate-500">Komentar publik hanya akan tayang setelah diverifikasi dan disetujui oleh admin</p>
            </div>
            <span class="text-xs font-bold text-slate-500 bg-slate-100 px-3 py-1 rounded-full">
                Menampilkan {{ $comments->count() }} dari {{ $comments->total() }} Komentar
            </span>
        </div>

        <div class="divide-y divide-slate-100">
            @forelse($comments as $item)
                <div class="p-5 hover:bg-slate-50/70 transition space-y-3 {{ !$item->is_approved ? 'bg-amber-50/30' : '' }}">
                    
                    <!-- Top row: Target info & Status badge -->
                    <div class="flex flex-wrap items-center justify-between gap-2">
                        <div class="flex flex-wrap items-center gap-2 text-xs">
                            <!-- Source Type Badge -->
                            @if($item->news_id)
                                <span class="px-2 py-0.5 rounded text-[11px] font-bold bg-rose-100 text-rose-700 inline-flex items-center gap-1">
                                    <i class="fa-solid fa-newspaper text-[10px]"></i> Berita
                                </span>
                            @elseif($item->sakti_content_id)
                                <span class="px-2 py-0.5 rounded text-[11px] font-bold bg-purple-100 text-purple-800 inline-flex items-center gap-1">
                                    <i class="fa-solid fa-graduation-cap text-[10px]"></i> {{ $item->source_type_label }}
                                </span>
                            @else
                                <span class="px-2 py-0.5 rounded text-[11px] font-bold bg-slate-100 text-slate-600">Umum</span>
                            @endif

                            <span class="text-slate-400 font-medium">Judul:</span>
                            @if($item->target_url)
                                <a href="{{ $item->target_url }}" target="_blank" class="font-bold text-slate-800 hover:text-red-600 hover:underline flex items-center gap-1.5">
                                    <span>{{ $item->target_title }}</span>
                                    <i class="fa-solid fa-arrow-up-right-from-square text-[10px] text-slate-400"></i>
                                </a>
                            @else
                                <span class="text-slate-400 italic">{{ $item->target_title }}</span>
                            @endif
                        </div>

                        <div>
                            @if($item->is_approved)
                                <span class="inline-flex items-center gap-1 px-2.5 py-1 text-[11px] font-bold bg-emerald-100 text-emerald-800 rounded-full">
                                    <i class="fa-solid fa-circle-check text-emerald-600"></i>
                                    <span>Tayang (Disetujui)</span>
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1 px-2.5 py-1 text-[11px] font-bold bg-amber-100 text-amber-800 rounded-full animate-pulse">
                                    <i class="fa-solid fa-clock-rotate-left text-amber-600"></i>
                                    <span>Menunggu Persetujuan</span>
                                </span>
                            @endif
                        </div>
                    </div>

                    <!-- Middle: Comment text card -->
                    <div class="p-4 bg-slate-50 border border-slate-200/80 rounded-xl text-slate-800 text-sm leading-relaxed whitespace-pre-line">
                        {{ $item->comment }}
                    </div>

                    <!-- Bottom row: Commenter info & Action buttons -->
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 pt-1">
                        <div class="flex flex-wrap items-center gap-x-4 gap-y-1 text-xs text-slate-500">
                            <span class="font-bold text-slate-900 flex items-center gap-1.5">
                                <i class="fa-solid fa-circle-user text-slate-400"></i>
                                {{ $item->name }}
                            </span>
                            <span class="flex items-center gap-1">
                                <i class="fa-solid fa-envelope text-slate-400"></i>
                                {{ $item->email }}
                            </span>
                            @if($item->ip_address)
                                <span class="text-slate-400 font-mono text-[11px]">
                                    IP: {{ $item->ip_address }}
                                </span>
                            @endif
                            <span class="flex items-center gap-1 text-slate-400">
                                <i class="fa-regular fa-clock"></i>
                                {{ $item->created_at ? $item->created_at->translatedFormat('d M Y, H:i') : '-' }} WIB
                            </span>
                        </div>

                        <!-- Actions -->
                        <div class="flex items-center gap-2">
                            <!-- Toggle Approve -->
                            <form action="{{ route('admin.comments.toggleApprove', $item->id) }}" method="POST">
                                @csrf
                                @if(!$item->is_approved)
                                    <button type="submit" class="px-3.5 py-1.5 rounded-lg text-xs font-bold bg-emerald-600 text-white hover:bg-emerald-700 transition flex items-center gap-1.5 shadow-sm">
                                        <i class="fa-solid fa-check"></i>
                                        <span>Setujui & Tayangkan</span>
                                    </button>
                                @else
                                    <button type="submit" class="px-3.5 py-1.5 rounded-lg text-xs font-bold bg-slate-100 text-slate-700 hover:bg-slate-200 transition flex items-center gap-1.5">
                                        <i class="fa-solid fa-eye-slash"></i>
                                        <span>Sembunyikan</span>
                                    </button>
                                @endif
                            </form>

                            <!-- Delete -->
                            <form action="{{ route('admin.comments.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus komentar ini secara permanen?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="px-3 py-1.5 rounded-lg text-xs font-bold bg-red-50 text-red-600 hover:bg-red-100 transition flex items-center gap-1">
                                    <i class="fa-solid fa-trash"></i>
                                    <span>Hapus</span>
                                </button>
                            </form>
                        </div>
                    </div>

                </div>
            @empty
                <div class="py-16 text-center space-y-3">
                    <div class="w-12 h-12 bg-slate-100 rounded-full flex items-center justify-center mx-auto text-slate-400 text-lg">
                        <i class="fa-regular fa-comments"></i>
                    </div>
                    <div class="text-slate-500 font-semibold text-sm">Tidak ada komentar yang ditemukan.</div>
                    <p class="text-xs text-slate-400">Belum ada komentar dengan kriteria status atau sumber yang dipilih.</p>
                </div>
            @endforelse
        </div>

        @if($comments->hasPages())
            <div class="p-4 border-t border-slate-100 bg-slate-50/50">
                {{ $comments->links() }}
            </div>
        @endif
    </div>

</div>
@endsection
