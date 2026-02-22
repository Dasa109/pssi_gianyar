@extends('layouts.app')

@section('title', $news->title . ' - PSSI Gianyar')

@section('content')
<div class="pt-24 pb-12 bg-black min-h-screen">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        
        {{-- Header Berita --}}
        <div class="mb-8 text-center mt-8">
            <span class="inline-block py-1 px-3 rounded-full bg-red-600/20 text-red-500 text-xs font-bold uppercase tracking-widest mb-4 border border-red-600/50">
                {{ $news->category }}
            </span>
            <h1 class="text-3xl md:text-5xl font-black text-white uppercase italic tracking-tighter mb-4">
                {{ $news->title }}
            </h1>
            <div class="text-zinc-500 text-sm font-bold uppercase tracking-widest flex items-center justify-center gap-4">
                <span>Admin PSSI</span>
                <span>•</span>
                <span>{{ $news->formatted_date }}</span>
            </div>
        </div>

        {{-- Thumbnail Gambar --}}
        @if($news->thumbnail)
            <div class="w-full h-64 md:h-[500px] relative rounded-xl overflow-hidden mb-10 border border-zinc-800 shadow-2xl">
                <img src="{{ asset('storage/' . $news->thumbnail) }}" alt="{{ $news->title }}" class="w-full h-full object-cover">
            </div>
        @endif

        {{-- Isi Konten Berita --}}
        {{-- Menggunakan class prose (Tailwind Typography) agar teks HTML rapi --}}
        <div class="prose prose-invert prose-lg max-w-none text-zinc-300 prose-a:text-red-500 hover:prose-a:text-red-400 prose-img:rounded-xl">
            {{-- PERHATIAN KEAMANAN: {!! !!} digunakan untuk merender tag HTML dari RichEditor --}}
            {!! $news->content !!}
        </div>

        {{-- Tombol Kembali --}}
        <div class="mt-12 pt-8 border-t border-zinc-800 text-center">
            <a href="{{ route('home') }}" class="inline-flex items-center justify-center px-8 py-4 border border-zinc-600 hover:border-red-600 text-zinc-300 hover:text-white font-heading font-bold uppercase tracking-widest transition-all hover:bg-red-600/10 rounded-lg">
                &larr; Kembali ke Beranda
            </a>
        </div>

    </div>
</div>
@endsection