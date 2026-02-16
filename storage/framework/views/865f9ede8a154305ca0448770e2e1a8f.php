<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Pemain - <?php echo e($player->name); ?></title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        body { font-family: 'Inter', sans-serif; }
        .glass-effect {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
        }
        /* Pola Halus ala Ukiran Bali */
        .bali-pattern {
            background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%239C92AC' fill-opacity='0.05'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
        }
    </style>
</head>
<body class="bg-slate-50 text-slate-800 bali-pattern">

    <nav class="sticky top-0 z-50 glass-effect border-b border-red-100 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center gap-3">
                    <div class="bg-red-700 text-white p-1.5 rounded-lg shadow-md">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <div>
                        <span class="block font-bold text-lg leading-none text-slate-900 tracking-tight">PSSI <span class="text-red-700">GIANYAR</span></span>
                        <span class="text-[10px] text-slate-500 font-medium tracking-wide uppercase">Sistem Data Pemain</span>
                    </div>
                </div>

                <div class="flex items-center" x-data="{ open: false }">
                    <button @click="open = !open" class="flex items-center gap-2 focus:outline-none group">
                        <div class="hidden md:flex flex-col items-end mr-1">
                            <span class="text-sm font-bold text-slate-700 group-hover:text-red-700 transition"><?php echo e($player->name); ?></span>
                            <span class="text-xs text-slate-500">Pemain Aktif</span>
                        </div>
                        <img src="<?php echo e($player->photo ? asset('storage/' . $player->photo) : 'https://ui-avatars.com/api/?name='.urlencode($player->name).'&background=random'); ?>" 
                             class="h-10 w-10 rounded-full object-cover border-2 border-red-100 shadow-sm group-hover:border-red-300 transition">
                    </button>

                    <div x-show="open" @click.away="open = false" 
                         class="absolute right-4 top-16 w-56 bg-white rounded-xl shadow-xl py-2 border border-slate-100 ring-1 ring-black ring-opacity-5" 
                         style="display: none;"
                         x-transition:enter="transition ease-out duration-100"
                         x-transition:enter-start="transform opacity-0 scale-95"
                         x-transition:enter-end="transform opacity-100 scale-100">
                        <div class="px-4 py-3 border-b border-slate-50">
                            <p class="text-xs text-slate-400 uppercase tracking-wider font-semibold">Login Account</p>
                            <p class="text-sm font-bold text-slate-800 truncate"><?php echo e($player->email); ?></p>
                        </div>
                        
                        <a href="<?php echo e(route('player.edit')); ?>" class="block px-4 py-2 text-sm text-slate-700 hover:bg-slate-50 hover:text-red-700 transition">
                            Edit Profil Saya
                        </a>

                        <form action="<?php echo e(route('player.logout')); ?>" method="POST">
                            <?php echo csrf_field(); ?>
                            <button type="submit" class="w-full text-left px-4 py-3 text-sm text-red-600 hover:bg-red-50 flex items-center gap-2 font-medium transition border-t border-slate-50">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                                Keluar Aplikasi
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(session('success')): ?>
        <div class="mb-6 bg-green-50 border-l-4 border-green-500 p-4 rounded-r-lg shadow-sm flex items-center gap-3 animate-fade-in-down">
            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
            <div>
                <p class="font-bold text-green-800">Berhasil!</p>
                <p class="text-sm text-green-700"><?php echo e(session('success')); ?></p>
            </div>
        </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

        <div class="relative bg-white rounded-2xl shadow-lg overflow-hidden mb-8 border border-slate-200 group">
            <div class="h-40 bg-gradient-to-r from-red-800 via-slate-900 to-black relative overflow-hidden">
                <div class="absolute inset-0 opacity-10" style="background-image: url('data:image/svg+xml,%3Csvg width=\'20\' height=\'20\' viewBox=\'0 0 20 20\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cg fill=\'%23ffffff\' fill-opacity=\'1\' fill-rule=\'evenodd\'%3E%3Ccircle cx=\'3\' cy=\'3\' r=\'3\'/%3E%3Ccircle cx=\'13\' cy=\'13\' r=\'3\'/%3E%3C/g%3E%3C/svg%3E');"></div>
                <div class="absolute -right-10 -top-10 w-64 h-64 bg-red-600 rounded-full mix-blend-multiply filter blur-3xl opacity-50 animate-pulse"></div>
            </div>
            
            <div class="px-6 pb-6">
                <div class="flex flex-col md:flex-row items-center md:items-end -mt-16 mb-2 gap-6">
                    <div class="relative">
                        <div class="rounded-2xl p-1 bg-white shadow-xl">
                            <img src="<?php echo e($player->photo ? asset('storage/' . $player->photo) : 'https://ui-avatars.com/api/?name='.urlencode($player->name).'&size=128'); ?>" 
                                 class="w-36 h-36 rounded-xl object-cover bg-slate-100">
                        </div>
                        <div class="absolute bottom-3 right-3 bg-green-500 w-5 h-5 rounded-full border-4 border-white shadow-sm" title="Status: Aktif"></div>
                    </div>

                    <div class="flex-1 text-center md:text-left mb-2">
                        <h1 class="text-3xl md:text-4xl font-black text-slate-900 tracking-tight"><?php echo e($player->name); ?></h1>
                        
                        <div class="flex flex-wrap justify-center md:justify-start gap-3 mt-3 text-sm">
                            <span class="flex items-center gap-1.5 bg-slate-900 text-amber-400 px-3 py-1.5 rounded-lg font-bold shadow-sm">
                                <span class="text-slate-400 font-normal">No.</span> <?php echo e($player->number); ?>

                            </span>
                            
                            <span class="flex items-center gap-1.5 bg-slate-100 text-slate-700 px-3 py-1.5 rounded-lg font-semibold border border-slate-200">
                                ⚽ <?php echo e($player->position); ?>

                            </span>

                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($player->club): ?>
                            <span class="flex items-center gap-1.5 bg-red-50 text-red-700 px-3 py-1.5 rounded-lg font-bold border border-red-100">
                                🛡️ <?php echo e($player->club->name); ?>

                            </span>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($player->is_captain): ?>
                            <span class="flex items-center gap-1.5 bg-amber-100 text-amber-800 px-3 py-1.5 rounded-lg font-bold border border-amber-200">
                                © Captain
                            </span>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>
                    </div>

                    <div class="flex gap-2 mt-4 md:mt-0">
                        <a href="<?php echo e(route('player.edit')); ?>" class="bg-slate-900 hover:bg-slate-800 text-white px-5 py-2.5 rounded-lg text-sm font-medium transition shadow-lg flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                            Edit Biodata
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <div class="lg:col-span-2 space-y-8">
                
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    <div class="bg-white p-5 rounded-xl border border-slate-200 shadow-sm hover:shadow-md transition group">
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-slate-400 text-[10px] font-bold uppercase tracking-widest">Gol</span>
                            <div class="w-8 h-8 rounded-full bg-red-50 flex items-center justify-center text-red-600 group-hover:bg-red-600 group-hover:text-white transition">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                            </div>
                        </div>
                        <span class="text-3xl font-black text-slate-800">0</span>
                        <div class="w-full bg-slate-100 h-1.5 mt-3 rounded-full overflow-hidden">
                            <div class="bg-red-600 h-1.5 rounded-full" style="width: 10%"></div>
                        </div>
                    </div>

                    <div class="bg-white p-5 rounded-xl border border-slate-200 shadow-sm hover:shadow-md transition group">
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-slate-400 text-[10px] font-bold uppercase tracking-widest">Assist</span>
                            <div class="w-8 h-8 rounded-full bg-amber-50 flex items-center justify-center text-amber-600 group-hover:bg-amber-500 group-hover:text-white transition">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path></svg>
                            </div>
                        </div>
                        <span class="text-3xl font-black text-slate-800">0</span>
                        <div class="w-full bg-slate-100 h-1.5 mt-3 rounded-full overflow-hidden">
                            <div class="bg-amber-500 h-1.5 rounded-full" style="width: 0%"></div>
                        </div>
                    </div>

                    <div class="bg-white p-5 rounded-xl border border-slate-200 shadow-sm hover:shadow-md transition group">
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-slate-400 text-[10px] font-bold uppercase tracking-widest">Main</span>
                            <div class="w-8 h-8 rounded-full bg-blue-50 flex items-center justify-center text-blue-600 group-hover:bg-blue-600 group-hover:text-white transition">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </div>
                        </div>
                        <span class="text-3xl font-black text-slate-800">0<span class="text-sm text-slate-400 font-medium ml-1">mnt</span></span>
                        <div class="w-full bg-slate-100 h-1.5 mt-3 rounded-full overflow-hidden">
                            <div class="bg-blue-600 h-1.5 rounded-full" style="width: 0%"></div>
                        </div>
                    </div>

                    <div class="bg-white p-5 rounded-xl border border-slate-200 shadow-sm hover:shadow-md transition group">
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-slate-400 text-[10px] font-bold uppercase tracking-widest">Kartu</span>
                            <div class="w-8 h-8 rounded-full bg-slate-50 flex items-center justify-center text-slate-600 group-hover:bg-slate-800 group-hover:text-white transition">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path></svg>
                            </div>
                        </div>
                        <span class="text-3xl font-black text-slate-800">0</span>
                        <div class="w-full bg-slate-100 h-1.5 mt-3 rounded-full overflow-hidden">
                            <div class="bg-yellow-400 h-1.5 rounded-full" style="width: 0%"></div>
                        </div>
                    </div>
                </div>

                <div class="bg-slate-900 rounded-2xl shadow-xl p-6 text-white relative overflow-hidden border-t-4 border-red-700">
                    <div class="absolute inset-0 opacity-20" style="background-image: radial-gradient(#475569 1px, transparent 1px); background-size: 20px 20px;"></div>
                    
                    <div class="relative z-10 flex items-center justify-between mb-6 border-b border-slate-700 pb-4">
                        <h3 class="font-bold text-lg flex items-center gap-2">
                            <span class="w-2 h-2 rounded-full bg-red-500 animate-pulse"></span>
                            Pertandingan Berikutnya
                        </h3>
                        <span class="bg-gradient-to-r from-amber-500 to-yellow-400 text-black px-3 py-1 rounded-full text-xs font-bold shadow-lg">LIGA GIANYAR</span>
                    </div>

                    <div class="relative z-10 flex items-center justify-between">
                        <div class="text-center w-1/3 group cursor-default">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($player->club && $player->club->logo): ?>
                                <img src="<?php echo e(asset('storage/'.$player->club->logo)); ?>" class="w-20 h-20 mx-auto bg-white rounded-full p-1 shadow-lg group-hover:scale-110 transition">
                            <?php else: ?>
                                <div class="w-20 h-20 mx-auto bg-slate-800 rounded-full flex items-center justify-center text-3xl border-2 border-slate-600 group-hover:border-red-500 transition">🛡️</div>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            <p class="mt-3 font-bold text-lg tracking-wide"><?php echo e($player->club->short_name ?? 'TIM SAYA'); ?></p>
                        </div>

                        <div class="text-center w-1/3">
                            <div class="text-4xl font-black text-slate-700 select-none">VS</div>
                            <div class="bg-red-700 text-white text-xs px-4 py-1.5 rounded-full inline-block font-bold mt-2 shadow-lg tracking-wide">
                                12 AGT • 15:30
                            </div>
                            <p class="text-xs text-slate-400 mt-2 font-medium flex items-center justify-center gap-1">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                Stadion Dipta
                            </p>
                        </div>

                        <div class="text-center w-1/3">
                            <div class="w-20 h-20 mx-auto bg-white/5 rounded-full flex items-center justify-center text-3xl border-2 border-slate-600 border-dashed animate-pulse">?</div>
                            <p class="mt-3 font-bold text-slate-500">LAWAN</p>
                        </div>
                    </div>
                </div>

            </div>

            <div class="space-y-8">
                
                <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
                    <h3 class="font-bold text-slate-800 mb-4 flex items-center gap-2 border-b border-slate-100 pb-3">
                        <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        Riwayat Pertandingan
                    </h3>
                    
                    <div class="space-y-4">
                        <div class="flex items-center justify-between group cursor-pointer">
                            <div class="flex items-center gap-3">
                                <div class="w-1.5 h-1.5 rounded-full bg-green-500 shadow-sm shadow-green-500/50"></div>
                                <div>
                                    <p class="text-sm font-bold text-slate-800 group-hover:text-red-700 transition">vs PS Gianyar</p>
                                    <p class="text-[10px] text-slate-500 font-medium">Stadion Dipta • Menang 2-1</p>
                                </div>
                            </div>
                            <span class="bg-slate-100 text-slate-600 text-xs font-bold px-2.5 py-1 rounded-md border border-slate-200">7.5</span>
                        </div>
                        
                        <div class="flex items-center justify-between group cursor-pointer">
                            <div class="flex items-center gap-3">
                                <div class="w-1.5 h-1.5 rounded-full bg-slate-400"></div>
                                <div>
                                    <p class="text-sm font-bold text-slate-800 group-hover:text-red-700 transition">vs Putra Pegok</p>
                                    <p class="text-[10px] text-slate-500 font-medium">Lapangan Astina • Seri 0-0</p>
                                </div>
                            </div>
                            <span class="bg-slate-100 text-slate-600 text-xs font-bold px-2.5 py-1 rounded-md border border-slate-200">6.0</span>
                        </div>
                    </div>
                    
                    <button class="w-full mt-6 py-2 rounded-lg bg-slate-50 text-slate-600 text-xs font-bold hover:bg-slate-100 transition border border-slate-200">
                        Lihat Semua Riwayat
                    </button>
                </div>

                <div class="bg-gradient-to-br from-red-50 to-white rounded-xl p-6 border border-red-100 shadow-sm">
                    <h3 class="font-bold text-red-900 mb-2 flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                        Pusat Bantuan
                    </h3>
                    <p class="text-xs text-red-700/80 mb-4 leading-relaxed">
                        Jika terdapat kesalahan pada data statistik atau profil Anda, silakan hubungi operator klub masing-masing.
                    </p>
                    <a href="#" class="text-xs font-bold text-white bg-red-700 px-4 py-2 rounded-lg inline-block shadow-md hover:bg-red-800 transition">
                        Hubungi Operator Klub
                    </a>
                </div>

            </div>
        </div>
        
        <div class="mt-12 text-center border-t border-slate-200 pt-8">
            <p class="text-slate-400 text-xs font-medium">
                &copy; <?php echo e(date('Y')); ?> PSSI Kabupaten Gianyar.
                <span class="block mt-1">Sistem Informasi Manajemen Kompetisi & Pemain.</span>
            </p>
        </div>

    </main>

</body>
</html><?php /**PATH H:\pssi_gianyar\resources\views/player/dashboard.blade.php ENDPATH**/ ?>