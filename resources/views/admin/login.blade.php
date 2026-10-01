<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin - PGRI Portal</title>
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('images/logo-pgri.png') }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>body { font-family: 'Plus Jakarta Sans', sans-serif; }</style>
</head>
<body class="bg-slate-900 text-slate-100 min-h-screen flex items-center justify-center p-4">

    <div class="w-full max-w-md">
        <!-- Official Logo & Title -->
        <div class="text-center mb-6">
            <img src="{{ asset('images/logo-pgri.png') }}" alt="Logo PGRI" class="w-20 h-20 object-contain mx-auto mb-3 drop-shadow-2xl">
            <h1 class="text-2xl font-black text-white tracking-tight">Portal Admin PGRI</h1>
            <p class="text-emerald-400 text-xs font-semibold mt-1">Persatuan Guru Republik Indonesia</p>
        </div>

        <!-- Login Form Card -->
        <div class="bg-slate-800/90 backdrop-blur border border-slate-700/60 rounded-2xl p-8 shadow-2xl">

            @if($errors->any())
                <div class="mb-6 p-4 rounded-xl bg-red-950/60 border border-red-800/80 text-red-200 text-xs font-medium space-y-1">
                    @foreach($errors->all() as $error)
                        <p class="flex items-center gap-2"><i class="fa-solid fa-circle-exclamation text-red-400"></i> {{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <form action="{{ route('admin.login.submit') }}" method="POST" class="space-y-5">
                @csrf
                <div>
                    <label class="block text-xs font-semibold uppercase tracking-wider text-slate-300 mb-2">Alamat Email</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center text-slate-500">
                            <i class="fa-solid fa-envelope"></i>
                        </span>
                        <input type="email" name="email" value="{{ old('email') }}" required placeholder="Masukkan alamat email Anda..." class="w-full bg-slate-900 border border-slate-700 rounded-xl py-3 pl-10 pr-4 text-sm text-white placeholder-slate-500 focus:outline-none focus:border-red-500 focus:ring-1 focus:ring-red-500 transition">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-semibold uppercase tracking-wider text-slate-300 mb-2">Kata Sandi</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center text-slate-500">
                            <i class="fa-solid fa-lock"></i>
                        </span>
                        <input type="password" name="password" required placeholder="••••••••" class="w-full bg-slate-900 border border-slate-700 rounded-xl py-3 pl-10 pr-4 text-sm text-white placeholder-slate-500 focus:outline-none focus:border-red-500 focus:ring-1 focus:ring-red-500 transition">
                    </div>
                </div>

                <div class="flex items-center justify-between text-xs text-slate-400">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" name="remember" class="rounded bg-slate-900 border-slate-700 text-red-600 focus:ring-red-500">
                        <span>Ingat saya di perangkat ini</span>
                    </label>
                </div>

                <button type="submit" class="w-full bg-gradient-to-r from-red-600 to-red-700 hover:from-red-500 hover:to-red-600 text-white font-bold py-3 px-4 rounded-xl text-sm shadow-lg shadow-red-900/40 transition flex items-center justify-center gap-2">
                    <span>Masuk ke Dashboard</span>
                    <i class="fa-solid fa-arrow-right"></i>
                </button>

                <a href="{{ route('home') }}" class="w-full bg-slate-900/80 hover:bg-slate-900 text-slate-300 hover:text-white font-semibold py-3 px-4 rounded-xl text-sm border border-slate-700 hover:border-slate-600 transition flex items-center justify-center gap-2 text-decoration-none">
                    <i class="fa-solid fa-arrow-left text-xs"></i>
                    <span>Kembali ke Halaman Utama</span>
                </a>
            </form>
        </div>

        <div class="text-center mt-6 text-xs text-slate-500">
            <p>&copy; {{ date('Y') }} PB PGRI. Transformasi Edukasi & Profesi Guru.</p>
        </div>
    </div>

</body>
</html>
