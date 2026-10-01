@extends('admin.layout')

@section('title', 'Kelola Akun Pengguna')
@section('page_title', 'Kelola Akun & Hak Akses Pengguna')

@section('content')
<div class="space-y-6">

    <!-- Top Action & Info Bar -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-white p-5 rounded-2xl border border-slate-200 shadow-sm">
        <div>
            <h3 class="text-base font-bold text-slate-800 flex items-center gap-2">
                <i class="fa-solid fa-users-gear text-red-600"></i>
                <span>Manajemen Akun Pengguna PGRI</span>
            </h3>
            <p class="text-xs text-slate-500 mt-0.5">Kelola akun Admin, Pengurus Organisasi, dan Guru Anggota PGRI</p>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.users.create') }}" class="text-xs font-bold text-white bg-red-700 hover:bg-red-800 px-4 py-2 rounded-xl shadow-md transition inline-flex items-center gap-1.5">
                <i class="fa-solid fa-user-plus"></i>
                <span>Tambah Akun Baru</span>
            </a>
        </div>
    </div>

    <!-- Quick Stat Cards -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        <!-- Total Users -->
        <a href="{{ route('admin.users.index') }}" 
           class="p-4 rounded-2xl border transition {{ empty($role) ? 'bg-slate-900 text-white border-slate-900 shadow-md' : 'bg-white text-slate-800 border-slate-200 hover:border-slate-300 shadow-sm' }}">
            <div class="flex items-center justify-between">
                <span class="text-xs font-bold uppercase tracking-wider {{ empty($role) ? 'text-slate-400' : 'text-slate-500' }}">Semua Akun</span>
                <i class="fa-solid fa-users {{ empty($role) ? 'text-amber-400' : 'text-slate-400' }}"></i>
            </div>
            <div class="text-2xl font-black mt-2">{{ $totalUsers }}</div>
            <div class="text-[11px] {{ empty($role) ? 'text-slate-300' : 'text-slate-400' }} mt-0.5">Seluruh pengguna terdaftar</div>
        </a>

        <!-- Total Admins -->
        <a href="{{ route('admin.users.index', ['role' => 'admin']) }}" 
           class="p-4 rounded-2xl border transition {{ $role === 'admin' ? 'bg-red-700 text-white border-red-700 shadow-md' : 'bg-white text-slate-800 border-slate-200 hover:border-red-200 shadow-sm' }}">
            <div class="flex items-center justify-between">
                <span class="text-xs font-bold uppercase tracking-wider {{ $role === 'admin' ? 'text-red-200' : 'text-red-600' }}">Akun Admin</span>
                <i class="fa-solid fa-user-shield {{ $role === 'admin' ? 'text-white' : 'text-red-500' }}"></i>
            </div>
            <div class="text-2xl font-black mt-2">{{ $totalAdmins }}</div>
            <div class="text-[11px] {{ $role === 'admin' ? 'text-red-100' : 'text-slate-400' }} mt-0.5">Akses penuh sistem</div>
        </a>

        <!-- Total Pengurus -->
        <a href="{{ route('admin.users.index', ['role' => 'pengurus']) }}" 
           class="p-4 rounded-2xl border transition {{ $role === 'pengurus' ? 'bg-sky-700 text-white border-sky-700 shadow-md' : 'bg-white text-slate-800 border-slate-200 hover:border-sky-200 shadow-sm' }}">
            <div class="flex items-center justify-between">
                <span class="text-xs font-bold uppercase tracking-wider {{ $role === 'pengurus' ? 'text-sky-200' : 'text-sky-600' }}">Akun Pengurus</span>
                <i class="fa-solid fa-user-tie {{ $role === 'pengurus' ? 'text-white' : 'text-sky-500' }}"></i>
            </div>
            <div class="text-2xl font-black mt-2">{{ $totalPengurus }}</div>
            <div class="text-[11px] {{ $role === 'pengurus' ? 'text-sky-100' : 'text-slate-400' }} mt-0.5">Pengurus cabang / ranting</div>
        </a>

        <!-- Total Guru -->
        <a href="{{ route('admin.users.index', ['role' => 'guru']) }}" 
           class="p-4 rounded-2xl border transition {{ $role === 'guru' ? 'bg-emerald-700 text-white border-emerald-700 shadow-md' : 'bg-white text-slate-800 border-slate-200 hover:border-emerald-200 shadow-sm' }}">
            <div class="flex items-center justify-between">
                <span class="text-xs font-bold uppercase tracking-wider {{ $role === 'guru' ? 'text-emerald-200' : 'text-emerald-600' }}">Akun Guru</span>
                <i class="fa-solid fa-chalkboard-user {{ $role === 'guru' ? 'text-white' : 'text-emerald-500' }}"></i>
            </div>
            <div class="text-2xl font-black mt-2">{{ $totalGuru }}</div>
            <div class="text-[11px] {{ $role === 'guru' ? 'text-emerald-100' : 'text-slate-400' }} mt-0.5">Tenaga pendidik & anggota</div>
        </a>
    </div>

    <!-- Filter & Search Form -->
    <div class="bg-white p-4 rounded-xl border border-slate-200 shadow-sm flex flex-col md:flex-row items-center justify-between gap-3">
        <!-- Role filter pills -->
        <div class="flex flex-wrap items-center gap-1.5 w-full md:w-auto">
            <a href="{{ route('admin.users.index', ['search' => $search]) }}" 
               class="px-3 py-1.5 rounded-lg text-xs font-bold transition {{ empty($role) ? 'bg-slate-900 text-white shadow-sm' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                Semua ({{ $totalUsers }})
            </a>
            <a href="{{ route('admin.users.index', ['role' => 'admin', 'search' => $search]) }}" 
               class="px-3 py-1.5 rounded-lg text-xs font-bold transition {{ $role === 'admin' ? 'bg-red-700 text-white shadow-sm' : 'bg-red-50 text-red-700 hover:bg-red-100' }}">
                <i class="fa-solid fa-user-shield me-1"></i> Admin ({{ $totalAdmins }})
            </a>
            <a href="{{ route('admin.users.index', ['role' => 'pengurus', 'search' => $search]) }}" 
               class="px-3 py-1.5 rounded-lg text-xs font-bold transition {{ $role === 'pengurus' ? 'bg-sky-700 text-white shadow-sm' : 'bg-sky-50 text-sky-700 hover:bg-sky-100' }}">
                <i class="fa-solid fa-user-tie me-1"></i> Pengurus ({{ $totalPengurus }})
            </a>
            <a href="{{ route('admin.users.index', ['role' => 'guru', 'search' => $search]) }}" 
               class="px-3 py-1.5 rounded-lg text-xs font-bold transition {{ $role === 'guru' ? 'bg-emerald-700 text-white shadow-sm' : 'bg-emerald-50 text-emerald-700 hover:bg-emerald-100' }}">
                <i class="fa-solid fa-chalkboard-user me-1"></i> Guru ({{ $totalGuru }})
            </a>
        </div>

        <!-- Search input -->
        <form action="{{ route('admin.users.index') }}" method="GET" class="flex items-center gap-2 w-full md:w-auto">
            @if(!empty($role))
                <input type="hidden" name="role" value="{{ $role }}">
            @endif
            <div class="relative w-full md:w-64">
                <i class="fa-solid fa-magnifying-glass absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-xs"></i>
                <input type="text" name="search" value="{{ $search }}" placeholder="Cari nama, email, sekolah..." 
                       class="w-full pl-8 pr-3 py-1.5 bg-slate-50 border border-slate-300 rounded-lg text-xs focus:outline-none focus:border-red-500 focus:bg-white transition">
            </div>
            <button type="submit" class="bg-slate-900 hover:bg-slate-800 text-white text-xs font-semibold px-3 py-1.5 rounded-lg transition">
                Cari
            </button>
            @if(!empty($search) || !empty($role))
                <a href="{{ route('admin.users.index') }}" class="text-xs text-slate-500 hover:text-slate-800 px-2 py-1">
                    Reset
                </a>
            @endif
        </form>
    </div>

    <!-- Users Table -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse text-xs">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-200 text-slate-600 font-bold uppercase tracking-wider text-[11px]">
                        <th class="py-3.5 px-4 w-12 text-center">No</th>
                        <th class="py-3.5 px-4">Pengguna</th>
                        <th class="py-3.5 px-4 w-36">Peran (Role)</th>
                        <th class="py-3.5 px-4">Asal Sekolah / Instansi</th>
                        <th class="py-3.5 px-4 w-36">Kontak / WA</th>
                        <th class="py-3.5 px-4 w-28 text-center">Status</th>
                        <th class="py-3.5 px-4 w-32 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($users as $index => $u)
                        <tr class="hover:bg-slate-50/80 transition {{ Auth::id() == $u->id ? 'bg-amber-50/30' : '' }}">
                            <td class="py-3.5 px-4 text-center text-slate-400 font-medium">
                                {{ $users->firstItem() + $index }}
                            </td>
                            <td class="py-3.5 px-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-9 h-9 rounded-full flex items-center justify-center font-bold text-xs shadow-sm flex-shrink-0
                                        @if($u->role === 'admin') bg-red-100 text-red-700 border border-red-200
                                        @elseif($u->role === 'pengurus') bg-sky-100 text-sky-700 border border-sky-200
                                        @else bg-emerald-100 text-emerald-700 border border-emerald-200 @endif">
                                        {{ strtoupper(substr($u->name, 0, 1)) }}
                                    </div>
                                    <div>
                                        <div class="font-bold text-slate-800 text-sm flex items-center gap-1.5">
                                            <span>{{ $u->name }}</span>
                                            @if(Auth::id() == $u->id)
                                                <span class="bg-amber-100 text-amber-800 text-[10px] font-extrabold px-1.5 py-0.2 rounded border border-amber-200">
                                                    Anda
                                                </span>
                                            @endif
                                        </div>
                                        <div class="text-slate-400 text-[11px]">{{ $u->email }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="py-3.5 px-4">
                                @if($u->role === 'admin')
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[11px] font-bold bg-red-100 text-red-800 border border-red-200">
                                        <i class="fa-solid fa-user-shield text-[10px]"></i> Admin
                                    </span>
                                @elseif($u->role === 'pengurus')
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[11px] font-bold bg-sky-100 text-sky-800 border border-sky-200">
                                        <i class="fa-solid fa-user-tie text-[10px]"></i> Pengurus
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[11px] font-bold bg-emerald-100 text-emerald-800 border border-emerald-200">
                                        <i class="fa-solid fa-chalkboard-user text-[10px]"></i> Guru
                                    </span>
                                @endif
                            </td>
                            <td class="py-3.5 px-4">
                                @if(!empty($u->school_origin))
                                    <div class="text-slate-700 font-medium flex items-center gap-1.5">
                                        <i class="fa-solid fa-school text-slate-400 text-[11px]"></i>
                                        <span>{{ $u->school_origin }}</span>
                                    </div>
                                @else
                                    <span class="text-slate-400 italic text-[11px]">- Belum diatur -</span>
                                @endif
                            </td>
                            <td class="py-3.5 px-4">
                                @if(!empty($u->phone))
                                    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $u->phone) }}" target="_blank" 
                                       class="text-emerald-700 hover:text-emerald-800 font-medium inline-flex items-center gap-1">
                                        <i class="fa-brands fa-whatsapp text-emerald-600"></i>
                                        <span>{{ $u->phone }}</span>
                                    </a>
                                @else
                                    <span class="text-slate-400 italic text-[11px]">-</span>
                                @endif
                            </td>
                            <td class="py-3.5 px-4 text-center">
                                @if(Auth::id() == $u->id)
                                    <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-800 border border-emerald-200">
                                        <i class="fa-solid fa-circle-check text-[9px]"></i> Aktif
                                    </span>
                                @else
                                    <form action="{{ route('admin.users.toggleStatus', $u->id) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[10px] font-bold transition border
                                            {{ $u->is_active ? 'bg-emerald-50 text-emerald-700 border-emerald-200 hover:bg-emerald-100' : 'bg-slate-100 text-slate-500 border-slate-300 hover:bg-slate-200' }}"
                                            title="Klik untuk mengubah status akun">
                                            <i class="fa-solid {{ $u->is_active ? 'fa-circle-check text-emerald-600' : 'fa-circle-xmark text-slate-400' }} text-[9px]"></i>
                                            <span>{{ $u->is_active ? 'Aktif' : 'Nonaktif' }}</span>
                                        </button>
                                    </form>
                                @endif
                            </td>
                            <td class="py-3.5 px-4 text-center">
                                <div class="flex items-center justify-center gap-1.5">
                                    <a href="{{ route('admin.users.edit', $u->id) }}" 
                                       class="w-7 h-7 rounded-lg bg-amber-50 hover:bg-amber-100 text-amber-700 flex items-center justify-center transition" title="Edit Akun">
                                        <i class="fa-solid fa-pen-to-square text-xs"></i>
                                    </a>
                                    @if(Auth::id() != $u->id)
                                        <form action="{{ route('admin.users.destroy', $u->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus akun {{ $u->name }}?');" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="w-7 h-7 rounded-lg bg-red-50 hover:bg-red-100 text-red-600 flex items-center justify-center transition" title="Hapus Akun">
                                                <i class="fa-solid fa-trash-can text-xs"></i>
                                            </button>
                                        </form>
                                    @else
                                        <span class="w-7 h-7 rounded-lg bg-slate-100 text-slate-300 flex items-center justify-center cursor-not-allowed" title="Tidak dapat menghapus akun sendiri">
                                            <i class="fa-solid fa-trash-can text-xs"></i>
                                        </span>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-12 text-center text-slate-400">
                                <i class="fa-solid fa-user-slash text-3xl mb-2 text-slate-300"></i>
                                <p class="text-sm">Belum ada akun pengguna dengan kriteria pencarian ini.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($users->hasPages())
            <div class="p-4 border-t border-slate-100">
                {{ $users->links() }}
            </div>
        @endif
    </div>

</div>
@endsection
