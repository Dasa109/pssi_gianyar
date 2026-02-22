@extends('layouts.app')

@section('title', 'Daftar Klub Liga Gianyar')

@section('content')
<div class="min-h-screen bg-zinc-900 py-12 md:py-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="flex flex-col md:flex-row justify-between items-center mb-16 mt-10 gap-6">
            <div class="text-center md:text-left">
                <h2 class="text-red-600 font-bold tracking-[0.2em] uppercase text-sm mb-2 animate-pulse">
                    Kompetisi 2026
                </h2>
                <h1 class="text-4xl md:text-6xl font-bold text-white uppercase font-heading italic">
                    Klub Peserta <span class="text-transparent bg-clip-text bg-gradient-to-r from-red-600 to-yellow-500">Liga Gianyar</span>
                </h1>
                <div class="h-1 w-24 bg-red-600 mt-6 -skew-x-12 mx-auto md:mx-0"></div>
            </div>

            {{-- TOMBOL DAFTAR KLUB BARU (HEADER) --}}
            <a href="{{ route('club.register') }}" class="group relative px-8 py-4 bg-red-600 hover:bg-red-700 text-white font-bold uppercase tracking-widest md:-skew-x-12 transition-all hover:scale-105 shadow-[0_0_20px_rgba(220,38,38,0.4)]">
                <span class="flex items-center gap-2 md:skew-x-12">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
                    Daftarkan Klub Anda
                </span>
            </a>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 md:gap-8">
            {{-- Loop untuk menampilkan klub --}}
            @forelse($clubs as $club)
                <a href="{{ route('clubs.show', $club->slug) }}" class="group relative bg-zinc-800 border border-white/5 hover:border-red-600 transition-all duration-300 overflow-hidden rounded-sm hover:-translate-y-2 block">
                    
                    <div class="absolute inset-0 bg-gradient-to-t from-red-900/40 to-transparent opacity-0 group-hover:opacity-100 transition duration-500"></div>

                    <div class="p-8 flex flex-col items-center relative z-10">
                        <div class="w-28 h-28 mb-6 relative group-hover:scale-110 transition duration-300">
                            @if($club->logo)
                                <img src="{{ asset('storage/' . $club->logo) }}" alt="{{ $club->name }}" class="w-full h-full object-contain drop-shadow-2xl">
                            @else
                                <div class="w-full h-full bg-zinc-700 rounded-full flex items-center justify-center text-zinc-500">
                                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 21v-8a2 2 0 012-2h14a2 2 0 012 2v8M9 10a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                                </div>
                            @endif
                        </div>

                        <h3 class="text-xl font-bold text-white uppercase text-center font-heading italic group-hover:text-red-500 transition line-clamp-2">
                            {{ $club->name }}
                        </h3>

                        @if($club->short_name)
                            <span class="mt-2 bg-black/50 border border-white/10 px-3 py-1 text-xs font-bold text-yellow-500 tracking-widest rounded-full">
                                {{ $club->short_name }}
                            </span>
                        @endif
                        
                        <div class="mt-4 flex items-center justify-center gap-2 text-zinc-500 text-xs font-semibold uppercase tracking-wide w-full">
                            <svg class="w-3 h-3 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            <span class="truncate">{{ $club->stadium ?? 'Stadion Belum Diisi' }}</span>
                        </div>
                    </div>
                </a>
            @empty
                <div class="col-span-full text-center py-20 border border-dashed border-zinc-700 rounded-lg bg-zinc-800/50">
                    <p class="text-zinc-400 text-lg uppercase font-bold tracking-widest mb-4">Belum Ada Klub Tersedia</p>
                    <p class="text-zinc-500 text-sm mb-8">Jadilah yang pertama mendaftarkan klub Anda di musim kompetisi 2026.</p>
                    
                    {{-- TOMBOL DAFTAR DI KONDISI KOSONG --}}
                    <a href="{{ route('club.register') }}" class="inline-flex items-center gap-2 px-8 py-3 border-2 border-red-600 text-red-600 hover:bg-red-600 hover:text-white font-bold uppercase tracking-widest transition-all">
                        Daftarkan Klub Sekarang
                    </a>
                </div>
            @endforelse
        </div>

    </div>
</div>
@endsection