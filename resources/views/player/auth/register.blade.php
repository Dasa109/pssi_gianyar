@extends('layouts.app')

@section('title', 'Daftar Pemain - PSSI Gianyar')

@section('content')
{{-- Load SweetAlert CSS --}}
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

<div class="min-h-screen flex items-center justify-center bg-black py-12 px-4 sm:px-6 lg:px-8 relative overflow-hidden">
    
    {{-- Background Effects --}}
    <div class="absolute top-0 left-0 w-full h-full overflow-hidden z-0 pointer-events-none">
        <div class="absolute top-[-10%] right-[-5%] w-96 h-96 bg-red-600/20 rounded-full blur-3xl animate-pulse"></div>
        <div class="absolute bottom-[-10%] left-[-5%] w-72 h-72 bg-zinc-800/30 rounded-full blur-3xl"></div>
    </div>

    <div class="max-w-md w-full space-y-8 relative z-10 bg-zinc-900/80 backdrop-blur-xl p-8 rounded-2xl border border-white/10 shadow-2xl">
        
        <div class="text-center">
            <div class="mx-auto h-12 w-12 bg-red-600 -skew-x-12 flex items-center justify-center shadow-[0_0_15px_rgba(220,38,38,0.5)] mb-4 transform hover:rotate-12 transition">
                <span class="text-white font-heading font-bold text-xl skew-x-12">PG</span>
            </div>
            <h2 class="mt-2 text-3xl font-heading font-bold text-white uppercase tracking-wide">
                Registrasi <span class="text-red-600">Pemain</span>
            </h2>
            <p class="mt-2 text-sm text-zinc-400">
                Bergabunglah dengan database resmi PSSI Gianyar.
            </p>
        </div>

        <form class="mt-8 space-y-6" action="{{ route('player.register.store') }}" method="POST" id="registerForm">
            @csrf
            
            <div class="space-y-4">
                
                {{-- Input Nama --}}
                <div class="relative">
                    <input id="name" name="name" type="text" required value="{{ old('name') }}"
                           class="peer appearance-none block w-full px-4 py-3 border {{ $errors->has('name') ? 'border-red-500' : 'border-zinc-700' }} placeholder-transparent text-white bg-black/50 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-600 focus:border-transparent sm:text-sm transition" 
                           placeholder="Nama Lengkap">
                    <label for="name" class="absolute left-4 top-3 text-zinc-500 text-xs transition-all peer-placeholder-shown:text-sm peer-placeholder-shown:text-zinc-500 peer-placeholder-shown:top-3.5 peer-focus:top-1 peer-focus:text-xs peer-focus:text-red-500">
                        Nama Lengkap (Sesuai KTP)
                    </label>
                    @error('name') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                </div>

                {{-- Input Email --}}
                <div class="relative">
                    <input id="email" name="email" type="email" required value="{{ old('email') }}"
                           class="peer appearance-none block w-full px-4 py-3 border {{ $errors->has('email') ? 'border-red-500' : 'border-zinc-700' }} placeholder-transparent text-white bg-black/50 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-600 focus:border-transparent sm:text-sm transition" 
                           placeholder="Email">
                    <label for="email" class="absolute left-4 top-3 text-zinc-500 text-xs transition-all peer-placeholder-shown:text-sm peer-placeholder-shown:text-zinc-500 peer-placeholder-shown:top-3.5 peer-focus:top-1 peer-focus:text-xs peer-focus:text-red-500">
                        Alamat Email Aktif
                    </label>
                    @error('email') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                </div>

                {{-- Grid: Posisi & Klub --}}
                <div class="grid grid-cols-1 gap-4">
                    {{-- Select Posisi --}}
                    <div>
                        <select name="position" class="appearance-none block w-full px-4 py-3 border border-zinc-700 text-zinc-300 bg-black/50 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-600 sm:text-sm">
                            <option value="" disabled selected>-- Pilih Posisi Bermain --</option>
                            <option value="GK" {{ old('position') == 'GK' ? 'selected' : '' }}>Kiper (GK)</option>
                            <option value="DEF" {{ old('position') == 'DEF' ? 'selected' : '' }}>Belakang (DEF)</option>
                            <option value="MID" {{ old('position') == 'MID' ? 'selected' : '' }}>Tengah (MID)</option>
                            <option value="FWD" {{ old('position') == 'FWD' ? 'selected' : '' }}>Depan (FWD)</option>
                        </select>
                        @error('position') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    {{-- LOGIKA PILIH KLUB / MANUAL --}}
                    <div class="space-y-3 p-3 bg-zinc-800/30 rounded-lg border border-zinc-700/50">
                        <label class="block text-xs text-zinc-500 mb-1 uppercase tracking-widest font-bold">Afiliasi Klub</label>
                        
                        {{-- Dropdown Klub --}}
                        <div class="relative">
                            <select name="club_id" id="club_id" onchange="toggleManualInput(this)"
                                    class="appearance-none block w-full px-4 py-3 border border-zinc-600 text-white bg-zinc-900 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-600 sm:text-sm">
                                <option value="" selected>-- Pilih Klub Tujuan --</option>
                                
                                @if(isset($clubs) && count($clubs) > 0)
                                    @foreach($clubs as $club)
                                        <option value="{{ $club->id }}" {{ old('club_id') == $club->id ? 'selected' : '' }}>
                                            {{ $club->name }}
                                        </option>
                                    @endforeach
                                @endif
                                
                                <option value="manual" class="font-bold text-red-400 bg-zinc-800">
                                    + Klub Tidak Ditemukan / Input Manual
                                </option>
                            </select>
                            
                            {{-- Panah Icon --}}
                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-zinc-400">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                            </div>
                        </div>

                        {{-- Input Manual (Hidden by default) --}}
                        <div id="manual_club_wrapper" class="hidden animate-fade-in-down">
                            <div class="relative mt-2">
                                <input name="club_dummy" id="club_dummy" type="text" value="{{ old('club_dummy') }}"
                                       class="peer appearance-none block w-full px-4 py-3 border border-red-500/50 placeholder-transparent text-white bg-black/50 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-600 sm:text-sm" 
                                       placeholder="Nama Klub">
                                <label for="club_dummy" class="absolute left-4 top-3 text-red-400 text-xs transition-all peer-placeholder-shown:text-sm peer-placeholder-shown:text-zinc-500 peer-placeholder-shown:top-3.5 peer-focus:top-1 peer-focus:text-xs peer-focus:text-red-500">
                                    Ketik Nama Klub Anda Disini
                                </label>
                            </div>
                            <p class="text-[10px] text-zinc-500 mt-1 italic">*Admin akan memverifikasi klub ini nanti.</p>
                        </div>
                        
                        @error('club_id') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                    </div>
                </div>

                {{-- Input Password --}}
                <div class="relative">
                    <input id="password" name="password" type="password" required 
                           class="peer appearance-none block w-full px-4 py-3 border {{ $errors->has('password') ? 'border-red-500' : 'border-zinc-700' }} placeholder-transparent text-white bg-black/50 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-600 focus:border-transparent sm:text-sm transition" 
                           placeholder="Password">
                    <label for="password" class="absolute left-4 top-3 text-zinc-500 text-xs transition-all peer-placeholder-shown:text-sm peer-placeholder-shown:text-zinc-500 peer-placeholder-shown:top-3.5 peer-focus:top-1 peer-focus:text-xs peer-focus:text-red-500">
                        Password (Min. 6 Karakter)
                    </label>
                    @error('password') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                </div>

                {{-- Input Konfirmasi Password --}}
                <div class="relative">
                    <input id="password_confirmation" name="password_confirmation" type="password" required 
                           class="peer appearance-none block w-full px-4 py-3 border border-zinc-700 placeholder-transparent text-white bg-black/50 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-600 focus:border-transparent sm:text-sm transition" 
                           placeholder="Ulangi Password">
                    <label for="password_confirmation" class="absolute left-4 top-3 text-zinc-500 text-xs transition-all peer-placeholder-shown:text-sm peer-placeholder-shown:text-zinc-500 peer-placeholder-shown:top-3.5 peer-focus:top-1 peer-focus:text-xs peer-focus:text-red-500">
                        Konfirmasi Password
                    </label>
                </div>

            </div>

            {{-- Tombol Submit --}}
            <div>
                <button type="submit" id="btnSubmit" class="group relative w-full flex justify-center py-3 px-4 border border-transparent text-sm font-bold uppercase tracking-widest rounded-lg text-white bg-gradient-to-r from-red-600 to-red-800 hover:from-red-500 hover:to-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition duration-300 shadow-lg transform hover:-translate-y-0.5">
                    <span class="absolute left-0 inset-y-0 flex items-center pl-3">
                        <svg class="h-5 w-5 text-red-300 group-hover:text-white transition" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd" />
                        </svg>
                    </span>
                    <span id="btnText">Daftar Sekarang</span>
                </button>
            </div>

            <div class="text-center mt-4">
                <p class="text-sm text-zinc-400">
                    Sudah punya akun? 
                    <a href="{{ route('player.login') }}" class="font-bold text-red-500 hover:text-red-400 transition underline decoration-red-500/30 hover:decoration-red-500">
                        Login disini
                    </a>
                </p>
            </div>
        </form>
    </div>
</div>

{{-- Scripts --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    // 1. Logika Toggle Input Manual vs Select
    function toggleManualInput(selectObject) {
        var value = selectObject.value;
        var manualWrapper = document.getElementById('manual_club_wrapper');
        var manualInput = document.getElementById('club_dummy');

        if (value === 'manual') {
            // Tampilkan input manual
            manualWrapper.classList.remove('hidden');
            manualInput.required = true;
            manualInput.focus();
        } else {
            // Sembunyikan input manual
            manualWrapper.classList.add('hidden');
            manualInput.value = ''; // Bersihkan nilai agar tidak terkirim sampah
            manualInput.required = false;
        }
    }

    // 2. Loading State saat Submit
    const form = document.getElementById('registerForm');
    const btnSubmit = document.getElementById('btnSubmit');
    const btnText = document.getElementById('btnText');

    form.addEventListener('submit', function() {
        btnSubmit.disabled = true;
        btnSubmit.classList.add('opacity-75', 'cursor-not-allowed');
        btnText.innerHTML = '<svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white inline" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg> Memproses...';
    });

    // 3. SweetAlert Error Handling (Server Side)
    @if ($errors->any())
        Swal.fire({
            icon: 'error',
            title: 'Gagal Daftar!',
            html: '<ul class="text-left text-sm text-zinc-300 list-disc pl-5">@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>',
            background: '#18181b',
            color: '#fff',
            confirmButtonColor: '#dc2626'
        });
    @endif
</script>
@endsection