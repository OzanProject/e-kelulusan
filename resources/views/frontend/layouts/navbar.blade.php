<!-- TopNavBar Component -->
<nav class="bg-white dark:bg-gray-900 shadow-sm dark:shadow-none fixed top-0 w-full z-50 flex justify-between items-center px-6 h-16 border-b border-gray-200 dark:border-gray-800">
    <a href="{{ route('home') }}" class="text-xl font-bold text-gray-900 dark:text-white flex items-center gap-2 hover:opacity-80 transition-opacity">
        @if($school_setting && $school_setting->school_logo)
            <img src="{{ asset('storage/' . $school_setting->school_logo) }}" alt="Logo" class="h-10 w-10 object-contain rounded-full">
        @else
            <span class="material-symbols-outlined" data-icon="school" data-weight="fill" style="font-variation-settings: 'FILL' 1;">school</span>
        @endif
        {{ $school_setting->school_name ?? 'Graduation Portal' }}
    </a>
    
    <!-- Desktop Menu -->
    <div class="hidden md:flex items-center gap-6">
        @php
            $activeClass = "text-[#3c8dbc] border-b-2 border-[#3c8dbc] pb-1";
            $inactiveClass = "text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors duration-200";
            $baseClass = "font-['Public_Sans'] text-sm font-semibold tracking-tight cursor-pointer active:opacity-80";
        @endphp
        
        <a class="{{ $baseClass }} {{ request()->routeIs('home', 'cek.kelulusan') ? $activeClass : $inactiveClass }}" href="{{ route('home') }}">Beranda</a>
        <a class="{{ $baseClass }} {{ request()->routeIs('pengumuman') ? $activeClass : $inactiveClass }}" href="{{ route('pengumuman') }}">Pengumuman</a>
        <a class="{{ $baseClass }} {{ request()->routeIs('contact') ? $activeClass : $inactiveClass }}" href="{{ route('contact') }}">Kontak</a>
        
        <!-- Theme Toggle Desktop -->
        <button id="theme-toggle-desktop" class="focus:outline-none flex items-center justify-center p-2 rounded-full hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors text-gray-600 dark:text-gray-400">
            <span class="material-symbols-outlined theme-icon-light" style="display: none;">light_mode</span>
            <span class="material-symbols-outlined theme-icon-dark" style="display: none;">dark_mode</span>
        </button>
    </div>

    <!-- Mobile Menu Button & Theme Toggle -->
    <div class="flex items-center gap-2 text-gray-600 dark:text-gray-400 md:hidden">
        <!-- Theme Toggle Mobile -->
        <button id="theme-toggle-mobile" class="focus:outline-none flex items-center justify-center p-1.5 rounded-md hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors">
            <span class="material-symbols-outlined theme-icon-light" style="display: none;">light_mode</span>
            <span class="material-symbols-outlined theme-icon-dark" style="display: none;">dark_mode</span>
        </button>

        <button id="mobile-menu-btn" class="focus:outline-none flex items-center justify-center p-1.5 rounded-md hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors">
            <span class="material-symbols-outlined cursor-pointer hover:text-gray-900 transition-colors" data-icon="menu">menu</span>
        </button>
    </div>
</nav>

<!-- Mobile Menu Dropdown -->
<div id="mobile-menu" class="fixed top-16 left-0 w-full bg-white dark:bg-gray-900 border-b border-gray-200 dark:border-gray-800 shadow-md z-40 hidden flex-col md:hidden">
    @php
        $mobileActiveClass = "text-[#3c8dbc] bg-[#f0f8ff] dark:bg-gray-800 border-l-4 border-[#3c8dbc]";
        $mobileInactiveClass = "text-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-800 hover:text-gray-900 dark:hover:text-white border-l-4 border-transparent";
        $mobileBaseClass = "block px-6 py-4 font-['Public_Sans'] text-base font-semibold tracking-tight transition-colors duration-200";
    @endphp

    <a href="{{ route('home') }}" class="{{ $mobileBaseClass }} {{ request()->routeIs('home', 'cek.kelulusan') ? $mobileActiveClass : $mobileInactiveClass }}">
        Beranda
    </a>
    <a href="{{ route('pengumuman') }}" class="{{ $mobileBaseClass }} {{ request()->routeIs('pengumuman') ? $mobileActiveClass : $mobileInactiveClass }}">
        Pengumuman
    </a>
    <a href="{{ route('contact') }}" class="{{ $mobileBaseClass }} {{ request()->routeIs('contact') ? $mobileActiveClass : $mobileInactiveClass }}">
        Kontak
    </a>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const btn = document.getElementById('mobile-menu-btn');
        const menu = document.getElementById('mobile-menu');
        const icon = btn.querySelector('.material-symbols-outlined');

        btn.addEventListener('click', function() {
            menu.classList.toggle('hidden');
            menu.classList.toggle('flex');
            
            // Toggle icon menu / close
            if (menu.classList.contains('hidden')) {
                icon.textContent = 'menu';
            } else {
                icon.textContent = 'close';
            }
        });
    });
</script>
