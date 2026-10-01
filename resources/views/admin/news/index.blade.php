@extends('admin.layout')

@section('title', 'Manajemen Berita PGRI')
@section('page_title', 'Berita & Reportase Kegiatan')

@section('content')
<div class="space-y-6">

    <!-- Top Action & Search Bar -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-white p-5 rounded-2xl border border-slate-200 shadow-sm">
        <div>
            <h3 class="text-base font-bold text-slate-800 flex items-center gap-2">
                <i class="fa-solid fa-newspaper text-red-600"></i>
                <span>Daftar Berita & Reportase PGRI</span>
                <span class="bg-red-100 text-red-800 text-xs px-2.5 py-0.5 rounded-full font-bold">{{ $newsList->total() }}</span>
            </h3>
            <p class="text-xs text-slate-500 mt-0.5">Kelola publikasi berita kegiatan, siaran pers, dan dokumentasi reportase PGRI</p>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('news.index') }}" target="_blank" class="text-xs font-bold text-slate-700 bg-slate-100 hover:bg-slate-200 px-3.5 py-2 rounded-xl transition inline-flex items-center gap-1.5">
                <i class="fa-solid fa-arrow-up-right-from-square"></i>
                <span>Lihat di Website</span>
            </a>
            <a href="{{ route('admin.news.create') }}" class="text-xs font-bold text-white bg-red-700 hover:bg-red-800 px-4 py-2 rounded-xl shadow-md transition inline-flex items-center gap-1.5">
                <i class="fa-solid fa-plus"></i>
                <span>Tulis Berita Baru</span>
            </a>
        </div>
    </div>

    <!-- Filter / Search -->
    <div class="bg-white p-4 rounded-xl border border-slate-200 shadow-sm">
        <form action="{{ route('admin.news.index') }}" method="GET" class="flex flex-col sm:flex-row gap-3">
            <div class="flex-1 relative">
                <i class="fa-solid fa-magnifying-glass absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-xs"></i>
                <input type="text" name="search" value="{{ $search }}" placeholder="Cari judul berita atau nama penyusun..." 
                       class="w-full pl-9 pr-4 py-2 bg-slate-50 border border-slate-300 rounded-xl text-xs focus:outline-none focus:border-red-500 focus:bg-white transition">
            </div>
            <button type="submit" class="bg-slate-900 hover:bg-slate-800 text-white text-xs font-semibold px-4 py-2 rounded-xl transition">
                Cari Berita
            </button>
            @if(!empty($search))
                <a href="{{ route('admin.news.index') }}" class="bg-slate-100 hover:bg-slate-200 text-slate-600 text-xs font-semibold px-4 py-2 rounded-xl transition inline-flex items-center">
                    Reset
                </a>
            @endif
        </form>
    </div>

    <!-- News Table -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse text-xs">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-200 text-slate-600 font-bold uppercase tracking-wider text-[11px]">
                        <th class="py-3.5 px-4 w-16 text-center">No</th>
                        <th class="py-3.5 px-4 w-28">Gambar</th>
                        <th class="py-3.5 px-4">Judul & Ringkasan</th>
                        <th class="py-3.5 px-4 w-44">Penyusun & Tanggal</th>
                        <th class="py-3.5 px-4 w-24 text-center">Pembaca</th>
                        <th class="py-3.5 px-4 w-24 text-center">Status</th>
                        <th class="py-3.5 px-4 w-32 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($newsList as $index => $item)
                        <tr class="hover:bg-slate-50/80 transition">
                            <td class="py-3.5 px-4 text-center text-slate-400 font-medium">
                                {{ $newsList->firstItem() + $index }}
                            </td>
                            <td class="py-3.5 px-4">
                                <div class="w-20 h-14 rounded-lg overflow-hidden border border-slate-200 bg-slate-100 flex-shrink-0">
                                    <img src="{{ $item->image ?? 'https://images.unsplash.com/photo-1517245386807-bb43f82c33c4?auto=format&fit=crop&w=300&q=80' }}" 
                                         alt="{{ $item->title }}" class="w-full h-full object-cover">
                                </div>
                            </td>
                            <td class="py-3.5 px-4">
                                <a href="{{ route('news.show', $item->slug) }}" target="_blank" class="font-bold text-slate-800 hover:text-red-700 text-sm leading-snug line-clamp-1">
                                    {{ $item->title }}
                                </a>
                                <p class="text-slate-500 mt-1 line-clamp-2 leading-relaxed text-[11px]">
                                    {{ $item->excerpt }}
                                </p>
                            </td>
                            <td class="py-3.5 px-4">
                                <div class="flex items-center gap-1.5 font-semibold text-slate-700">
                                    <i class="fa-solid fa-user-pen text-slate-400 text-[10px]"></i>
                                    <span>{{ $item->author }}</span>
                                </div>
                                <div class="flex items-center gap-1.5 text-slate-400 text-[11px] mt-0.5">
                                    <i class="fa-regular fa-calendar text-[10px]"></i>
                                    <span>{{ \Carbon\Carbon::parse($item->published_at)->translatedFormat('d M Y') }}</span>
                                </div>
                            </td>
                            <td class="py-3.5 px-4 text-center">
                                <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[11px] font-semibold bg-slate-100 text-slate-600">
                                    <i class="fa-regular fa-eye text-[10px]"></i>
                                    {{ number_format($item->views_count) }}
                                </span>
                            </td>
                            <td class="py-3.5 px-4 text-center">
                                @if($item->is_published)
                                    <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-800 border border-emerald-200">
                                        <i class="fa-solid fa-circle-check text-[9px]"></i> Rilis
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-bold bg-slate-100 text-slate-600 border border-slate-200">
                                        <i class="fa-solid fa-file-lines text-[9px]"></i> Draft
                                    </span>
                                @endif
                            </td>
                            <td class="py-3.5 px-4 text-center">
                                <div class="flex items-center justify-center gap-1.5">
                                    <a href="{{ route('news.show', $item->slug) }}" target="_blank" 
                                       class="w-7 h-7 rounded-lg bg-slate-100 hover:bg-slate-200 text-slate-600 flex items-center justify-center transition" title="Lihat di Website">
                                        <i class="fa-solid fa-eye text-xs"></i>
                                    </a>
                                    <a href="{{ route('admin.news.edit', $item->id) }}" 
                                       class="w-7 h-7 rounded-lg bg-amber-50 hover:bg-amber-100 text-amber-700 flex items-center justify-center transition" title="Edit Berita">
                                        <i class="fa-solid fa-pen-to-square text-xs"></i>
                                    </a>
                                    <form action="{{ route('admin.news.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus berita ini?');" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="w-7 h-7 rounded-lg bg-red-50 hover:bg-red-100 text-red-600 flex items-center justify-center transition" title="Hapus Berita">
                                            <i class="fa-solid fa-trash-can text-xs"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-12 text-center text-slate-400">
                                <i class="fa-solid fa-newspaper text-3xl mb-2 text-slate-300"></i>
                                <p class="text-sm">Belum ada berita kegiatan yang ditambahkan.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($newsList->hasPages())
            <div class="p-4 border-t border-slate-100">
                {{ $newsList->links() }}
            </div>
        @endif
    </div>

</div>
@endsection
