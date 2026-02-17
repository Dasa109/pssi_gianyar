@extends('layouts.app')

@section('title', $club->name . ' - PSSI Gianyar')

@section('content')
<div class="relative h-[50vh] bg-black flex items-center justify-center overflow-hidden">
    <div class="absolute inset-0 opacity-40">
        <img src="https://images.unsplash.com/photo-1522778119026-d647f0565c6a?auto=format&fit=crop&w=1920&q=80" class="w-full h-full object-cover">
    </div>
    <div class="absolute inset-0 bg-gradient-to-t from-black via-black/50 to-transparent"></div>
    
    <div class="relative z-10 text-center mt-10">
        <div class="w-32 h-32 mx-auto bg-white rounded-full p-2 shadow-2xl mb-4 animate-bounce-slow">
            <img src="{{ $club->logo }}" alt="Logo" class="w-full h-full object-contain rounded-full">
        </div>
        <h1 class="text-4xl md:text-6xl font-heading font-bold text-white uppercase tracking-wider">{{ $club->name }}</h1>
        <p class="text-red-500 font-bold uppercase tracking-[0.3em] text-sm mt-2">{{ $club->nickname }}</p>
    </div>
</div>

<div class="bg-zinc-900 min-h-screen py-12 px-4">
    <div class="max-w-5xl mx-auto grid grid-cols-1 md:grid-cols-3 gap-8">
        
        <div class="md:col-span-2 space-y-8">
            <div class="bg-black border border-zinc-800 p-8 rounded-xl">
                <h3 class="text-2xl font-heading font-bold text-white border-l-4 border-red-600 pl-4 mb-4">Tentang Klub</h3>
                <p class="text-zinc-400 leading-relaxed text-lg">
                    {{ $club->description }}
                </p>
            </div>

            <div>
                <h3 class="text-2xl font-heading font-bold text-white mb-6">Skuad Pemain</h3>
                <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                    @for($i = 1; $i <= 6; $i++)
                    <div class="bg-black border border-zinc-800 p-4 rounded-lg flex items-center space-x-4">
                        <div class="w-12 h-12 bg-zinc-800 rounded-full flex items-center justify-center text-zinc-500">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                        </div>
                        <div>
                            <p class="text-white font-bold text-sm">Pemain {{ $i }}</p>
                            <p class="text-red-600 text-xs font-bold uppercase">Posisi</p>
                        </div>
                    </div>
                    @endfor
                </div>
            </div>
        </div>

        <div class="space-y-6">
            <div class="bg-zinc-950 border border-zinc-800 p-6 rounded-xl">
                <h4 class="text-white font-bold uppercase tracking-widest mb-6 text-sm text-center">Informasi Klub</h4>
                
                <div class="space-y-4">
                    <div class="flex justify-between border-b border-zinc-800 pb-2">
                        <span class="text-zinc-500">Berdiri</span>
                        <span class="text-white font-bold">{{ $club->founded }}</span>
                    </div>
                    <div class="flex justify-between border-b border-zinc-800 pb-2">
                        <span class="text-zinc-500">Stadion</span>
                        <span class="text-white font-bold text-right">{{ $club->stadium }}</span>
                    </div>
                    <div class="flex justify-between border-b border-zinc-800 pb-2">
                        <span class="text-zinc-500">Manajer</span>
                        <span class="text-white font-bold">Coach Dummy</span>
                    </div>
                </div>

                <a href="#" class="block w-full bg-red-600 hover:bg-red-700 text-white text-center font-bold py-3 mt-8 rounded uppercase tracking-widest transition">
                    Lihat Jadwal
                </a>
            </div>
        </div>

    </div>
</div>
@endsection