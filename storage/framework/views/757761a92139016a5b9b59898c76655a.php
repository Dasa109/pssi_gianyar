<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $__env->yieldContent('title', 'PSSI Gianyar - Official Website'); ?></title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;800&family=Oswald:wght@400;600;700&display=swap" rel="stylesheet">

    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
    
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        body { font-family: 'Inter', sans-serif; }
        h1, h2, h3, .font-heading { font-family: 'Oswald', sans-serif; }
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="bg-black text-gray-200 antialiased selection:bg-red-600 selection:text-white flex flex-col min-h-screen">

    <nav x-data="{ isOpen: false }" class="fixed w-full z-50 top-0 start-0 border-b border-white/10 bg-black/95 backdrop-blur-md">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between py-4">
                
                <a href="<?php echo e(url('/')); ?>" class="flex items-center space-x-2 md:space-x-3 group z-50 relative">
                    <div class="w-8 h-8 md:w-10 md:h-10 bg-red-600 -skew-x-12 flex items-center justify-center shadow-[0_0_15px_rgba(220,38,38,0.5)] transition duration-300">
                         <span class="text-white font-heading font-bold text-base md:text-lg skew-x-12">PG</span>
                    </div>
                    <div class="flex flex-col">
                        <span class="self-center text-lg md:text-xl font-heading font-bold whitespace-nowrap text-white tracking-wide">PSSI <span class="text-red-600">GIANYAR</span></span>
                    </div>
                </a>

                <div class="hidden md:block">
                    <ul class="flex space-x-8 font-heading font-medium text-sm tracking-widest uppercase text-gray-400">
                        <li><a href="<?php echo e(url('/')); ?>" class="hover:text-red-500 transition <?php echo e(Request::is('/') ? 'text-white' : ''); ?>">Beranda</a></li>
                        <li>
                            <a href="<?php echo e(Route::has('clubs.index') ? route('clubs.index') : '#'); ?>" class="hover:text-red-500 transition <?php echo e(Request::routeIs('clubs.*') ? 'text-white' : ''); ?>">
                                Klub
                            </a>
                        </li>
                        <li><a href="#" class="hover:text-red-500 transition">Jadwal</a></li>
                        <li><a href="#" class="hover:text-red-500 transition">Klasemen</a></li>
                        <li><a href="#" class="hover:text-red-500 transition">Visi Misi</a></li>
                    </ul>
                </div>

                <div class="flex items-center gap-3 md:gap-4 z-50 relative">
                    
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(Auth::guard('player')->check()): ?>
                        <a href="<?php echo e(route('player.dashboard')); ?>" class="hidden md:flex px-3 md:px-5 py-1.5 md:py-2 text-[10px] md:text-xs font-bold uppercase tracking-widest border border-green-600 text-green-500 hover:bg-green-600 hover:text-white transition -skew-x-12 items-center gap-2">
                            <span class="skew-x-12 block">
                                Hi, <?php echo e(Str::limit(Auth::guard('player')->user()->name, 8)); ?>

                            </span>
                        </a>
                    <?php else: ?>
                        <a href="<?php echo e(route('player.login')); ?>" class="hidden md:block px-3 md:px-5 py-1.5 md:py-2 text-[10px] md:text-xs font-bold uppercase tracking-widest border border-red-600 text-red-600 hover:bg-red-600 hover:text-white transition -skew-x-12">
                            <span class="skew-x-12 block">Login</span>
                        </a>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                    <button @click="isOpen = !isOpen" class="md:hidden text-gray-300 hover:text-white focus:outline-none">
                        <svg x-show="!isOpen" class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                        <svg x-show="isOpen" x-cloak class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>
            </div>
        </div>

        <div x-show="isOpen" 
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0 -translate-y-2"
             x-transition:enter-end="opacity-100 translate-y-0"
             x-transition:leave="transition ease-in duration-150"
             x-transition:leave-start="opacity-100 translate-y-0"
             x-transition:leave-end="opacity-0 -translate-y-2"
             class="md:hidden absolute top-full left-0 w-full bg-zinc-900 border-b border-white/10 shadow-2xl overflow-hidden">
            
            <ul class="flex flex-col py-4 px-6 space-y-4 font-heading font-medium text-sm tracking-widest uppercase text-gray-400">
                <li><a href="<?php echo e(url('/')); ?>" class="block py-2 border-b border-white/5 hover:text-red-500 transition text-white">Beranda</a></li>
                <li><a href="<?php echo e(Route::has('clubs.index') ? route('clubs.index') : '#'); ?>" class="block py-2 border-b border-white/5 hover:text-red-500 transition">Klub</a></li>
                <li><a href="#" class="block py-2 border-b border-white/5 hover:text-red-500 transition">Jadwal</a></li>
                <li><a href="#" class="block py-2 border-b border-white/5 hover:text-red-500 transition">Klasemen</a></li>
                
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(Auth::guard('player')->check()): ?>
                    <li class="pt-4 border-t border-white/10">
                        <span class="block text-xs text-gray-500 mb-2">Login sebagai: <strong class="text-white"><?php echo e(Auth::guard('player')->user()->name); ?></strong></span>
                        <a href="<?php echo e(route('player.dashboard')); ?>" class="block py-2 text-green-500 font-bold hover:text-green-400">Dashboard Saya</a>
                        <form action="<?php echo e(route('player.logout')); ?>" method="POST" class="mt-2">
                            <?php echo csrf_field(); ?>
                            <button type="submit" class="block w-full text-left py-2 text-red-500 font-bold hover:text-red-400">Logout</button>
                        </form>
                    </li>
                <?php else: ?>
                    <li class="pt-4 border-t border-white/10">
                        <a href="<?php echo e(route('player.login')); ?>" class="block py-2 text-white font-bold bg-red-600 text-center rounded">Login / Daftar</a>
                    </li>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </ul>
        </div>
    </nav>

    <main class="flex-grow pt-[74px]">
        <?php echo $__env->yieldContent('content'); ?>
    </main>

    <footer class="bg-zinc-950 border-t border-zinc-900 mt-auto">
        <div class="max-w-7xl mx-auto p-8 md:py-12">
            <div class="flex flex-col md:flex-row justify-between items-center gap-6 text-center md:text-left">
                <a href="/" class="flex items-center space-x-2">
                    <span class="text-2xl font-heading font-bold text-white">PSSI <span class="text-red-600">GIANYAR</span></span>
                </a>
                <ul class="flex flex-wrap justify-center items-center text-sm font-medium text-gray-500 gap-4 md:gap-6">
                    <li><a href="#" class="hover:text-red-500 transition">Tentang Kami</a></li>
                    <li><a href="#" class="hover:text-red-500 transition">Regulasi</a></li>
                    <li><a href="#" class="hover:text-red-500 transition">Kontak</a></li>
                </ul>
            </div>
            <hr class="my-6 border-zinc-800" />
            <span class="block text-sm text-gray-600 text-center">© <?php echo e(date('Y')); ?> PSSI Kabupaten Gianyar. All Rights Reserved.</span>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            <?php if(session('success')): ?>
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: "<?php echo e(session('success')); ?>",
                    background: '#18181b',
                    color: '#fff',
                    confirmButtonColor: '#dc2626',
                    timer: 3000,
                    timerProgressBar: true
                });
            <?php endif; ?>

            <?php if(session('error')): ?>
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal!',
                    text: "<?php echo e(session('error')); ?>",
                    background: '#18181b',
                    color: '#fff',
                    confirmButtonColor: '#dc2626'
                });
            <?php endif; ?>
            
            // Cek error validasi (dari $errors)
            <?php if($errors->any()): ?>
                Swal.fire({
                    icon: 'warning',
                    title: 'Perhatian',
                    text: 'Mohon periksa kembali inputan Anda.',
                    background: '#18181b',
                    color: '#fff',
                    confirmButtonColor: '#dc2626'
                });
            <?php endif; ?>
        });
    </script>

</body>
</html><?php /**PATH H:\pssi_gianyar\resources\views/layouts/app.blade.php ENDPATH**/ ?>