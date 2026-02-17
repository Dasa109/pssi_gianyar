@extends('layouts.app')

@section('title', 'Login Pemain - PSSI Gianyar')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-black py-12 px-4 sm:px-6 lg:px-8 relative overflow-hidden">
    
    <div class="absolute top-0 left-0 w-full h-full overflow-hidden z-0">
        <div class="absolute top-[-10%] left-[-5%] w-96 h-96 bg-red-900/20 rounded-full blur-3xl animate-pulse"></div>
        <div class="absolute bottom-[-10%] right-[-5%] w-72 h-72 bg-zinc-800/30 rounded-full blur-3xl"></div>
    </div>

    <div class="max-w-md w-full space-y-8 relative z-10 bg-zinc-900/80 backdrop-blur-xl p-8 rounded-2xl border border-white/10 shadow-[0_0_50px_rgba(0,0,0,0.5)]">
        
        <div class="text-center">
            <div class="mx-auto h-16 w-16 bg-gradient-to-br from-red-600 to-red-800 -skew-x-12 flex items-center justify-center shadow-[0_0_15px_rgba(220,38,38,0.5)] mb-6 transform hover:scale-110 transition duration-300">
                <span class="text-white font-heading font-bold text-2xl skew-x-12">PG</span>
            </div>
            <h2 class="mt-2 text-3xl font-heading font-bold text-white uppercase tracking-wide">
                Portal <span class="text-red-600">Pemain</span>
            </h2>
            <p class="mt-2 text-sm text-zinc-400">
                Silakan login untuk mengakses dashboard Anda.
            </p>
        </div>

        @if ($errors->any())
            <div class="bg-red-900/30 border border-red-600/50 text-red-200 px-4 py-3 rounded-lg relative text-sm" role="alert">
                <strong class="font-bold">Whoops!</strong>
                <span class="block sm:inline">Kombinasi email atau password salah.</span>
            </div>
        @endif

        @if (session('success'))
            <div class="bg-green-900/30 border border-green-600/50 text-green-200 px-4 py-3 rounded-lg relative text-sm" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif

        <form class="mt-8 space-y-6" action="{{ route('player.login.submit') }}" method="POST">
            @csrf
            
            <div class="space-y-4">
                <div class="relative group">
                    <label for="email" class="sr-only">Alamat Email</label>
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-zinc-500 group-focus-within:text-red-500 transition" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" />
                        </svg>
                    </div>
                    <input id="email" name="email" type="email" autocomplete="email" required 
                           class="appearance-none block w-full pl-10 pr-3 py-3 border border-zinc-700 placeholder-zinc-500 text-white bg-black/50 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-600 focus:border-transparent sm:text-sm transition duration-200" 
                           placeholder="Alamat Email"
                           value="{{ old('email') }}">
                </div>

                <div class="relative group">
                    <label for="password" class="sr-only">Password</label>
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-zinc-500 group-focus-within:text-red-500 transition" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                        </svg>
                    </div>
                    <input id="password" name="password" type="password" autocomplete="current-password" required 
                           class="appearance-none block w-full pl-10 pr-3 py-3 border border-zinc-700 placeholder-zinc-500 text-white bg-black/50 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-600 focus:border-transparent sm:text-sm transition duration-200" 
                           placeholder="Password">
                </div>
            </div>

            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <input id="remember-me" name="remember" type="checkbox" class="h-4 w-4 text-red-600 focus:ring-red-500 border-zinc-700 rounded bg-zinc-800">
                    <label for="remember-me" class="ml-2 block text-sm text-zinc-400">
                        Ingat Saya
                    </label>
                </div>

                <div class="text-sm">
                    <a href="#" class="font-medium text-red-500 hover:text-red-400 transition">
                        Lupa password?
                    </a>
                </div>
            </div>

            <div>
                <button type="submit" class="group relative w-full flex justify-center py-3 px-4 border border-transparent text-sm font-bold uppercase tracking-widest rounded-lg text-white bg-gradient-to-r from-red-700 to-red-600 hover:from-red-600 hover:to-red-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition duration-300 shadow-[0_0_20px_rgba(220,38,38,0.4)] hover:shadow-[0_0_30px_rgba(220,38,38,0.6)] transform hover:-translate-y-0.5">
                    <span class="absolute left-0 inset-y-0 flex items-center pl-3">
                        <svg class="h-5 w-5 text-red-300 group-hover:text-white transition" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd" d="M3 3a1 1 0 011 1v12a1 1 0 11-2 0V4a1 1 0 011-1zm7.707 3.293a1 1 0 010 1.414L9.414 9H17a1 1 0 110 2H9.414l1.293 1.293a1 1 0 01-1.414 1.414l-3-3a1 1 0 010-1.414l3-3a1 1 0 011.414 0z" clip-rule="evenodd" />
                        </svg>
                    </span>
                    Masuk Sekarang
                </button>
            </div>

            <div class="text-center mt-6">
                <p class="text-sm text-zinc-400">
                    Belum punya akun pemain? 
                    <a href="{{ route('player.register') }}" class="font-bold text-red-500 hover:text-red-400 transition underline decoration-red-500/30 hover:decoration-red-500">
                        Daftar Disini
                    </a>
                </p>
            </div>
        </form>
    </div>

    <div class="absolute bottom-4 text-center w-full text-xs text-zinc-600">
        &copy; {{ date('Y') }} PSSI Kabupaten Gianyar.
    </div>
</div>
@endsection