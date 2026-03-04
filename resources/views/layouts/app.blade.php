<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'EasyColoc') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=poppins:400,500,600,700&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- AlpineJS (if not fully loaded by Jetstream) -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <!-- Styles -->
    @livewireStyles
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }
    </style>
</head>

<body class="font-sans antialiased bg-[#f8f9fa] text-gray-800 flex h-screen overflow-hidden">

    <!-- Sidebar -->
    <aside class="w-64 bg-white border-r border-gray-100 flex flex-col justify-between hidden md:flex h-full shadow-sm">
        <div>
            <!-- Logo -->
            <div class="h-20 flex items-center px-8 border-b border-gray-50">
                <a href="{{ route('dashboard') }}" class="flex items-center gap-2 text-[#3b3a5d] font-bold text-xl">
                    <svg class="w-6 h-6 text-[#5a4fcf]" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 2L2 12h3v8h6v-6h2v6h6v-8h3L12 2z" />
                    </svg>
                    EasyColoc
                </a>
            </div>

            <!-- Navigation Links -->
            <nav class="p-4 space-y-1 mt-4">
                <a href="{{ route('dashboard') }}"
                    class="flex items-center gap-3 px-4 py-3 rounded-xl transition-colors {{ request()->routeIs('dashboard') ? 'bg-[#f0effa] text-[#5a4fcf] font-semibold' : 'text-gray-500 hover:bg-gray-50 hover:text-gray-900' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z"></path>
                    </svg>
                    Dashboard
                </a>

                <a href="{{ route('colocations.index') ?? '#' }}"
                    class="flex items-center gap-3 px-4 py-3 rounded-xl transition-colors {{ request()->routeIs('colocations.*') ? 'bg-[#f0effa] text-[#5a4fcf] font-semibold' : 'text-gray-500 hover:bg-gray-50 hover:text-gray-900' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
                        </path>
                    </svg>
                    Colocations
                </a>

                @if(auth()->user()->is_admin)
                    <a href="{{ route('admin.dashboard') }}"
                        class="flex items-center gap-3 px-4 py-3 rounded-xl transition-colors {{ request()->routeIs('admin.*') ? 'bg-[#f0effa] text-[#5a4fcf] font-semibold' : 'text-gray-500 hover:bg-gray-50 hover:text-gray-900' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z">
                            </path>
                        </svg>
                        Admin
                    </a>
                @endif

                <a href="{{ route('profile.show') }}"
                    class="flex items-center gap-3 px-4 py-3 rounded-xl transition-colors {{ request()->routeIs('profile.show') ? 'bg-[#f0effa] text-[#5a4fcf] font-semibold' : 'text-gray-500 hover:bg-gray-50 hover:text-gray-900' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                    Profile
                </a>
            </nav>
        </div>

        <div class="p-6">
            <!-- Reputation Card -->
            <div class="bg-[#1a1b2e] rounded-xl p-4 mb-4 text-white shadow-lg">
                <p class="text-xs text-gray-400 uppercase tracking-wider mb-1 font-semibold">Votre réputation</p>
                <div class="flex items-baseline gap-1">
                    <span class="text-2xl font-bold text-[#5ce1e6]">+{{ auth()->user()->reputation_score ?? 0 }}</span>
                    <span class="text-sm text-gray-400">points</span>
                </div>
                <div class="h-1 w-full bg-gray-700 rounded-full mt-2 overflow-hidden">
                    <div class="h-full bg-[#5ce1e6]"
                        style="width: {{ min(100, max(0, (auth()->user()->reputation_score ?? 0) * 10)) }}%"></div>
                </div>
            </div>

            <!-- Logout -->
            <form method="POST" action="{{ route('logout') }}" x-data>
                @csrf
                <button type="submit"
                    class="flex items-center gap-3 text-red-500 hover:text-red-600 transition-colors w-full px-2 py-2 font-medium">
                    <svg class="w-5 h-5 transform rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1">
                        </path>
                    </svg>
                    Déconnexion
                </button>
            </form>
        </div>
    </aside>

    <!-- Main Content -->
    <div class="flex-1 flex flex-col h-screen overflow-hidden">

        <!-- Mobile Header (Visible only on small screens) -->
        <div class="md:hidden bg-white border-b border-gray-100 flex items-center justify-between p-4"
            x-data="{ open: false }">
            <a href="{{ route('dashboard') }}" class="flex items-center gap-2 text-[#3b3a5d] font-bold text-lg">
                <svg class="w-6 h-6 text-[#5a4fcf]" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M12 2L2 12h3v8h6v-6h2v6h6v-8h3L12 2z" />
                </svg>
                EasyColoc
            </a>
            <button @click="open = !open" class="text-gray-500 hover:text-gray-700">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16">
                    </path>
                </svg>
            </button>

            <!-- Mobile Menu Dropdown (Simplified) -->
            <div x-show="open" @click.away="open = false"
                class="absolute top-16 left-0 right-0 bg-white border-b border-gray-100 shadow-lg z-50 p-4 space-y-2 hidden"
                :class="{'hidden': !open}">
                <a href="{{ route('dashboard') }}"
                    class="block px-4 py-2 rounded-lg text-gray-700 hover:bg-gray-50">Dashboard</a>
                <a href="{{ route('colocations.index') ?? '#' }}"
                    class="block px-4 py-2 rounded-lg text-gray-700 hover:bg-gray-50">Colocations</a>
                <a href="{{ route('profile.show') }}"
                    class="block px-4 py-2 rounded-lg text-gray-700 hover:bg-gray-50">Profile</a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                        class="block w-full text-left px-4 py-2 rounded-lg text-red-500 hover:bg-red-50">Déconnexion</button>
                </form>
            </div>
        </div>

        <!-- Top Header -->
        <header class="bg-white border-b border-[#f0f0f5] h-20 flex items-center justify-between px-8 shrink-0">
            <div class="flex items-center gap-6">
                @if (isset($header))
                    <h2 class="text-xl font-bold text-[#1a1b2e] uppercase tracking-wide">
                        {{ $header }}
                    </h2>
                @endif

                @if (isset($headerAction))
                    {{ $headerAction }}
                @endif
            </div>

            <div class="flex items-center gap-4">
                <!-- User Profile -->
                <a href="{{ route('profile.show') }}"
                    class="flex items-center gap-3 bg-[#f8f9fa] py-1.5 px-3 rounded-full border border-gray-100 hover:bg-gray-100 transition-colors">
                    <div class="text-right hidden sm:block">
                        @if(Auth::user()->is_admin)
                            <p class="text-xs text-[#5a4fcf] font-bold uppercase tracking-wider mb-0.5">Admin <span
                                    class="text-[10px] text-green-500 font-normal tracking-normal ml-1">En ligne</span></p>
                        @else
                            <p class="text-xs text-gray-400 font-semibold uppercase tracking-wider mb-0.5">En ligne</p>
                        @endif
                        <p class="text-sm font-semibold text-gray-700 leading-none">{{ Auth::user()->name }}</p>
                    </div>
                    @if(Auth::user()->photo)
                        <img class="h-9 w-9 rounded-full object-cover border-2 border-white shadow-sm"
                            src="{{ Storage::url(Auth::user()->photo) }}" alt="{{ Auth::user()->name }}" />
                    @else
                        <div
                            class="h-9 w-9 rounded-full bg-[#1a1b2e] text-white flex items-center justify-center font-bold text-sm shadow-sm">
                            {{ substr(Auth::user()->name, 0, 1) }}
                        </div>
                    @endif
                </a>
            </div>

        </header>

        <!-- Page Content -->
        <main class="flex-1 overflow-y-auto p-4 md:p-8 bg-[#f8f9fa]">
            {{ $slot }}
        </main>
    </div>

    @stack('modals')

    @livewireScripts
</body>

</html>