<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profil - {{ $player->name }}</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        body { font-family: 'Inter', sans-serif; }
        .glass-effect {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
        }
        .bali-pattern {
            background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%239C92AC' fill-opacity='0.05'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
        }
    </style>
</head>
<body class="bg-slate-50 text-slate-800 bali-pattern min-h-screen flex flex-col">

    {{-- NAVBAR --}}
    <nav class="sticky top-0 z-50 glass-effect border-b border-red-100 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center gap-3">
                    <a href="{{ route('player.dashboard') }}" class="flex items-center gap-3 group">
                        <div class="bg-red-700 text-white p-1.5 rounded-lg shadow-md group-hover:bg-red-800 transition">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                        </div>
                        <div>
                            <span class="block font-bold text-lg leading-none text-slate-900 tracking-tight">KEMBALI KE <span class="text-red-700">DASHBOARD</span></span>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </nav>

    {{-- CONTENT --}}
    <main class="flex-grow max-w-4xl mx-auto w-full px-4 py-8">
        
        <div class="bg-white rounded-2xl shadow-xl border border-slate-200 overflow-hidden relative">
            {{-- Header Card --}}
            <div class="bg-slate-900 h-32 relative overflow-hidden">
                <div class="absolute inset-0 opacity-20" style="background-image: radial-gradient(#ffffff 1px, transparent 1px); background-size: 20px 20px;"></div>
                <div class="absolute -right-10 -top-10 w-40 h-40 bg-red-600 rounded-full blur-3xl opacity-50"></div>
                <div class="absolute left-6 bottom-6 text-white z-10">
                    <h1 class="text-2xl font-bold flex items-center gap-2">
                        <svg class="w-6 h-6 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                        Edit Biodata Pemain
                    </h1>
                    <p class="text-xs text-slate-400">Perbarui informasi terbaru Anda untuk musim kompetisi ini.</p>
                </div>
            </div>

            <form action="{{ route('player.update') }}" method="POST" enctype="multipart/form-data" class="p-8">
                @csrf
                @method('PUT')

                {{-- Foto Profil --}}
                <div class="flex items-center gap-6 mb-8 -mt-16 relative z-20">
                    <div class="relative group">
                        <img id="preview_photo" 
                             src="{{ $player->photo ? asset('storage/' . $player->photo) : 'https://ui-avatars.com/api/?name='.urlencode($player->name).'&background=random' }}" 
                             class="w-32 h-32 rounded-2xl object-cover border-4 border-white shadow-lg bg-white">
                        
                        <label for="photo" class="absolute bottom-[-10px] right-[-10px] bg-slate-900 text-white p-2 rounded-full cursor-pointer hover:bg-red-600 transition shadow-md" title="Ganti Foto">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            <input type="file" name="photo" id="photo" class="hidden" onchange="loadFile(event)">
                        </label>
                    </div>
                    <div class="pt-10">
                        <p class="text-sm font-bold text-slate-700">Foto Profil</p>
                        <p class="text-xs text-slate-500">Gunakan foto formal/jersey. Max 2MB.</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    
                    {{-- Nama --}}
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Nama Lengkap</label>
                        <input type="text" name="name" value="{{ old('name', $player->name) }}" class="w-full px-4 py-3 rounded-lg border border-slate-200 focus:border-red-500 focus:ring-2 focus:ring-red-200 transition bg-slate-50 focus:bg-white text-slate-800 font-medium">
                        @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    {{-- Posisi --}}
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Posisi</label>
                        <div class="relative">
                            <select name="position" class="w-full px-4 py-3 rounded-lg border border-slate-200 focus:border-red-500 focus:ring-2 focus:ring-red-200 transition bg-slate-50 focus:bg-white text-slate-800 font-medium appearance-none">
                                <option value="GK" {{ $player->position == 'GK' ? 'selected' : '' }}>Kiper (GK)</option>
                                <option value="DEF" {{ $player->position == 'DEF' ? 'selected' : '' }}>Belakang (DEF)</option>
                                <option value="MID" {{ $player->position == 'MID' ? 'selected' : '' }}>Tengah (MID)</option>
                                <option value="FWD" {{ $player->position == 'FWD' ? 'selected' : '' }}>Depan (FWD)</option>
                            </select>
                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-slate-500">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                            </div>
                        </div>
                    </div>

                    {{-- Klub Manual (Jika belum punya klub resmi) --}}
                    @if(!$player->club_id)
                    <div class="md:col-span-2">
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Klub Asal (Manual)</label>
                        <input type="text" name="club_dummy" value="{{ old('club_dummy', $player->club_dummy) }}" class="w-full px-4 py-3 rounded-lg border border-slate-200 focus:border-red-500 focus:ring-2 focus:ring-red-200 transition bg-slate-50 focus:bg-white text-slate-800 font-medium">
                        <p class="text-[10px] text-slate-400 mt-1 italic">*Anda belum terdaftar di klub resmi manapun. Isi nama klub Anda saat ini.</p>
                    </div>
                    @else
                    <div class="md:col-span-2">
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Klub Resmi</label>
                        <div class="w-full px-4 py-3 rounded-lg border border-red-100 bg-red-50 text-red-800 font-bold flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            {{ $player->club->name }}
                        </div>
                        <p class="text-[10px] text-slate-400 mt-1 italic">*Hubungi Admin Klub untuk pindah tim.</p>
                    </div>
                    @endif

                </div>

                <div class="mt-8 border-t border-slate-100 pt-6">
                    <div x-data="{ changePassword: false }">
                        <button type="button" @click="changePassword = !changePassword" class="text-sm font-bold text-slate-500 hover:text-red-600 flex items-center gap-2 transition">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                            <span x-text="changePassword ? 'Batalkan Ganti Password' : 'Ganti Password (Opsional)'"></span>
                        </button>

                        <div x-show="changePassword" x-transition class="mt-4 bg-slate-50 p-5 rounded-xl border border-slate-200 grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-bold text-slate-500 mb-1">Password Baru</label>
                                <input type="password" name="password" class="w-full px-3 py-2 rounded-lg border border-slate-300 focus:border-red-500">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-500 mb-1">Konfirmasi Password</label>
                                <input type="password" name="password_confirmation" class="w-full px-3 py-2 rounded-lg border border-slate-300 focus:border-red-500">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-8 flex justify-end">
                    <button type="submit" class="bg-red-700 hover:bg-red-800 text-white font-bold py-3 px-8 rounded-xl shadow-lg shadow-red-700/30 transition transform hover:-translate-y-1 flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path></svg>
                        SIMPAN PERUBAHAN
                    </button>
                </div>

            </form>
        </div>
    </main>

    {{-- SCRIPT: PREVIEW FOTO & SWEETALERT --}}
    <script>
        var loadFile = function(event) {
            var output = document.getElementById('preview_photo');
            output.src = URL.createObjectURL(event.target.files[0]);
            output.onload = function() { URL.revokeObjectURL(output.src) }
        };

        // SWAL SUCCESS
        @if(session('success'))
            Swal.fire({
                title: 'Berhasil!',
                text: "{{ session('success') }}",
                icon: 'success',
                confirmButtonColor: '#b91c1c',
                confirmButtonText: 'Mantap!',
                background: '#fff',
                color: '#1e293b'
            });
        @endif

        // SWAL ERROR
        @if($errors->any())
            Swal.fire({
                title: 'Gagal Menyimpan',
                html: '<ul class="text-left text-sm list-disc pl-5">@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>',
                icon: 'error',
                confirmButtonColor: '#b91c1c'
            });
        @endif
    </script>
</body>
</html>