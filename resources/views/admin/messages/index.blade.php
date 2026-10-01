@extends('admin.layout')

@section('title', 'Pesan & Aspirasi')
@section('page_title', 'Pesan & Aspirasi Anggota / Guru')

@section('content')
<div class="space-y-6">

    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="p-5 border-b border-slate-100 flex items-center justify-between">
            <div>
                <h3 class="font-bold text-slate-800 text-base">Kotak Masuk Aspirasi</h3>
                <p class="text-xs text-slate-500">Pesan yang dikirimkan oleh guru dan masyarakat melalui formulir kontak</p>
            </div>
            <span class="text-xs font-bold text-slate-500 bg-slate-100 px-3 py-1 rounded-full">
                Total {{ $messages->total() }} Pesan
            </span>
        </div>

        <div class="divide-y divide-slate-100">
            @forelse($messages as $msg)
                <div class="p-5 hover:bg-slate-50/80 transition flex flex-col md:flex-row items-start justify-between gap-4 {{ $msg->is_read ? '' : 'bg-amber-50/40' }}">
                    <div class="flex-1 space-y-2">
                        <div class="flex items-center gap-3">
                            <span class="font-bold text-slate-900 text-base">{{ $msg->name }}</span>
                            <span class="text-xs font-medium text-slate-500"><i class="fa-solid fa-envelope text-slate-400"></i> {{ $msg->email }}</span>
                            @if($msg->phone)
                                <span class="text-xs font-medium text-slate-500"><i class="fa-solid fa-phone text-slate-400"></i> {{ $msg->phone }}</span>
                            @endif
                            @if(!$msg->is_read)
                                <span class="px-2 py-0.5 text-[10px] font-extrabold uppercase bg-amber-500 text-white rounded-full">Baru</span>
                            @endif
                        </div>

                        <h4 class="font-bold text-slate-800 text-sm">Subjek: {{ $msg->subject ?? 'Tanpa Subjek' }}</h4>
                        
                        <div class="p-4 bg-slate-50 border border-slate-200/80 rounded-xl text-slate-700 text-sm leading-relaxed whitespace-pre-line">
                            {{ $msg->message }}
                        </div>

                        <p class="text-xs text-slate-400 flex items-center gap-1">
                            <i class="fa-regular fa-clock"></i> Dikirim pada {{ $msg->created_at ? $msg->created_at->format('d M Y - H:i') : '-' }} WIB
                        </p>
                    </div>

                    <div class="flex items-center gap-2 self-start md:self-auto">
                        <form action="{{ route('admin.messages.toggleRead', $msg->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="px-3 py-1.5 rounded-lg text-xs font-bold transition flex items-center gap-1.5 {{ $msg->is_read ? 'bg-slate-100 text-slate-600 hover:bg-slate-200' : 'bg-emerald-600 text-white hover:bg-emerald-700 shadow-sm' }}">
                                <i class="fa-solid {{ $msg->is_read ? 'fa-envelope-open' : 'fa-check-double' }}"></i>
                                <span>{{ $msg->is_read ? 'Tandai Belum Dibaca' : 'Tandai Sudah Dibaca' }}</span>
                            </button>
                        </form>

                        <form action="{{ route('admin.messages.destroy', $msg->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin menghapus pesan ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="px-3 py-1.5 rounded-lg text-xs font-bold bg-red-50 text-red-600 hover:bg-red-100 transition flex items-center gap-1">
                                <i class="fa-solid fa-trash"></i>
                                <span>Hapus</span>
                            </button>
                        </form>
                    </div>
                </div>
            @empty
                <div class="py-12 text-center text-slate-400 text-sm">
                    Belum ada pesan atau aspirasi yang masuk.
                </div>
            @endforelse
        </div>

        <div class="p-4 border-t border-slate-100">
            {{ $messages->links() }}
        </div>
    </div>

</div>
@endsection
