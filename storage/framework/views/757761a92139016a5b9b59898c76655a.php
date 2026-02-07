<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $__env->yieldContent('title', 'PSSI Gianyar'); ?></title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;800&family=Oswald:wght@400;600;700&display=swap" rel="stylesheet">

    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
    
    <style>
        body { font-family: 'Inter', sans-serif; }
        h1, h2, h3, .font-heading { font-family: 'Oswald', sans-serif; }
    </style>
</head>
<body class="bg-black text-gray-200 antialiased selection:bg-red-600 selection:text-white flex flex-col min-h-screen">

    <nav class="fixed w-full z-50 top-0 start-0 border-b border-white/10 bg-black/90 backdrop-blur-md">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-wrap items-center justify-between py-4">
                
                <a href="<?php echo e(url('/')); ?>" class="flex items-center space-x-3 group">
                    <div class="w-10 h-10 bg-red-600 -skew-x-12 flex items-center justify-center shadow-[0_0_15px_rgba(220,38,38,0.5)] group-hover:shadow-[0_0_25px_rgba(220,38,38,0.8)] transition">
                         <span class="text-white font-heading font-bold text-lg skew-x-12">PG</span>
                    </div>
                    <div class="flex flex-col">
                        <span class="self-center text-xl font-heading font-bold whitespace-nowrap text-white tracking-wide">PSSI <span class="text-red-600">GIANYAR</span></span>
                    </div>
                </a>

                <div class="hidden md:block">
                    <ul class="flex space-x-8 font-heading font-medium text-sm tracking-widest uppercase">
                        <li><a href="<?php echo e(url('/')); ?>" class="hover:text-red-500 transition">Beranda</a></li>
                        <li><a href="<?php echo e(route('clubs.index')); ?>" class="hover:text-red-500 transition">Klub</a></li>
                        <li><a href="#" class="hover:text-red-500 transition">Jadwal</a></li>
                        <li><a href="#" class="hover:text-red-500 transition">Klasemen</a></li>
                        <li><a href="#" class="hover:text-red-500 transition">Visi Misi</a></li>
                        <li><a href="#" class="hover:text-red-500 transition">Lapangan</a></li>
                    </ul>
                </div>

                <div class="flex gap-4">
                    <a href="/portal-pemain/login" class="px-5 py-2 text-xs font-bold uppercase tracking-widest border border-red-600 text-red-600 hover:bg-red-600 hover:text-white transition -skew-x-12">
                        <span class="skew-x-12 block">Login Area</span>
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <main class="flex-grow pt-[74px]">
        <?php echo $__env->yieldContent('content'); ?>
    </main>

    <footer class="bg-zinc-950 border-t border-zinc-900 mt-auto">
        <div class="max-w-7xl mx-auto p-8 md:py-12">
            <div class="flex flex-col md:flex-row justify-between items-center gap-6">
                <a href="/" class="flex items-center space-x-2">
                    <span class="text-2xl font-heading font-bold text-white">PSSI <span class="text-red-600">GIANYAR</span></span>
                </a>
                <ul class="flex flex-wrap items-center text-sm font-medium text-gray-500">
                    <li><a href="#" class="hover:text-red-500 me-4 md:me-6">Tentang Kami</a></li>
                    <li><a href="#" class="hover:text-red-500 me-4 md:me-6">Regulasi</a></li>
                    <li><a href="#" class="hover:text-red-500">Kontak</a></li>
                </ul>
            </div>
            <hr class="my-6 border-zinc-800" />
            <span class="block text-sm text-gray-600 text-center">© 2026 PSSI Kabupaten Gianyar. All Rights Reserved.</span>
        </div>
    </footer>

</body>
</html><?php /**PATH H:\pssi_gianyar\resources\views/layouts/app.blade.php ENDPATH**/ ?>