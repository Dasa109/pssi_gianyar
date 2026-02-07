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
    </style>
</head>
<body class="bg-slate-50 text-slate-800">

    <nav class="sticky top-0 z-50 glass-effect border-b border-slate-200 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center gap-2">
                    <div class="bg-blue-600 text-white p-1.5 rounded-lg">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                    </div>
                    <span class="font-bold text-xl tracking-tight text-slate-900">Player<span class="text-blue-600">Portal</span></span>
                </div>

                <div class="flex items-center" x-data="{ open: false }">
                    <button @click="open = !open" class="flex items-center gap-2 focus:outline-none">
                        <span class="hidden md:block text-sm font-medium text-slate-600"><?php echo e($player->name); ?></span>
                        <img src="<?php echo e($player->photo ? asset('storage/' . $player->photo) : 'https://ui-avatars.com/api/?name='.urlencode($player->name).'&background=random'); ?>" 
                             class="h-9 w-9 rounded-full object-cover border-2 border-white shadow-sm">
                    </button>

                    <div x-show="open" @click.away="open = false" 
                         class="absolute right-4 top-16 w-48 bg-white rounded-lg shadow-lg py-1 border border-slate-100" 
                         style="display: none;">
                        <div class="px-4 py-2 border-b border-slate-100">
                            <p class="text-xs text-slate-500">Masuk sebagai</p>
                            <p class="text-sm font-bold truncate"><?php echo e($player->email); ?></p>
                        </div>
                        <form action="<?php echo e(route('player.logout')); ?>" method="POST">
                            <?php echo csrf_field(); ?>
                            <button type="submit" class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50 flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                                Keluar
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        
        <div class="relative bg-white rounded-2xl shadow-sm overflow-hidden mb-8 border border-slate-200">
            <div class="h-32 bg-gradient-to-r from-red-600 to-red-700 relative">
                <div class="absolute inset-0 opacity-20" style="background-image: url('data:image/svg+xml,%3Csvg width=\'20\' height=\'20\' viewBox=\'0 0 20 20\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cg fill=\'%23ffffff\' fill-opacity=\'1\' fill-rule=\'evenodd\'%3E%3Ccircle cx=\'3\' cy=\'3\' r=\'3\'/%3E%3Ccircle cx=\'13\' cy=\'13\' r=\'3\'/%3E%3C/g%3E%3C/svg%3E');"></div>
            </div>
            
            <div class="px-6 pb-6">
                <div class="flex flex-col md:flex-row items-center md:items-end -mt-12 mb-4 gap-6">
                    <div class="relative">
                        <img src="<?php echo e($player->photo ? asset('storage/' . $player->photo) : 'https://ui-avatars.com/api/?name='.urlencode($player->name).'&size=128'); ?>" 
                             class="w-32 h-32 rounded-2xl object-cover border-4 border-white shadow-md bg-white">
                        <div class="absolute bottom-2 right-2 bg-green-500 w-5 h-5 rounded-full border-2 border-white" title="Status: Aktif"></div>
                    </div>

                    <div class="flex-1 text-center md:text-left">
                        <h1 class="text-3xl font-bold text-slate-900"><?php echo e($player->name); ?></h1>
                        <div class="flex flex-wrap justify-center md:justify-start gap-3 mt-2 text-sm text-slate-600">
                            <span class="flex items-center gap-1 bg-slate-100 px-3 py-1 rounded-full">
                                👕 No. <strong><?php echo e($player->number); ?></strong>
                            </span>
                            <span class="flex items-center gap-1 bg-slate-100 px-3 py-1 rounded-full">
                                ⚽ <?php echo e($player->position); ?>

                            </span>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($player->club): ?>
                            <span class="flex items-center gap-1 bg-blue-50 text-blue-700 px-3 py-1 rounded-full font-medium">
                                🛡️ <?php echo e($player->club->name); ?>

                            </span>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($player->is_captain): ?>
                            <span class="flex items-center gap-1 bg-yellow-100 text-yellow-800 px-3 py-1 rounded-full font-bold border border-yellow-200">
                                © Captain
                            </span>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>
                    </div>

                    <div class="flex gap-2 mt-4 md:mt-0">
                        <button class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition shadow-sm">
                            Edit Profil
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <div class="lg:col-span-2 space-y-8">
                
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    <div class="bg-white p-4 rounded-xl border border-slate-200 shadow-sm flex flex-col items-center">
                        <span class="text-slate-400 text-xs font-semibold uppercase tracking-wider">Gol Musim Ini</span>
                        <span class="text-3xl font-bold text-slate-800 mt-1">0</span>
                        <div class="w-full bg-slate-100 h-1.5 mt-3 rounded-full overflow-hidden">
                            <div class="bg-green-500 h-1.5 rounded-full" style="width: 0%"></div>
                        </div>
                    </div>
                    <div class="bg-white p-4 rounded-xl border border-slate-200 shadow-sm flex flex-col items-center">
                        <span class="text-slate-400 text-xs font-semibold uppercase tracking-wider">Assist</span>
                        <span class="text-3xl font-bold text-slate-800 mt-1">0</span>
                        <div class="w-full bg-slate-100 h-1.5 mt-3 rounded-full overflow-hidden">
                            <div class="bg-red-500 h-1.5 rounded-full" style="width: 0%"></div>
                        </div>
                    </div>
                    <div class="bg-white p-4 rounded-xl border border-slate-200 shadow-sm flex flex-col items-center">
                        <span class="text-slate-400 text-xs font-semibold uppercase tracking-wider">Menit Main</span>
                        <span class="text-3xl font-bold text-slate-800 mt-1">0'</span>
                        <div class="w-full bg-slate-100 h-1.5 mt-3 rounded-full overflow-hidden">
                            <div class="bg-red-500 h-1.5 rounded-full" style="width: 0%"></div>
                        </div>
                    </div>
                    <div class="bg-white p-4 rounded-xl border border-slate-200 shadow-sm flex flex-col items-center">
                        <span class="text-slate-400 text-xs font-semibold uppercase tracking-wider">Kartu Kuning</span>
                        <span class="text-3xl font-bold text-yellow-600 mt-1">0</span>
                        <div class="w-full bg-slate-100 h-1.5 mt-3 rounded-full overflow-hidden">
                            <div class="bg-yellow-500 h-1.5 rounded-full" style="width: 0%"></div>
                        </div>
                    </div>
                </div>

                <div class="bg-gradient-to-br from-slate-900 to-slate-800 rounded-2xl shadow-lg p-6 text-white relative overflow-hidden">
                    <div class="absolute top-0 right-0 -mr-8 -mt-8 w-32 h-32 bg-white opacity-5 rounded-full blur-2xl"></div>
                    
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="font-semibold text-lg flex items-center gap-2">
                            <svg class="w-5 h-5 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            Jadwal Pertandingan Berikutnya
                        </h3>
                        <span class="bg-white/10 px-3 py-1 rounded-full text-xs font-medium">Liga 1 Gianyar</span>
                    </div>

                    <div class="flex items-center justify-between mt-6">
                        <div class="text-center w-1/3">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($player->club && $player->club->logo): ?>
                                <img src="<?php echo e(asset('storage/'.$player->club->logo)); ?>" class="w-16 h-16 mx-auto bg-white rounded-full p-1">
                            <?php else: ?>
                                <div class="w-16 h-16 mx-auto bg-slate-700 rounded-full flex items-center justify-center text-2xl">🛡️</div>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            <p class="mt-2 font-bold truncate"><?php echo e($player->club->short_name ?? 'HOME'); ?></p>
                        </div>

                        <div class="text-center w-1/3">
                            <div class="text-3xl font-black text-slate-500 mb-1">VS</div>
                            <div class="bg-green-600 text-xs px-3 py-1 rounded-full inline-block font-bold">12 AGT, 15:00</div>
                            <p class="text-xs text-slate-400 mt-2">Stadion Dipta</p>
                        </div>

                        <div class="text-center w-1/3">
                            <div class="w-16 h-16 mx-auto bg-white/10 rounded-full flex items-center justify-center text-2xl border-2 border-slate-600 border-dashed">?</div>
                            <p class="mt-2 font-bold text-slate-400">LAWAN</p>
                        </div>
                    </div>
                </div>

            </div>

            <div class="space-y-8">
                
                <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
                    <h3 class="font-bold text-slate-800 mb-4 flex items-center gap-2">
                        <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        Performa Terakhir (5 Laga)
                    </h3>
                    
                    <div class="space-y-3">
                        <div class="flex items-center justify-between p-3 bg-slate-50 rounded-lg hover:bg-slate-100 transition">
                            <div class="flex items-center gap-3">
                                <span class="w-2 h-2 rounded-full bg-green-500"></span>
                                <div>
                                    <p class="text-sm font-bold text-slate-700">vs Perseden</p>
                                    <p class="text-xs text-slate-500">Menang 2-1</p>
                                </div>
                            </div>
                            <span class="bg-green-100 text-green-700 text-xs font-bold px-2 py-1 rounded">7.5</span>
                        </div>
                        <div class="flex items-center justify-between p-3 bg-slate-50 rounded-lg hover:bg-slate-100 transition">
                            <div class="flex items-center gap-3">
                                <span class="w-2 h-2 rounded-full bg-gray-400"></span>
                                <div>
                                    <p class="text-sm font-bold text-slate-700">vs Putra Pegok</p>
                                    <p class="text-xs text-slate-500">Seri 0-0</p>
                                </div>
                            </div>
                            <span class="bg-slate-200 text-slate-700 text-xs font-bold px-2 py-1 rounded">6.0</span>
                        </div>
                        <div class="text-center py-4 text-xs text-slate-400 italic">
                            Belum ada data pertandingan resmi lainnya.
                        </div>
                    </div>
                    
                    <button class="w-full mt-4 text-center text-blue-600 text-sm font-medium hover:underline">Lihat Semua Sejarah</button>
                </div>

                <div class="bg-blue-50 rounded-xl p-6 border border-blue-100">
                    <h3 class="font-bold text-blue-800 mb-2">Butuh Bantuan?</h3>
                    <p class="text-sm text-blue-600 mb-4">Hubungi admin klub jika ada kesalahan data profil Anda.</p>
                    <a href="#" class="text-sm font-bold text-blue-700 underline">Kontak Admin PSSI Gianyar &rarr;</a>
                </div>

            </div>
        </div>
    </main>

</body>
</html><?php /**PATH H:\pssi_gianyar\resources\views/player/dashboard.blade.php ENDPATH**/ ?>