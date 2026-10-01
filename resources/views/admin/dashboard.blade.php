@extends('admin.layout')

@section('title', 'Dashboard')
@section('page_title', 'Ringkasan & Statistik Portal')

@section('content')
<div class="space-y-8">
    
    <!-- Top Stats Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
        <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-sm flex items-center justify-between">
            <div>
                <p class="text-xs font-bold uppercase tracking-wider text-slate-400">Total Modul SAKTI</p>
                <h3 class="text-2xl font-black text-slate-800 mt-1">{{ $stats['sakti_count'] }}</h3>
                <p class="text-xs text-slate-500 mt-0.5">Konten 4 Pilar Utama</p>
            </div>
            <div class="w-12 h-12 rounded-xl bg-red-50 text-red-600 flex items-center justify-center text-xl font-bold">
                <i class="fa-solid fa-book-bookmark"></i>
            </div>
        </div>

        <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-sm flex items-center justify-between">
            <div>
                <p class="text-xs font-bold uppercase tracking-wider text-slate-400">Pengurus Terdaftar</p>
                <h3 class="text-2xl font-black text-slate-800 mt-1">{{ $stats['executives_count'] }}</h3>
                <p class="text-xs text-slate-500 mt-0.5">Struktur Organisasi</p>
            </div>
            <div class="w-12 h-12 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center text-xl font-bold">
                <i class="fa-solid fa-users-gear"></i>
            </div>
        </div>

        <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-sm flex items-center justify-between">
            <div>
                <p class="text-xs font-bold uppercase tracking-wider text-slate-400">Foto & Dokumen</p>
                <h3 class="text-2xl font-black text-slate-800 mt-1">{{ $stats['galleries_count'] }}</h3>
                <p class="text-xs text-slate-500 mt-0.5">Item Galeri Publik</p>
            </div>
            <div class="w-12 h-12 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center text-xl font-bold">
                <i class="fa-solid fa-images"></i>
            </div>
        </div>

        <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-sm flex items-center justify-between">
            <div>
                <p class="text-xs font-bold uppercase tracking-wider text-slate-400">Pesan / Aspirasi</p>
                <h3 class="text-2xl font-black text-slate-800 mt-1">{{ $stats['messages_count'] }}</h3>
                <p class="text-xs text-slate-500 mt-0.5">
                    @if($stats['unread_messages'] > 0)
                        <span class="text-amber-600 font-bold">{{ $stats['unread_messages'] }} belum dibaca</span>
                    @else
                        Semua terbaca
                    @endif
                </p>
            </div>
            <div class="w-12 h-12 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center text-xl font-bold">
                <i class="fa-solid fa-envelope-open-text"></i>
            </div>
        </div>
    </div>

    <!-- Quick Actions Banner -->
    <div class="bg-gradient-to-r from-slate-900 via-slate-800 to-red-950 p-6 rounded-2xl text-white shadow-xl flex flex-col md:flex-row items-center justify-between gap-4">
        <div>
            <h3 class="text-lg font-bold">Kelola Portal PGRI</h3>
            <p class="text-xs text-slate-300">Pilih tindakan cepat di bawah ini untuk memperbarui informasi website PGRI.</p>
        </div>
        <div class="flex flex-wrap gap-2">
            <a href="{{ route('admin.sakti.index') }}" class="bg-red-600 hover:bg-red-500 text-white text-xs font-bold px-4 py-2.5 rounded-xl shadow transition flex items-center gap-1.5">
                <i class="fa-solid fa-plus"></i> SAKTI Konten
            </a>
            <a href="{{ route('admin.executives.index') }}" class="bg-slate-700 hover:bg-slate-600 text-white text-xs font-bold px-4 py-2.5 rounded-xl shadow transition flex items-center gap-1.5">
                <i class="fa-solid fa-user-plus"></i> Pengurus
            </a>
            <a href="{{ route('admin.galleries.index') }}" class="bg-amber-600 hover:bg-amber-500 text-white text-xs font-bold px-4 py-2.5 rounded-xl shadow transition flex items-center gap-1.5">
                <i class="fa-solid fa-upload"></i> Foto Galeri
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        
        <!-- Recent SAKTI List -->
        <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm p-5">
            <div class="flex items-center justify-between mb-4 pb-3 border-b border-slate-100">
                <h4 class="font-bold text-slate-800 text-base">Modul SAKTI Terkini</h4>
                <a href="{{ route('admin.sakti.index') }}" class="text-xs font-semibold text-red-600 hover:underline">Lihat Semua &rarr;</a>
            </div>
            <div class="space-y-3">
                @forelse($recent_sakti as $sakti)
                    <div class="flex items-center justify-between p-3 rounded-xl bg-slate-50 border border-slate-100">
                        <div class="flex items-center gap-3">
                            <span class="px-2.5 py-1 text-[10px] font-extrabold uppercase tracking-wide rounded-md 
                                @if($sakti->category == 'pembelajaran_mendalam') bg-red-100 text-red-700 
                                @elseif($sakti->category == 'rumah_pendidikan') bg-amber-100 text-amber-800 
                                @elseif($sakti->category == 'pid') bg-blue-100 text-blue-700 
                                @else bg-emerald-100 text-emerald-800 @endif">
                                {{ strtoupper(str_replace('_', ' ', $sakti->category)) }}
                            </span>
                            <div>
                                <h5 class="font-semibold text-slate-800 text-sm line-clamp-1">{{ $sakti->title }}</h5>
                                <p class="text-xs text-slate-400">{{ $sakti->created_at ? $sakti->created_at->format('d M Y') : '-' }}</p>
                            </div>
                        </div>
                        <a href="{{ route('admin.sakti.index') }}" class="text-slate-400 hover:text-red-600 text-sm p-1">
                            <i class="fa-solid fa-pen-to-square"></i>
                        </a>
                    </div>
                @empty
                    <p class="text-xs text-slate-400 text-center py-6">Belum ada modul SAKTI.</p>
                @endforelse
            </div>
        </div>

        <!-- Recent Aspirasi / Messages -->
        <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm p-5">
            <div class="flex items-center justify-between mb-4 pb-3 border-b border-slate-100">
                <h4 class="font-bold text-slate-800 text-base">Pesan & Aspirasi Masuk</h4>
                <a href="{{ route('admin.messages.index') }}" class="text-xs font-semibold text-red-600 hover:underline">Lihat Semua &rarr;</a>
            </div>
            <div class="space-y-3">
                @forelse($recent_messages as $msg)
                    <div class="p-3 rounded-xl border {{ $msg->is_read ? 'bg-slate-50 border-slate-100' : 'bg-amber-50/70 border-amber-200' }}">
                        <div class="flex items-center justify-between mb-1">
                            <div class="flex items-center gap-2">
                                <span class="font-bold text-slate-800 text-sm">{{ $msg->name }}</span>
                                <span class="text-xs text-slate-400">({{ $msg->email }})</span>
                            </div>
                            <span class="text-[10px] text-slate-400">{{ $msg->created_at ? $msg->created_at->diffForHumans() : '-' }}</span>
                        </div>
                        <p class="text-xs font-medium text-slate-700 line-clamp-1">Subjek: {{ $msg->subject ?? 'Tanpa Subjek' }}</p>
                        <p class="text-xs text-slate-500 line-clamp-2 mt-1">{{ $msg->message }}</p>
                    </div>
                @empty
                    <p class="text-xs text-slate-400 text-center py-6">Belum ada pesan masuk.</p>
                @endforelse
            </div>
        </div>

    </div>

</div>
@endsection
