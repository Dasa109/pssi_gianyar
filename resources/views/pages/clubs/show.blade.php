@extends('layouts.app')

@section('title', $club->name)

@section('content')
<div class="relative h-[400px] md:h-[500px] bg-zinc-900 flex items-center justify-center overflow-hidden">
    <div class="absolute inset-0 opacity-20 bg-[url('https://www.transparenttextures.com/patterns/carbon-fibre.png')]"></div>
    <div class="absolute inset-0 bg-gradient-to-b from-transparent via-zinc-900/80 to-zinc-900"></div>
    
    <div class="relative z-10 text-center px-4 flex flex-col items-center">
        <div class="w-32 h-32 md:w-48 md:h-48 mb-6 drop-shadow-[0_0_35px_rgba(220,38,38,0.4)] animate-pulse">
            @if($club->logo)
                <img src="{{ asset('storage/' . $club->logo) }}" alt="{{ $club->name }}" class="w-full h-full object-contain">
            @endif
        </div>
        
        <h1 class="text-5xl md:text-7xl font-black text-white uppercase italic font-heading tracking-tighter">
            {{ $club->name }}
        </h1>
        
        @if($club->stadium_name)
            <div class="mt-4 inline-flex items-center gap-2 bg-red-600/10 border border-red-600/30 px-6 py-2 rounded-full backdrop-blur-sm">
                <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                <span class="text-white font-bold tracking-widest uppercase text-sm">{{ $club->stadium_name }}</span>
            </div>
        @endif
    </div>
</div>

<div class="bg-zinc-900 pb-20 pt-10 px-4">
    <div class="max-w-6xl mx-auto grid grid-cols-1 lg:grid-cols-3 gap-10">
        
        <div class="lg:col-span-1 space-y-6">
            <div class="bg-zinc-800 border-l-4 border-red-600 p-6 rounded-r-lg">
                <h3 class="text-xl font-bold text-white mb-6 uppercase italic">Informasi Klub</h3>
                
                <div class="space-y-4">
                    <div class="flex justify-between border-b border-white/5 pb-2">
                        <span class="text-zinc-500 text-sm font-bold uppercase">Singkatan</span>
                        <span class="text-white font-bold">{{ $club->short_name ?? '-' }}</span>
                    </div>
                    <div class="flex justify-between border-b border-white/5 pb-2">
                        <span class="text-zinc-500 text-sm font-bold uppercase">Telepon</span>
                        <span class="text-white font-bold">{{ $club->phone ?? '-' }}</span>
                    </div>
                    <div class="border-b border-white/5 pb-2">
                        <span class="text-zinc-500 text-sm font-bold uppercase block mb-1">Alamat</span>
                        <span class="text-zinc-300 text-sm leading-relaxed">{{ $club->address ?? '-' }}</span>
                    </div>
                </div>
            </div>

            <a href="{{ route('clubs.index') }}" class="block w-full text-center py-3 border border-zinc-700 text-zinc-400 hover:text-white hover:border-white transition uppercase font-bold text-sm tracking-widest">
                &larr; Kembali ke Daftar
            </a>
        </div>

        <div class="lg:col-span-2">
            <div class="flex border-b border-white/10 mb-8">
                <button class="px-6 py-3 text-red-500 border-b-2 border-red-500 font-bold uppercase tracking-wide">
                    Profil & Sejarah
                </button>
                <button class="px-6 py-3 text-zinc-500 hover:text-white transition font-bold uppercase tracking-wide cursor-not-allowed opacity-50" title="Coming Soon">
                    Skuad Pemain
                </button>
            </div>

            <div class="bg-zinc-800/50 p-8 rounded border border-white/5">
                <h2 class="text-2xl font-bold text-white mb-4 italic">SEJARAH KLUB</h2>
                
                @if($club->history)
                    <div class="prose prose-invert prose-red max-w-none text-zinc-300">
                        {!! $club->history !!}
                    </div>
                @else
                    <p class="text-zinc-500 italic">Belum ada data sejarah untuk klub ini.</p>
                @endif
            </div>
            
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 mt-8">
                <div class="bg-black p-4 text-center border border-zinc-800">
                    <span class="block text-3xl font-bold text-red-600">0</span>
                    <span class="text-xs text-zinc-500 uppercase font-bold">Trofi Juara</span>
                </div>
                <div class="bg-black p-4 text-center border border-zinc-800">
                    <span class="block text-3xl font-bold text-white">0</span>
                    <span class="text-xs text-zinc-500 uppercase font-bold">Pertandingan</span>
                </div>
                <div class="bg-black p-4 text-center border border-zinc-800">
                    <span class="block text-3xl font-bold text-white">0</span>
                    <span class="text-xs text-zinc-500 uppercase font-bold">Menang</span>
                </div>
                <div class="bg-black p-4 text-center border border-zinc-800">
                    <span class="block text-3xl font-bold text-white">0</span>
                    <span class="text-xs text-zinc-500 uppercase font-bold">Gol</span>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection