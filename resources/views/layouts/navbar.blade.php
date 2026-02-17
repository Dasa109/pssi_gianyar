<nav x-data="{ isOpen: false }" class="bg-red-700 shadow-lg sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            
            <div class="flex items-center">
                <a href="/" class="flex-shrink-0 flex items-center gap-2">
                    <div class="w-8 h-8 bg-white rounded-full flex items-center justify-center text-red-700 font-bold">P</div>
                    <span class="font-bold text-xl text-white tracking-wide">PSSI GIANYAR</span>
                </a>
            </div>

            <div class="hidden md:flex space-x-8 items-center">
                <a href="/" class="text-white hover:bg-red-600 px-3 py-2 rounded-md font-medium transition">Beranda</a>
                <a href="/berita" class="text-gray-200 hover:text-white hover:bg-red-600 px-3 py-2 rounded-md font-medium transition">Berita</a>
                <a href="/klasemen" class="text-gray-200 hover:text-white hover:bg-red-600 px-3 py-2 rounded-md font-medium transition">Klasemen</a>
                <a href="/galeri" class="text-gray-200 hover:text-white hover:bg-red-600 px-3 py-2 rounded-md font-medium transition">Galeri</a>
                <a href="/login" class="bg-white text-red-700 hover:bg-gray-100 px-4 py-2 rounded-full font-bold text-sm shadow transition">Login</a>
            </div>

            <div class="-mr-2 flex items-center md:hidden">
                <button @click="isOpen = !isOpen" type="button" class="inline-flex items-center justify-center p-2 rounded-md text-red-200 hover:text-white hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-white">
                    <span class="sr-only">Open main menu</span>
                    <svg :class="{'hidden': isOpen, 'block': !isOpen }" class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                    <svg :class="{'block': isOpen, 'hidden': !isOpen }" class="hidden h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <div x-show="isOpen" 
         x-transition:enter="transition ease-out duration-100"
         x-transition:enter-start="transform opacity-0 scale-95"
         x-transition:enter-end="transform opacity-100 scale-100"
         x-transition:leave="transition ease-in duration-75"
         x-transition:leave-start="transform opacity-100 scale-100"
         x-transition:leave-end="transform opacity-0 scale-95"
         class="md:hidden bg-red-800">
        <div class="px-2 pt-2 pb-3 space-y-1 sm:px-3">
            <a href="/" class="block px-3 py-2 rounded-md text-base font-medium text-white bg-red-900">Beranda</a>
            <a href="/berita" class="block px-3 py-2 rounded-md text-base font-medium text-gray-300 hover:text-white hover:bg-red-600">Berita</a>
            <a href="/klasemen" class="block px-3 py-2 rounded-md text-base font-medium text-gray-300 hover:text-white hover:bg-red-600">Klasemen</a>
            <a href="/galeri" class="block px-3 py-2 rounded-md text-base font-medium text-gray-300 hover:text-white hover:bg-red-600">Galeri</a>
            <a href="/login" class="block px-3 py-2 mt-4 rounded-md text-base font-bold text-center bg-white text-red-800">Login Admin</a>
        </div>
    </div>
</nav>