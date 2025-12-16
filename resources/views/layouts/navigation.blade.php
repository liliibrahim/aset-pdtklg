<nav class="bg-white border-b border-gray-100">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">

                <!-- Logo -->
                <div class="flex items-center space-x-3">
                    <a href="{{ route('dashboard') }}" class="flex items-center space-x-3">
                        <img src="{{ asset('image/jataselangor.png') }}"
                             class="h-10 w-auto"
                             alt="Jata Selangor">

                        <div class="leading-tight">
                            <div class="text-sm font-bold text-gray-900">
                                PEJABAT DAERAH DAN TANAH KLANG
                            </div>
                            <div class="text-xs text-gray-600 -mt-1">
                                Sistem Pemantauan Aset ICT
                            </div>
                        </div>
                    </a>
                </div>

                <!-- Navigation Links (DESKTOP) -->
<div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">

    <!-- Dashboard (SEMUA ROLE) -->
    <a href="{{ route('dashboard') }}"
       class="inline-flex items-center h-16 px-1 pt-1 border-b-2
       {{ request()->routeIs('dashboard')
            ? 'border-indigo-500 text-gray-900'
            : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}
       text-sm font-medium">
        Dashboard
    </a>

    {{-- ================= ADMIN ================= --}}
    @if(auth()->user()->role === 'admin')
        <a href="{{ route('admin.users.index') }}"
           class="inline-flex items-center h-16 px-1 pt-1 border-b-2
           {{ request()->routeIs('admin.users.*')
                ? 'border-indigo-500 text-gray-900'
                : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}
           text-sm font-medium">
            Senarai Pengguna
        </a>
    @endif

    {{-- ================= ICT ================= --}}
    @if(auth()->user()->role === 'ict')

        <!-- Peralatan -->
        <a href="{{ route('ict.assets.index') }}"
           class="inline-flex items-center h-16 px-1 pt-1 border-b-2
           {{ request()->routeIs('ict.assets.*')
                ? 'border-indigo-500 text-gray-900'
                : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}
           text-sm font-medium">
            Peralatan
        </a>

        <!-- Aduan -->
        <a href="{{ route('ict.aduan.index') }}"
           class="inline-flex items-center h-16 px-1 pt-1 border-b-2
           {{ request()->routeIs('ict.aduan.*')
                ? 'border-indigo-500 text-gray-900'
                : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}
           text-sm font-medium">
            Aduan
        </a>

        <!-- LAPORAN (DROPDOWN – ICT SAHAJA) -->
        <div class="relative group">

            <div
                class="inline-flex items-center h-16 px-1 pt-1 border-b-2
                {{ request()->routeIs('ict.laporan.*')
                    ? 'border-indigo-500 text-gray-900'
                    : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}
                text-sm font-medium cursor-pointer select-none">

                Laporan
                <svg class="ml-1 h-4 w-4 text-gray-400" fill="none"
                     stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          stroke-width="2" d="M19 9l-7 7-7-7"/>
                </svg>
            </div>

            <!-- Dropdown -->
            <div
                class="absolute left-0 top-full w-56 bg-white border border-gray-200
                rounded-md shadow-lg opacity-0 invisible
                group-hover:opacity-100 group-hover:visible
                transition-all duration-200 z-50">

                <a href="{{ route('ict.laporan.aduan') }}"
                   class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                    Laporan Aduan
                </a>

                <a href="{{ route('ict.laporan.aset_rosak') }}"
                   class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                    Laporan Aset Rosak
                </a>

                <a href="{{ route('ict.laporan.aset_usang') }}"
                   class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                    Laporan Aset Usang
                </a>
            </div>
        </div>

    @endif
            </div>
            </div>

            <!-- User Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button
                            class="inline-flex items-center px-3 py-2 border border-transparent
                            text-sm leading-4 font-medium rounded-md text-gray-500 bg-white
                            hover:text-gray-700 focus:outline-none transition">
                            <div>{{ Auth::user()->name }}</div>

                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4"
                                     xmlns="http://www.w3.org/2000/svg"
                                     viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                          d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                          clip-rule="evenodd"/>
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')"
                                onclick="event.preventDefault(); this.closest('form').submit();">
                                Log Out
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>
        </div>
    </div>

    <!-- Mobile Navigation (RINGKAS – TIADA DROPDOWN LAPORAN) -->
    <div class="sm:hidden border-t border-gray-200">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')">
                Dashboard
            </x-responsive-nav-link>

            @if(auth()->user()->role === 'admin')
                <x-responsive-nav-link :href="route('admin.users.index')">
                    Senarai Pengguna
                </x-responsive-nav-link>
            @endif

            @if(auth()->user()->role === 'ict')
                <x-responsive-nav-link :href="route('ict.assets.index')">
                    Peralatan
                </x-responsive-nav-link>
           
                <x-responsive-nav-link :href="route('ict.aduan.index')">
                    Aduan
                </x-responsive-nav-link>

            @endif
        </div>
    </div>
</nav>
