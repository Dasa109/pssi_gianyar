@extends('layouts.app')

@section('title', 'Daftar Pemain - PSSI Gianyar')

@section('content')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

<div class="min-h-screen flex items-center justify-center bg-black py-12 px-4 sm:px-6 lg:px-8 relative overflow-hidden">
    
    <div class="absolute top-0 left-0 w-full h-full overflow-hidden z-0">
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
                Isi data diri Anda untuk bergabung ke dalam sistem.
            </p>
        </div>

        <form class="mt-8 space-y-6" action="{{ route('player.register.store') }}" method="POST" id="registerForm">
            @csrf
            
            <div class="space-y-4">
                <div class="relative">
                    <input id="name" name="name" type="text" required value="{{ old('name') }}"
                           class="peer appearance-none block w-full px-4 py-3 border {{ $errors->has('name') ? 'border-red-500' : 'border-zinc-700' }} placeholder-transparent text-white bg-black/50 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-600 focus:border-transparent sm:text-sm transition" 
                           placeholder="Nama Lengkap">
                    <label for="name" class="absolute left-4 top-3 text-zinc-500 text-xs transition-all peer-placeholder-shown:text-sm peer-placeholder-shown:text-zinc-500 peer-placeholder-shown:top-3.5 peer-focus:top-1 peer-focus:text-xs peer-focus:text-red-500">
                        Nama Lengkap (Sesuai KTP/Jersey)
                    </label>
                    @error('name') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div class="relative">
                    <input id="email" name="email" type="email" required value="{{ old('email') }}"
                           class="peer appearance-none block w-full px-4 py-3 border {{ $errors->has('email') ? 'border-red-500' : 'border-zinc-700' }} placeholder-transparent text-white bg-black/50 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-600 focus:border-transparent sm:text-sm transition" 
                           placeholder="Email">
                    <label for="email" class="absolute left-4 top-3 text-zinc-500 text-xs transition-all peer-placeholder-shown:text-sm peer-placeholder-shown:text-zinc-500 peer-placeholder-shown:top-3.5 peer-focus:top-1 peer-focus:text-xs peer-focus:text-red-500">
                        Alamat Email Aktif
                    </label>
                    @error('email') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <select name="position" class="appearance-none block w-full px-4 py-3 border border-zinc-700 text-zinc-300 bg-black/50 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-600 sm:text-sm">
                            <option value="" disabled selected>Pilih Posisi</option>
                            <option value="GK">Kiper (GK)</option>
                            <option value="DEF">Belakang (DEF)</option>
                            <option value="MID">Tengah (MID)</option>
                            <option value="FWD">Depan (FWD)</option>
                        </select>
                        @error('position') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                    </div>
                    <div class="relative">
                        <input name="club_dummy" type="text" value="{{ old('club_dummy') }}"
                               class="peer appearance-none block w-full px-4 py-3 border border-zinc-700 placeholder-transparent text-white bg-black/50 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-600 sm:text-sm" 
                               placeholder="Klub">
                        <label for="club_dummy" class="absolute left-4 top-3 text-zinc-500 text-xs transition-all peer-placeholder-shown:text-sm peer-placeholder-shown:text-zinc-500 peer-placeholder-shown:top-3.5 peer-focus:top-1 peer-focus:text-xs peer-focus:text-red-500">
                            Klub Asal (Opsional)
                        </label>
                    </div>
                </div>

                <div class="relative">
                    <input id="password" name="password" type="password" required 
                           class="peer appearance-none block w-full px-4 py-3 border {{ $errors->has('password') ? 'border-red-500' : 'border-zinc-700' }} placeholder-transparent text-white bg-black/50 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-600 focus:border-transparent sm:text-sm transition" 
                           placeholder="Password">
                    <label for="password" class="absolute left-4 top-3 text-zinc-500 text-xs transition-all peer-placeholder-shown:text-sm peer-placeholder-shown:text-zinc-500 peer-placeholder-shown:top-3.5 peer-focus:top-1 peer-focus:text-xs peer-focus:text-red-500">
                        Password (Min. 6 Karakter)
                    </label>
                    @error('password') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div class="relative">
                    <input id="password_confirmation" name="password_confirmation" type="password" required 
                           class="peer appearance-none block w-full px-4 py-3 border border-zinc-700 placeholder-transparent text-white bg-black/50 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-600 focus:border-transparent sm:text-sm transition" 
                           placeholder="Ulangi Password">
                    <label for="password_confirmation" class="absolute left-4 top-3 text-zinc-500 text-xs transition-all peer-placeholder-shown:text-sm peer-placeholder-shown:text-zinc-500 peer-placeholder-shown:top-3.5 peer-focus:top-1 peer-focus:text-xs peer-focus:text-red-500">
                        Konfirmasi Password
                    </label>
                </div>
            </div>

            <div>
                <button type="submit" id="btnSubmit" class="group relative w-full flex justify-center py-3 px-4 border border-transparent text-sm font-bold uppercase tracking-widest rounded-lg text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition duration-300 shadow-[0_0_20px_rgba(220,38,38,0.4)] hover:shadow-[0_0_30px_rgba(220,38,38,0.6)]">
                    <span class="absolute left-0 inset-y-0 flex items-center pl-3">
                        <svg class="h-5 w-5 text-red-300 group-hover:text-red-100" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd" />
                        </svg>
                    </span>
                    <span id="btnText">Daftar Sekarang</span>
                </button>
            </div>

            <div class="text-center mt-4">
                <p class="text-sm text-zinc-400">
                    Sudah punya akun? 
                    <a href="{{ route('player.login') }}" class="font-medium text-red-500 hover:text-red-400 underline">
                        Login disini
                    </a>
                </p>
            </div>
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    // 1. Loading State saat Submit
    const form = document.getElementById('registerForm');
    const btnSubmit = document.getElementById('btnSubmit');
    const btnText = document.getElementById('btnText');

    form.addEventListener('submit', function() {
        btnSubmit.disabled = true;
        btnSubmit.classList.add('opacity-75', 'cursor-not-allowed');
        btnText.innerHTML = '<svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white inline" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg> Memproses...';
    });

    // 2. SweetAlert jika ada Error dari Controller (Server Side)
    @if ($errors->any())
        Swal.fire({
            icon: 'error',
            title: 'Gagal Daftar!',
            text: 'Periksa kembali isian form Anda.',
            background: '#18181b', // Zinc-900
            color: '#fff',
            confirmButtonColor: '#dc2626' // Red-600
        });
    @endif
</script>
@endsection