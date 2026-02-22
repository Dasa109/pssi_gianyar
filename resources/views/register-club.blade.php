@extends('layouts.app')

@section('title', 'Pendaftaran Klub Baru - PSSI Gianyar')

@section('content')
<div class="min-h-screen bg-zinc-950 py-24 md:py-32 relative overflow-hidden">
    {{-- Dekorasi Latar Belakang --}}
    <div class="absolute top-0 right-0 -translate-y-1/2 translate-x-1/4 w-96 h-96 bg-red-600/10 rounded-full blur-[120px]"></div>
    
    <div class="max-w-4xl mx-auto px-4 relative z-10">
        
        <div class="text-center mb-12">
            <h2 class="text-red-500 font-bold tracking-[0.3em] uppercase text-xs mb-3">Registration Portal</h2>
            <h1 class="text-4xl md:text-5xl font-black text-white uppercase italic tracking-tighter">
                Daftarkan <span class="text-transparent bg-clip-text bg-gradient-to-r from-red-600 to-red-400">Klub Anda</span>
            </h1>
            <p class="text-zinc-400 mt-4 max-w-lg mx-auto text-sm md:text-base font-light">
                Lengkapi formulir di bawah ini dengan data yang valid untuk ditinjau oleh tim PSSI Gianyar.
            </p>
        </div>

        @if(session('success'))
            <div class="bg-emerald-500/10 border border-emerald-500/50 text-emerald-400 p-6 rounded-xl mb-10 flex items-center gap-4 animate-bounce">
                <svg class="w-8 h-8 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <p class="font-medium">{{ session('success') }}</p>
            </div>
        @endif

        <form action="{{ route('club.store') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
            @csrf
            
            {{-- BAGIAN 1: IDENTITAS KLUB --}}
            <div class="bg-zinc-900/50 backdrop-blur-md border border-white/5 rounded-2xl p-6 md:p-10 shadow-2xl">
                <div class="flex items-center gap-3 mb-8 border-b border-white/5 pb-4">
                    <span class="flex items-center justify-center w-8 h-8 rounded-full bg-red-600 text-white text-xs font-bold shadow-[0_0_15px_rgba(220,38,38,0.5)]">01</span>
                    <h3 class="text-xl font-bold text-white uppercase tracking-tight italic">Informasi Dasar Klub</h3>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    {{-- Nama Klub --}}
                    <div class="space-y-2">
                        <label class="text-xs font-bold text-zinc-400 uppercase tracking-widest flex justify-between">
                            Nama Resmi Klub <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="name" value="{{ old('name') }}" required placeholder="Contoh: PS Gianyar Utama"
                               class="w-full bg-zinc-800/50 border border-zinc-700 rounded-lg px-4 py-3 text-white focus:outline-none focus:border-red-600 focus:ring-1 focus:ring-red-600 transition-all">
                        <p class="text-[10px] text-zinc-500 italic">Pastikan nama unik dan belum pernah terdaftar.</p>
                        @error('name') <p class="text-red-500 text-[11px] font-bold mt-1">{{ $message }}</p> @enderror
                    </div>

                    {{-- Telepon --}}
                    <div class="space-y-2">
                        <label class="text-xs font-bold text-zinc-400 uppercase tracking-widest flex justify-between">
                            Nomor WhatsApp <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="phone" value="{{ old('phone') }}" required placeholder="081234567890"
                               class="w-full bg-zinc-800/50 border border-zinc-700 rounded-lg px-4 py-3 text-white focus:outline-none focus:border-red-600 focus:ring-1 focus:ring-red-600 transition-all">
                        <p class="text-[10px] text-zinc-500 italic">Gunakan nomor aktif untuk koordinasi jadwal.</p>
                    </div>

                    {{-- Alamat --}}
                    <div class="md:col-span-2 space-y-2">
                        <label class="text-xs font-bold text-zinc-400 uppercase tracking-widest">Alamat Sekretariat</label>
                        <textarea name="address" rows="3" required placeholder="Alamat lengkap klub..."
                                  class="w-full bg-zinc-800/50 border border-zinc-700 rounded-lg px-4 py-3 text-white focus:outline-none focus:border-red-600 focus:ring-1 focus:ring-red-600 transition-all">{{ old('address') }}</textarea>
                    </div>

                    {{-- Berkas Legalitas --}}
                    <div class="md:col-span-2 space-y-2">
                        <label class="text-xs font-bold text-zinc-400 uppercase tracking-widest flex justify-between">
                            Dokumen Legalitas <span class="text-red-500">*</span>
                        </label>
                        <div class="relative group">
                            <input type="file" name="legal_document" required
                                   class="w-full bg-zinc-800/50 border border-zinc-700 rounded-lg px-4 py-2 text-zinc-400 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-xs file:font-bold file:bg-red-600 file:text-white hover:file:bg-red-700 transition-all cursor-pointer">
                        </div>
                        <p class="text-[10px] text-zinc-500 italic leading-relaxed uppercase">
                            ⚠️ Format: <span class="text-zinc-300">PDF atau ZIP</span> | Ukuran Maks: <span class="text-zinc-300">5 MB</span>. <br>
                            Lampirkan Akta Notaris atau SK Kemenkumham klub.
                        </p>
                        @error('legal_document') <p class="text-red-500 text-[11px] font-bold mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>
            </div>

            {{-- BAGIAN 2: AKUN MANAJER --}}
            <div class="bg-zinc-900/50 backdrop-blur-md border border-white/5 rounded-2xl p-6 md:p-10 shadow-2xl relative overflow-hidden">
                <div class="absolute top-0 right-0 w-24 h-24 bg-red-600/5 rounded-full blur-3xl"></div>
                
                <div class="flex items-center gap-3 mb-8 border-b border-white/5 pb-4">
                    <span class="flex items-center justify-center w-8 h-8 rounded-full bg-red-600 text-white text-xs font-bold shadow-[0_0_15px_rgba(220,38,38,0.5)]">02</span>
                    <h3 class="text-xl font-bold text-white uppercase tracking-tight italic">Akun Manajemen Klub</h3>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    {{-- Nama Manajer --}}
                    <div class="md:col-span-2 space-y-2">
                        <label class="text-xs font-bold text-zinc-400 uppercase tracking-widest">Nama Lengkap Manajer</label>
                        <input type="text" name="manager_name" value="{{ old('manager_name') }}" required placeholder="Nama asli penanggung jawab klub"
                               class="w-full bg-zinc-800/50 border border-zinc-700 rounded-lg px-4 py-3 text-white focus:outline-none focus:border-red-600 focus:ring-1 focus:ring-red-600 transition-all">
                    </div>

                    {{-- Email --}}
                    <div class="md:col-span-2 space-y-2">
                        <label class="text-xs font-bold text-zinc-400 uppercase tracking-widest">Email Login Admin</label>
                        <input type="email" name="email" value="{{ old('email') }}" required placeholder="email@gmail.com"
                               class="w-full bg-zinc-800/50 border border-zinc-700 rounded-lg px-4 py-3 text-white focus:outline-none focus:border-red-600 focus:ring-1 focus:ring-red-600 transition-all">
                        <p class="text-[10px] text-zinc-500 italic">Email ini akan digunakan untuk login ke Dashboard Manajemen Klub.</p>
                        @error('email') <p class="text-red-500 text-[11px] font-bold mt-1">{{ $message }}</p> @enderror
                    </div>

                    {{-- Password --}}
                    <div class="space-y-2">
                        <label class="text-xs font-bold text-zinc-400 uppercase tracking-widest">Kata Sandi</label>
                        <input type="password" name="password" required placeholder="••••••••"
                               class="w-full bg-zinc-800/50 border border-zinc-700 rounded-lg px-4 py-3 text-white focus:outline-none focus:border-red-600 focus:ring-1 focus:ring-red-600 transition-all">
                        <p class="text-[10px] text-zinc-500 italic">Minimal <span class="text-zinc-300">6 Karakter</span> campuran.</p>
                    </div>

                    {{-- Konfirmasi Password --}}
                    <div class="space-y-2">
                        <label class="text-xs font-bold text-zinc-400 uppercase tracking-widest">Ulangi Sandi</label>
                        <input type="password" name="password_confirmation" required placeholder="••••••••"
                               class="w-full bg-zinc-800/50 border border-zinc-700 rounded-lg px-4 py-3 text-white focus:outline-none focus:border-red-600 focus:ring-1 focus:ring-red-600 transition-all">
                        <p class="text-[10px] text-zinc-500 italic">Pastikan sandi sama dengan kolom kiri.</p>
                    </div>
                </div>
            </div>

            {{-- Tombol Aksi --}}
            <div class="flex flex-col md:flex-row gap-6 items-center justify-between pt-6">
                <div class="flex items-center gap-2">
                    <input type="checkbox" required class="w-4 h-4 accent-red-600 rounded">
                    <span class="text-[10px] md:text-xs text-zinc-500">Saya menyetujui seluruh <span class="text-red-500 underline cursor-pointer">Syarat & Ketentuan</span> pendaftaran PSSI Gianyar.</span>
                </div>
                
                <div class="flex gap-4 w-full md:w-auto">
                    <button type="submit" class="flex-1 md:flex-none px-12 py-4 bg-red-600 hover:bg-red-700 text-white font-bold uppercase tracking-widest rounded-lg shadow-[0_0_25px_rgba(220,38,38,0.4)] transition-all transform hover:scale-105 active:scale-95 text-center text-sm">
                        Proses Pendaftaran
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection