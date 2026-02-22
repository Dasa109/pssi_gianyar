<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi Pemain - PSSI Gianyar</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <style> body { font-family: 'Inter', sans-serif; } </style>
</head>
<body class="relative min-h-screen flex items-center justify-center overflow-hidden bg-slate-900 py-10">

    <a href="{{ url('/portal-pemain/login') }}" class="absolute top-6 left-6 z-50 inline-flex items-center px-4 py-2 bg-white/10 hover:bg-white/20 backdrop-blur-md text-white text-sm font-medium rounded-full border border-white/20 transition-all group shadow-lg">
        <svg class="w-4 h-4 mr-2 transition-transform group-hover:-translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
        Kembali ke Login
    </a>

    <div class="absolute inset-0 z-0 fixed">
        <img src="https://images.unsplash.com/photo-1522778119026-d647f0565c6a?q=80&w=1920&auto=format&fit=crop" 
             class="w-full h-full object-cover opacity-30">
        <div class="absolute inset-0 bg-gradient-to-br from-red-900/90 via-slate-900/90 to-black/95"></div>
    </div>

    <div class="relative z-10 w-full max-w-xl px-4">
        
        <div class="text-center mb-8">
            <h2 class="text-3xl font-bold text-white tracking-tight uppercase italic">Daftar Pemain Baru</h2>
            <p class="text-slate-300 mt-2 text-sm">Bergabunglah dengan klub resmi Liga Gianyar 2026</p>
        </div>

        <div class="bg-white/95 backdrop-blur-xl rounded-2xl shadow-2xl p-6 md:p-8 border border-white/20">
            
            @if ($errors->any())
                <div class="bg-red-50 border-l-4 border-red-500 text-red-700 p-4 rounded mb-6 text-sm">
                    <ul class="list-disc pl-5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ url('/portal-pemain/register') }}" method="POST" class="space-y-5">
                @csrf
                
                {{-- Nama Lengkap --}}
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1">Nama Lengkap Sesuai KTP/KIA</label>
                    <input type="text" name="name" value="{{ old('name') }}" required 
                           class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-lg focus:ring-2 focus:ring-red-500 outline-none transition-all">
                </div>

                {{-- Email --}}
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1">Alamat Email Aktif</label>
                    <input type="email" name="email" value="{{ old('email') }}" required 
                           class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-lg focus:ring-2 focus:ring-red-500 outline-none transition-all">
                </div>

                {{-- Pilihan Klub Dinamis --}}
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1">Pilih Klub Anda</label>
                    <select name="club_id" required 
                            class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-lg focus:ring-2 focus:ring-red-500 outline-none transition-all cursor-pointer">
                        <option value="" disabled selected>-- Pilih Klub yang Sudah Terdaftar --</option>
                        @foreach($clubs as $club)
                            <option value="{{ $club->id }}" {{ old('club_id') == $club->id ? 'selected' : '' }}>
                                {{ $club->name }}
                            </option>
                        @endforeach
                    </select>
                    <p class="text-xs text-slate-500 mt-1">*Hanya klub berstatus aktif yang muncul di daftar ini.</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    {{-- Password --}}
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1">Kata Sandi</label>
                        <input type="password" name="password" required 
                               class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-lg focus:ring-2 focus:ring-red-500 outline-none transition-all">
                    </div>
                    
                    {{-- Konfirmasi Password --}}
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1">Ulangi Kata Sandi</label>
                        <input type="password" name="password_confirmation" required 
                               class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-lg focus:ring-2 focus:ring-red-500 outline-none transition-all">
                    </div>
                </div>

                <button type="submit" class="w-full bg-red-600 text-white font-bold py-3 px-4 rounded-lg hover:bg-red-700 focus:ring-2 focus:ring-red-500 transition-all shadow-lg mt-4">
                    Daftar Sekarang
                </button>
            </form>

        </div>
    </div>
</body>
</html>