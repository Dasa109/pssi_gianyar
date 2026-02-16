<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profil - PSSI Gianyar</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        body { font-family: 'Inter', sans-serif; }
        /* Pola Bali Halus */
        .bali-pattern {
            background-color: #f8fafc;
            background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%2394a3b8' fill-opacity='0.08'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
        }
    </style>
</head>
<body class="bg-slate-50 text-slate-800 bali-pattern min-h-screen py-10 px-4">

    <div class="max-w-4xl mx-auto">
        
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
            <div>
                <h1 class="text-3xl font-black text-slate-900 tracking-tight">Pengaturan Profil</h1>
                <p class="text-slate-500 text-sm mt-1">Kelola data pribadi dan keamanan akun Anda.</p>
            </div>
            <a href="{{ route('player.dashboard') }}" class="group flex items-center gap-2 bg-white px-5 py-2.5 rounded-xl text-sm font-bold text-slate-700 shadow-sm border border-slate-200 hover:border-red-500 hover:text-red-600 transition">
                <svg class="w-4 h-4 transition group-hover:-translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Kembali ke Dashboard
            </a>
        </div>

        @if(session('success'))
        <div class="mb-6 bg-green-50 border-l-4 border-green-500 p-4 rounded-r-lg shadow-sm flex items-center gap-3 animate-pulse">
            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
            <div>
                <p class="font-bold text-green-800">Berhasil!</p>
                <p class="text-sm text-green-700">{{ session('success') }}</p>
            </div>
        </div>
        @endif

        <form action="{{ route('player.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                
                <div class="md:col-span-1">
                    <div class="bg-white rounded-2xl shadow-lg border border-slate-100 p-6 text-center h-full relative overflow-hidden">
                        <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-red-600 to-red-800"></div>

                        <h3 class="font-bold text-lg text-slate-800 mb-6">Foto Profil</h3>

                        <div x-data="{ photoName: null, photoPreview: null }">
                            <div class="relative w-40 h-40 mx-auto mb-6 group cursor-pointer" @click="$refs.photo.click()">
                                <img :src="photoPreview" x-show="photoPreview" class="w-full h-full rounded-full object-cover border-4 border-white shadow-xl ring-2 ring-slate-100" style="display: none;">
                                <img src="{{ $player->photo ? asset('storage/' . $player->photo) : 'https://ui-avatars.com/api/?name='.urlencode($player->name).'&background=random' }}" 
                                     x-show="!photoPreview" 
                                     class="w-full h-full rounded-full object-cover border-4 border-white shadow-xl ring-2 ring-slate-100">
                                
                                <div class="absolute inset-0 bg-black/40 rounded-full flex items-center justify-center opacity-0 group-hover:opacity-100 transition duration-300">
                                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                </div>
                            </div>

                            <input type="file" name="photo" x-ref="photo" class="hidden"
                                   @change="
                                       const file = $refs.photo.files[0];
                                       const reader = new FileReader();
                                       reader.onload = (e) => { photoPreview = e.target.result; };
                                       reader.readAsDataURL(file);
                                   ">

                            <button type="button" @click="$refs.photo.click()" class="bg-red-50 text-red-700 text-xs font-bold py-2 px-4 rounded-lg hover:bg-red-100 transition border border-red-100">
                                Pilih Foto Baru
                            </button>
                            <p class="text-xs text-slate-400 mt-3">Format: JPG, PNG (Max 2MB)</p>
                        </div>
                    </div>
                </div>

                <div class="md:col-span-2 space-y-6">
                    
                    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6">
                        <h3 class="font-bold text-slate-800 mb-4 flex items-center gap-2">
                            <svg class="w-5 h-5 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"></path></svg>
                            Informasi Akun
                        </h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Nama Lengkap</label>
                                <input type="text" value="{{ $player->name }}" disabled class="w-full bg-slate-50 border border-slate-200 rounded-lg px-4 py-2 text-slate-600 cursor-not-allowed">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Email Login</label>
                                <input type="text" value="{{ $player->email }}" disabled class="w-full bg-slate-50 border border-slate-200 rounded-lg px-4 py-2 text-slate-600 cursor-not-allowed">
                                <p class="text-[10px] text-red-500 mt-1">*Email hanya bisa diubah oleh Admin Klub</p>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6 relative overflow-hidden">
                        <div class="absolute top-0 right-0 w-24 h-24 bg-red-50 rounded-full -mr-10 -mt-10 blur-xl opacity-50"></div>
                        
                        <h3 class="font-bold text-slate-800 mb-4 flex items-center gap-2 relative z-10">
                            <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                            Ganti Kata Sandi
                        </h3>
                        
                        <div class="space-y-4 relative z-10">
                            <div class="p-3 bg-amber-50 border border-amber-100 rounded-lg flex gap-3">
                                <svg class="w-5 h-5 text-amber-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                <p class="text-xs text-amber-800">Kosongkan kolom di bawah jika tidak ingin mengganti password.</p>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-slate-700 mb-1">Password Baru</label>
                                <input type="password" name="password" class="w-full border border-slate-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-red-500 focus:border-red-500 outline-none transition" placeholder="Minimal 6 karakter">
                                @error('password') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-slate-700 mb-1">Konfirmasi Password Baru</label>
                                <input type="password" name="password_confirmation" class="w-full border border-slate-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-red-500 focus:border-red-500 outline-none transition" placeholder="Ulangi password baru">
                            </div>
                        </div>
                    </div>

                    <div class="flex justify-end pt-4">
                        <button type="submit" class="bg-gradient-to-r from-red-700 to-red-800 hover:from-red-800 hover:to-red-900 text-white font-bold py-3 px-8 rounded-xl shadow-lg hover:shadow-xl hover:-translate-y-0.5 transition duration-200 flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            Simpan Perubahan
                        </button>
                    </div>

                </div>
            </div>
        </form>

        <div class="mt-12 text-center">
            <p class="text-slate-400 text-xs">
                &copy; {{ date('Y') }} PSSI Kabupaten Gianyar. Keamanan data Anda adalah prioritas kami.
            </p>
        </div>

    </div>

</body>
</html>