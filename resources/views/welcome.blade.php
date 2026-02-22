@extends('layouts.app')

@section('title', 'Beranda - PSSI Gianyar')

@section('content')

{{-- FITUR PEMULIHAN BENCANA: Pita Peringatan Darurat --}}
@if($emergencyNews)
<div class="w-full bg-red-600 text-white px-4 py-3 text-center z-50 relative animate-pulse shadow-lg border-b-4 border-red-800">
    <span class="font-bold uppercase tracking-widest text-xs md:text-sm">
        ⚠️ PERINGATAN DARURAT: {{ $emergencyNews->title }} ⚠️
    </span>
</div>
@endif

<div class="relative min-h-screen md:h-[85vh] flex items-center justify-center overflow-hidden pt-24 md:pt-0">
    
    <div class="absolute inset-0 z-0">
        <img src="https://static.promediateknologi.id/crop/0x0:0x0/0x0/webp/photo/p2/67/2024/02/10/Stadion-1206760733.jpg" 
             alt="Football Field" 
             class="w-full h-full object-cover opacity-40">
        <div class="absolute inset-0 bg-gradient-to-t from-black via-black/60 to-black/30"></div>
    </div>

    <div class="relative z-10 text-center px-4 max-w-5xl mx-auto mt-0 md:mt-10">
        <div class="inline-block mb-4 animate-bounce">
            <span class="px-4 py-1 border border-red-600 text-red-500 text-[10px] md:text-xs font-bold uppercase tracking-[0.3em] rounded-full bg-black/50 backdrop-blur-md">
                Official Website
            </span>
        </div>
        
        <h1 class="text-5xl sm:text-6xl md:text-8xl font-black text-white uppercase italic tracking-tighter mb-6 leading-tight drop-shadow-2xl">
            Bangkitkan <br>
            <span class="text-transparent bg-clip-text bg-gradient-to-r from-red-600 to-red-400">Gairah Bola</span> <br>
            Gianyar
        </h1>

        <p class="text-zinc-400 text-base md:text-xl max-w-2xl mx-auto mb-10 font-light leading-relaxed px-2">
            Wadah resmi informasi kompetisi, klub, dan perkembangan sepak bola di Kabupaten Gianyar. Junjung tinggi sportivitas demi prestasi.
        </p>

        <div class="flex flex-col sm:flex-row flex-wrap gap-4 justify-center items-center w-full px-4 sm:px-0">
            
            <a href="{{ route('clubs.index') }}" class="w-full sm:w-auto group relative px-8 py-4 bg-red-600 hover:bg-red-700 text-white font-heading font-bold uppercase tracking-widest md:-skew-x-12 transition-all hover:scale-105 shadow-[0_0_20px_rgba(220,38,38,0.5)] text-center">
                <span class="block md:skew-x-12">Lihat Klub</span>
            </a>

            <a href="{{ route('club.register') }}" class="w-full sm:w-auto group relative px-8 py-4 border-2 border-red-600 hover:bg-red-600 text-red-500 hover:text-white font-heading font-bold uppercase tracking-widest md:-skew-x-12 transition-all hover:scale-105 shadow-[0_0_15px_rgba(220,38,38,0.3)] text-center">
                <span class="block md:skew-x-12">Daftar Klub Baru</span>
            </a>
            
            <a href="#" class="w-full sm:w-auto group px-8 py-4 border border-zinc-600 hover:border-white text-zinc-300 hover:text-white font-heading font-bold uppercase tracking-widest md:-skew-x-12 transition-all hover:bg-white/5 text-center">
                <span class="block md:skew-x-12">Jadwal</span>
            </a>
            
        </div>
    </div>
</div>

<div class="bg-zinc-900 border-y border-white/5 relative overflow-hidden">
    <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-transparent via-red-600 to-transparent opacity-50"></div>
    
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 md:py-16">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-y-8 md:gap-8 text-center md:divide-x divide-white/5">
            <div class="group">
                <span class="block text-3xl md:text-5xl font-heading font-bold text-white mb-2 group-hover:text-red-600 transition">2026</span>
                <span class="text-zinc-500 text-[10px] md:text-xs uppercase tracking-widest font-bold">Musim Kompetisi</span>
            </div>
            <div class="group">
                <span class="block text-3xl md:text-5xl font-heading font-bold text-white mb-2 group-hover:text-red-600 transition">
                    {{ \App\Models\Club::count() ?? '18' }}
                </span>
                <span class="text-zinc-500 text-[10px] md:text-xs uppercase tracking-widest font-bold">Klub Terdaftar</span>
            </div>
            <div class="group">
                <span class="block text-3xl md:text-5xl font-heading font-bold text-white mb-2 group-hover:text-red-600 transition">0</span>
                <span class="text-zinc-500 text-[10px] md:text-xs uppercase tracking-widest font-bold">Pertandingan</span>
            </div>
            <div class="group">
                <span class="block text-3xl md:text-5xl font-heading font-bold text-white mb-2 group-hover:text-red-600 transition">0</span>
                <span class="text-zinc-500 text-[10px] md:text-xs uppercase tracking-widest font-bold">Gol Tercipta</span>
            </div>
        </div>
    </div>
</div>

<div class="py-12 md:py-20 bg-black">
    <div class="max-w-7xl mx-auto px-4">
        
        <div class="flex flex-col md:flex-row justify-between items-end mb-8 md:mb-12">
            <div class="w-full md:w-auto text-center md:text-left">
                <h2 class="text-3xl md:text-4xl font-heading font-bold text-white italic uppercase mb-2">
                    Informasi <span class="text-red-600">Terkini</span>
                </h2>
                <div class="h-1 w-24 bg-red-600 -skew-x-12 mx-auto md:mx-0"></div>
            </div>
            <a href="#" class="hidden md:block text-zinc-500 hover:text-white transition uppercase text-sm font-bold tracking-widest">
                Lihat Semua Berita &rarr;
            </a>
        </div>

        {{-- PERBAIKAN: Looping Berita Dinamis dengan Link (Tag A) --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 md:gap-8">
            
            @forelse($latestNews as $news)
            {{-- PERUBAHAN: Tag <article> diganti menjadi <a> agar bisa diklik --}}
            <a href="{{ route('news.show', $news->slug) }}" class="bg-zinc-900 group cursor-pointer border border-zinc-800 hover:border-red-600/50 transition duration-300 rounded-lg md:rounded-none overflow-hidden flex flex-col h-full block">
                <div class="h-48 bg-zinc-800 relative overflow-hidden shrink-0">
                    <div class="absolute inset-0 bg-red-600/10 group-hover:bg-transparent transition z-10"></div>
                    
                    @if($news->thumbnail)
                        <img src="{{ asset('storage/' . $news->thumbnail) }}" alt="{{ $news->title }}" class="w-full h-full object-cover group-hover:scale-110 transition duration-500">
                    @else
                        <div class="flex items-center justify-center h-full text-zinc-700">
                            <svg class="w-16 h-16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/></svg>
                        </div>
                    @endif
                </div>
                
                <div class="p-6 flex flex-col grow">
                    <span class="text-red-500 text-[10px] font-bold uppercase tracking-widest mb-2 block">{{ $news->category }}</span>
                    <h3 class="text-xl font-bold text-white mb-3 group-hover:text-red-500 transition line-clamp-2">{{ $news->title }}</h3>
                    
                    <p class="text-zinc-400 text-sm leading-relaxed mb-4 line-clamp-3 grow">
                        {{ \Illuminate\Support\Str::limit(strip_tags($news->content), 120) }}
                    </p>
                    
                    <span class="text-zinc-600 text-[10px] uppercase font-bold mt-auto pt-4 border-t border-white/5">
                        Admin PSSI • {{ $news->formatted_date }}
                    </span>
                </div>
            </a>
            @empty
            <div class="col-span-1 md:col-span-3 text-center py-12 border border-dashed border-zinc-800 rounded-lg">
                <p class="text-zinc-500 text-sm uppercase tracking-widest font-bold">Belum ada informasi terbaru yang dipublikasikan.</p>
            </div>
            @endforelse

        </div>

        <div class="mt-8 block md:hidden">
            <a href="#" class="block w-full py-4 bg-zinc-900 border border-zinc-800 text-center text-zinc-400 hover:text-white hover:border-red-600 transition uppercase text-sm font-bold tracking-widest rounded-lg">
                Lihat Semua Berita &rarr;
            </a>
        </div>

    </div>
</div>
@endsection