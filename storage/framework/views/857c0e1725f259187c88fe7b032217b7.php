

<?php $__env->startSection('title', $club->name); ?>

<?php $__env->startSection('content'); ?>

<div class="relative h-[400px] md:h-[500px] bg-zinc-950 flex items-center justify-center overflow-hidden border-b border-white/5">
    <div class="absolute inset-0 opacity-20 bg-[url('https://www.transparenttextures.com/patterns/carbon-fibre.png')]"></div>
    <div class="absolute inset-0 bg-gradient-to-t from-zinc-900 via-zinc-900/60 to-transparent"></div>
    
    <div class="relative z-10 text-center px-4 flex flex-col items-center mt-10">
        <div class="w-32 h-32 md:w-48 md:h-48 mb-6 drop-shadow-[0_0_50px_rgba(220,38,38,0.5)] animate-pulse">
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($club->logo): ?>
                <img src="<?php echo e(asset('storage/' . $club->logo)); ?>" alt="<?php echo e($club->name); ?>" class="w-full h-full object-contain transform hover:scale-105 transition duration-500">
            <?php else: ?>
                <div class="w-full h-full flex items-center justify-center bg-zinc-800 rounded-full border-4 border-zinc-700">
                    <span class="text-4xl font-bold text-zinc-600">?</span>
                </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>
        
        <h1 class="text-4xl md:text-7xl font-black text-white uppercase italic font-heading tracking-tighter drop-shadow-lg leading-none mb-4">
            <?php echo e($club->name); ?>

        </h1>
        
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($club->stadium_name): ?>
            <div class="inline-flex items-center gap-2 bg-red-600/10 border border-red-600/30 px-6 py-2 rounded-full backdrop-blur-md">
                <svg class="w-4 h-4 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                <span class="text-red-100 font-bold tracking-widest uppercase text-xs md:text-sm"><?php echo e($club->stadium_name); ?></span>
            </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    </div>
</div>

<div class="bg-zinc-900 pb-20 pt-10 px-4 min-h-screen">
    <div class="max-w-7xl mx-auto grid grid-cols-1 lg:grid-cols-12 gap-10">
        
        <div class="lg:col-span-4 space-y-6">
            <div class="lg:sticky lg:top-24 space-y-6"> <div class="bg-zinc-800 border-l-4 border-red-600 p-6 shadow-xl">
                    <h3 class="text-xl font-bold text-white mb-6 uppercase italic flex items-center gap-2">
                        <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        Informasi Klub
                    </h3>
                    
                    <div class="space-y-5">
                        <div class="flex justify-between border-b border-white/5 pb-2">
                            <span class="text-zinc-500 text-xs font-bold uppercase tracking-widest">Singkatan</span>
                            <span class="text-white font-bold bg-zinc-900 px-2 py-1 rounded text-sm"><?php echo e($club->short_name ?? '-'); ?></span>
                        </div>
                        <div class="flex justify-between border-b border-white/5 pb-2">
                            <span class="text-zinc-500 text-xs font-bold uppercase tracking-widest">Kontak</span>
                            <span class="text-white font-bold text-sm"><?php echo e($club->phone ?? '-'); ?></span>
                        </div>
                        <div class="pb-2">
                            <span class="text-zinc-500 text-xs font-bold uppercase tracking-widest block mb-2">Alamat Markas</span>
                            <p class="text-zinc-300 text-sm leading-relaxed bg-zinc-900/50 p-3 rounded border border-white/5">
                                <?php echo e($club->address ?? '-'); ?>

                            </p>
                        </div>
                    </div>
                </div>

                <a href="<?php echo e(route('clubs.index')); ?>" class="group block w-full text-center py-4 border border-zinc-700 text-zinc-400 hover:text-white hover:border-red-600 hover:bg-red-600/10 transition uppercase font-bold text-xs tracking-[0.2em]">
                    &larr; Kembali ke Daftar
                </a>
            </div>
        </div>

        <div class="lg:col-span-8 space-y-12">

            <div class="bg-zinc-800/30 p-8 rounded-2xl border border-white/5">
                <div class="flex items-center gap-3 mb-6">
                    <div class="h-8 w-1 bg-red-600 -skew-x-12"></div>
                    <h2 class="text-2xl md:text-3xl font-bold text-white italic uppercase font-heading">
                        Sejarah & <span class="text-red-600">Profil</span>
                    </h2>
                </div>
                
                <div class="prose prose-invert prose-red max-w-none text-zinc-400 leading-loose">
                    <?php echo $club->history ?? '<p class="italic text-zinc-600">Belum ada sejarah yang ditulis oleh admin.</p>'; ?>

                </div>

                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mt-8 pt-8 border-t border-white/5">
                    <div class="text-center">
                        <span class="block text-3xl font-bold text-white mb-1">0</span>
                        <span class="text-[10px] text-zinc-500 uppercase tracking-widest font-bold">Juara</span>
                    </div>
                    <div class="text-center">
                        <span class="block text-3xl font-bold text-white mb-1">0</span>
                        <span class="text-[10px] text-zinc-500 uppercase tracking-widest font-bold">Laga</span>
                    </div>
                    <div class="text-center">
                        <span class="block text-3xl font-bold text-white mb-1">0</span>
                        <span class="text-[10px] text-zinc-500 uppercase tracking-widest font-bold">Menang</span>
                    </div>
                    <div class="text-center">
                        <span class="block text-3xl font-bold text-white mb-1">0</span>
                        <span class="text-[10px] text-zinc-500 uppercase tracking-widest font-bold">Gol</span>
                    </div>
                </div>
            </div>

            <div>
                <div class="flex items-center gap-3 mb-8">
                    <div class="h-8 w-1 bg-red-600 -skew-x-12"></div>
                    <h2 class="text-2xl md:text-3xl font-bold text-white italic uppercase font-heading">
                        Skuad <span class="text-red-600">Pemain</span>
                    </h2>
                </div>

                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($club->players->count() > 0): ?>
                    <div class="grid grid-cols-2 md:grid-cols-3 gap-6">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $club->players; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $player): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="relative group overflow-hidden rounded-xl bg-zinc-800 border border-zinc-700/50 hover:border-red-600 hover:shadow-[0_0_20px_rgba(220,38,38,0.2)] transition-all duration-300">
                                <div class="h-64 overflow-hidden bg-gradient-to-b from-zinc-700 to-zinc-900 relative">
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($player->photo): ?>
                                        <img src="<?php echo e(asset('storage/' . $player->photo)); ?>" class="w-full h-full object-cover object-top group-hover:scale-110 transition duration-500">
                                    <?php else: ?>
                                        <div class="w-full h-full flex items-center justify-center text-zinc-600">
                                            <svg class="w-24 h-24 opacity-20" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path></svg>
                                        </div>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    
                                    <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-transparent to-transparent opacity-60 group-hover:opacity-90 transition"></div>

                                    <span class="absolute top-3 right-3 text-[10px] font-bold px-2 py-1 rounded bg-red-600 text-white shadow-lg">
                                        <?php echo e($player->position); ?>

                                    </span>
                                </div>

                                <div class="absolute bottom-0 left-0 w-full p-4 transform translate-y-2 group-hover:translate-y-0 transition duration-300">
                                    <div class="flex items-end justify-between">
                                        <div>
                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($player->is_captain): ?>
                                                <span class="text-[10px] text-yellow-400 font-bold tracking-widest uppercase flex items-center gap-1 mb-1">
                                                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                                    Captain
                                                </span>
                                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                            <h4 class="text-white font-bold text-lg leading-tight uppercase font-heading"><?php echo e($player->name); ?></h4>
                                        </div>
                                        <div class="text-4xl font-black italic text-zinc-700 group-hover:text-red-600/50 transition">
                                            <?php echo e($player->number); ?>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                <?php else: ?>
                    <div class="py-12 text-center border-2 border-dashed border-zinc-800 rounded-xl bg-zinc-900/50">
                        <svg class="mx-auto h-12 w-12 text-zinc-600 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                        <p class="text-zinc-500 font-medium">Belum ada pemain yang didaftarkan.</p>
                    </div>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>

        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH H:\pssi_gianyar\resources\views/pages/clubs/show.blade.php ENDPATH**/ ?>