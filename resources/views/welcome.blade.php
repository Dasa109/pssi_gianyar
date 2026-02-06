@extends('layouts.app')

@section('title', 'Beranda - PSSI Gianyar')

@section('content')
<div class="relative h-[85vh] flex items-center justify-center overflow-hidden">
    <div class="absolute inset-0 z-0">
        <img src="https://images.unsplash.com/photo-1517466787929-bc90951d6dbb?q=80&w=1935&auto=format&fit=crop" 
             alt="Football Field" 
             class="w-full h-full object-cover opacity-40">
        <div class="absolute inset-0 bg-gradient-to-t from-black via-black/60 to-black/30"></div>
    </div>

    <div class="relative z-10 text-center px-4 max-w-5xl mx-auto mt-10">
        <div class="inline-block mb-4 animate-bounce">
            <span class="px-4 py-1 border border-red-600 text-red-500 text-xs font-bold uppercase tracking-[0.3em] rounded-full bg-black/50 backdrop-blur-md">
                Official Website
            </span>
        </div>
        
        <h1 class="text-5xl md:text-8xl font-black text-white uppercase italic tracking-tighter mb-6 leading-tight drop-shadow-2xl">
            Bangkitkan <br>
            <span class="text-transparent bg-clip-text bg-gradient-to-r from-red-600 to-red-400">Gairah Bola</span> <br>
            Gianyar
        </h1>

        <p class="text-zinc-400 text-lg md:text-xl max-w-2xl mx-auto mb-10 font-light leading-relaxed">
            Wadah resmi informasi kompetisi, klub, dan perkembangan sepak bola di Kabupaten Gianyar. Junjung tinggi sportivitas demi prestasi.
        </p>

        <div class="flex flex-col md:flex-row gap-4 justify-center items-center">
            <a href="{{ route('clubs.index') }}" class="group relative px-8 py-4 bg-red-600 hover:bg-red-700 text-white font-heading font-bold uppercase tracking-widest -skew-x-12 transition-all hover:scale-105 shadow-[0_0_20px_rgba(220,38,38,0.5)]">
                <span class="block skew-x-12">Lihat Klub Peserta</span>
            </a>
            
            <a href="#" class="group px-8 py-4 border border-zinc-600 hover:border-white text-zinc-300 hover:text-white font-heading font-bold uppercase tracking-widest -skew-x-12 transition-all hover:bg-white/5">
                <span class="block skew-x-12">Jadwal Pertandingan</span>
            </a>
        </div>
    </div>
</div>

<div class="bg-zinc-900 border-y border-white/5 relative overflow-hidden">
    <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-transparent via-red-600 to-transparent opacity-50"></div>
    
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-8 text-center divide-x divide-white/5">
            <div class="group">
                <span class="block text-4xl md:text-5xl font-heading font-bold text-white mb-2 group-hover:text-red-600 transition">2026</span>
                <span class="text-zinc-500 text-xs uppercase tracking-widest font-bold">Musim Kompetisi</span>
            </div>
            <div class="group">
                {{-- Kita panggil jumlah klub asli dari database kalau mau, tapi ini placeholder --}}
                <span class="block text-4xl md:text-5xl font-heading font-bold text-white mb-2 group-hover:text-red-600 transition">
                    {{ \App\Models\Club::count() }}
                </span>
                <span class="text-zinc-500 text-xs uppercase tracking-widest font-bold">Klub Terdaftar</span>
            </div>
            <div class="group">
                <span class="block text-4xl md:text-5xl font-heading font-bold text-white mb-2 group-hover:text-red-600 transition">0</span>
                <span class="text-zinc-500 text-xs uppercase tracking-widest font-bold">Pertandingan</span>
            </div>
            <div class="group">
                <span class="block text-4xl md:text-5xl font-heading font-bold text-white mb-2 group-hover:text-red-600 transition">0</span>
                <span class="text-zinc-500 text-xs uppercase tracking-widest font-bold">Gol Tercipta</span>
            </div>
        </div>
    </div>
</div>

<div class="py-20 bg-black">
    <div class="max-w-7xl mx-auto px-4">
        <div class="flex flex-col md:flex-row justify-between items-end mb-12">
            <div>
                <h2 class="text-3xl md:text-4xl font-heading font-bold text-white italic uppercase mb-2">
                    Informasi <span class="text-red-600">Terkini</span>
                </h2>
                <div class="h-1 w-24 bg-red-600 -skew-x-12"></div>
            </div>
            <a href="#" class="hidden md:block text-zinc-500 hover:text-white transition uppercase text-sm font-bold tracking-widest">
                Lihat Semua Berita &rarr;
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <article class="bg-zinc-900 group cursor-pointer border border-zinc-800 hover:border-red-600/50 transition duration-300">
                <div class="h-48 bg-zinc-800 relative overflow-hidden">
                    <div class="absolute inset-0 bg-red-600/10 group-hover:bg-transparent transition"></div>
                    <div class="flex items-center justify-center h-full text-zinc-700">
                        <svg class="w-16 h-16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/></svg>
                    </div>
                </div>
                <div class="p-6">
                    <span class="text-red-500 text-xs font-bold uppercase tracking-widest mb-2 block">Regulasi</span>
                    <h3 class="text-xl font-bold text-white mb-3 group-hover:text-red-500 transition">Pendaftaran Klub Liga 2026 Resmi Dibuka</h3>
                    <p class="text-zinc-400 text-sm leading-relaxed mb-4">PSSI Gianyar membuka pendaftaran klub untuk musim kompetisi tahun depan. Segera lengkapi administrasi.</p>
                    <span class="text-zinc-600 text-xs uppercase font-bold">Admin PSSI • 2 Jam Lalu</span>
                </div>
            </article>

            <article class="bg-zinc-900 group cursor-pointer border border-zinc-800 hover:border-red-600/50 transition duration-300">
                <div class="h-48 bg-zinc-800 relative overflow-hidden">
                     <div class="flex items-center justify-center h-full text-zinc-700">
                        <svg class="w-16 h-16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 4a2 2 0 114 0v1a1 1 0 001 1h3a1 1 0 011 1v3a1 1 0 01-1 1h-1a2 2 0 100 4h1a1 1 0 011 1v3a1 1 0 01-1 1h-3a1 1 0 01-1-1v-1a2 2 0 10-4 0v1a1 1 0 01-1 1H7a1 1 0 01-1-1v-3a1 1 0 00-1-1H4a2 2 0 110-4h1a1 1 0 001-1V7a1 1 0 011-1h3a1 1 0 001-1V4z"/></svg>
                    </div>
                </div>
                <div class="p-6">
                    <span class="text-red-500 text-xs font-bold uppercase tracking-widest mb-2 block">Matchday</span>
                    <h3 class="text-xl font-bold text-white mb-3 group-hover:text-red-500 transition">Jadwal Pertandingan Pekan Pertama</h3>
                    <p class="text-zinc-400 text-sm leading-relaxed mb-4">Cek jadwal lengkap pertandingan pembuka liga yang akan diselenggarakan di Stadion Dipta.</p>
                    <span class="text-zinc-600 text-xs uppercase font-bold">Admin PSSI • 1 Hari Lalu</span>
                </div>
            </article>

            <article class="bg-zinc-900 group cursor-pointer border border-zinc-800 hover:border-red-600/50 transition duration-300">
                <div class="h-48 bg-zinc-800 relative overflow-hidden">
                     <div class="flex items-center justify-center h-full text-zinc-700">
                        <svg class="w-16 h-16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                    </div>
                </div>
                <div class="p-6">
                    <span class="text-red-500 text-xs font-bold uppercase tracking-widest mb-2 block">Transfer</span>
                    <h3 class="text-xl font-bold text-white mb-3 group-hover:text-red-500 transition">Bursa Transfer Pemain Resmi Ditutup</h3>
                    <p class="text-zinc-400 text-sm leading-relaxed mb-4">Setiap klub wajib mendaftarkan minimal 18 pemain dan maksimal 30 pemain.</p>
                    <span class="text-zinc-600 text-xs uppercase font-bold">Admin PSSI • 3 Hari Lalu</span>
                </div>
            </article>
        </div>
    </div>
</div>
@endsection