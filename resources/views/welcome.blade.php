<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'EasyColoc') }} - Simplifiez votre colocation</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=poppins:400,500,600,700,800&display=swap" rel="stylesheet" />
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }
    </style>
</head>

<body class="bg-[#f8f9fa] text-gray-800 antialiased overflow-x-hidden">

    <!-- Navbar -->
    <nav class="absolute w-full top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-20">
                <div class="flex items-center gap-2 text-[#3b3a5d] font-bold text-2xl tracking-tight">
                    <svg class="w-8 h-8 text-[#5a4fcf]" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 2L2 12h3v8h6v-6h2v6h6v-8h3L12 2z" />
                    </svg>
                    EasyColoc
                </div>
                <div>
                    @if (Route::has('login'))
                        <div class="flex gap-4">
                            @auth
                                <a href="{{ url('/dashboard') }}"
                                    class="text-[#3b3a5d] font-semibold hover:text-[#5a4fcf] transition-colors leading-10">Dashboard</a>
                            @else
                                <a href="{{ route('login') }}"
                                    class="text-[#3b3a5d] font-semibold hover:text-[#5a4fcf] transition-colors leading-10">Connexion</a>
                                @if (Route::has('register'))
                                    <a href="{{ route('register') }}"
                                        class="bg-[#5a4fcf] text-white px-5 py-2.5 rounded-xl font-semibold hover:bg-[#4a3fbf] transition-colors shadow-md">S'inscription</a>
                                @endif
                            @endauth
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <main class="relative pt-32 pb-20 lg:pt-48 lg:pb-32 overflow-hidden">
        <div class="absolute inset-0 z-[-1] bg-white">
            <div class="absolute inset-y-0 right-0 w-1/2 bg-[#f0effa] rounded-bl-[100px] hidden lg:block"></div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative">
            <div class="text-center max-w-3xl mx-auto">
                <h1 class="text-5xl md:text-6xl font-extrabold text-[#1a1b2e] tracking-tight mb-6 leading-tight">
                    Gérez votre <span
                        class="text-transparent bg-clip-text bg-gradient-to-r from-[#5a4fcf] to-[#00c896]">colocation</span>
                    sans prise de tête
                </h1>
                <p class="mt-4 text-xl text-gray-500 mb-10 max-w-2xl mx-auto">
                    Suivez vos dépenses communes, gérez les remboursements et créez une harmonie financière parfaite
                    avec vos colocataires. Tout cela sur une plateforme simple et intuitive.
                </p>
                <div class="flex justify-center flex-col sm:flex-row gap-4">
                    @auth
                        <a href="{{ url('/dashboard') }}"
                            class="bg-[#5a4fcf] text-white px-8 py-4 rounded-xl text-lg font-bold hover:bg-[#4a3fbf] transition-colors shadow-lg shadow-indigo-500/30 flex items-center justify-center gap-2">
                            Aller au Dashboard <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                            </svg>
                        </a>
                    @else
                        <a href="{{ route('register') }}"
                            class="bg-[#5a4fcf] text-white px-8 py-4 rounded-xl text-lg font-bold hover:bg-[#4a3fbf] transition-colors shadow-lg shadow-indigo-500/30 flex items-center justify-center gap-2">
                            Commencer gratuitement <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                            </svg>
                        </a>
                        <a href="{{ route('login') }}"
                            class="bg-white text-[#5a4fcf] px-8 py-4 rounded-xl text-lg font-bold border-2 border-[#5a4fcf] hover:bg-[#f8f9fa] transition-colors flex items-center justify-center">
                            J'ai déjà un compte
                        </a>
                    @endauth
                </div>
            </div>

            <!-- Dashboard Preview Graphic -->
            <div class="mt-20 flex justify-center">
                <div
                    class="w-full max-w-5xl bg-white rounded-3xl shadow-2xl border border-gray-100 p-2 overflow-hidden transform rotate-1 hover:rotate-0 transition-transform duration-500">
                    <div class="bg-[#f8f9fa] rounded-2xl h-[400px] w-full flex overflow-hidden border border-gray-100">
                        <!-- Mock Sidebar -->
                        <div class="w-48 bg-white border-r border-gray-100 p-4 hidden md:block">
                            <div class="flex items-center gap-2 mb-8">
                                <div class="w-6 h-6 bg-[#5a4fcf] rounded-md"></div>
                                <div class="h-4 w-20 bg-gray-200 rounded"></div>
                            </div>
                            <div class="space-y-3">
                                <div class="h-8 w-full bg-[#f0effa] rounded-lg"></div>
                                <div class="h-8 w-full bg-gray-50 rounded-lg"></div>
                                <div class="h-8 w-full bg-gray-50 rounded-lg"></div>
                            </div>
                        </div>
                        <!-- Mock Content -->
                        <div class="flex-1 p-8">
                            <div class="h-6 w-48 bg-gray-200 rounded mb-8"></div>
                            <div class="grid grid-cols-2 gap-6 mb-8">
                                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                                    <div class="w-10 h-10 bg-[#e6fbf7] rounded-xl mb-4"></div>
                                    <div class="h-4 w-24 bg-gray-200 rounded mb-2"></div>
                                    <div class="h-8 w-16 bg-gray-300 rounded"></div>
                                </div>
                                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                                    <div class="w-10 h-10 bg-[#f0effa] rounded-xl mb-4"></div>
                                    <div class="h-4 w-32 bg-gray-200 rounded mb-2"></div>
                                    <div class="h-8 w-24 bg-gray-300 rounded"></div>
                                </div>
                            </div>
                            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 h-32"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-white py-12 border-t border-gray-100 mt-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <div class="flex justify-center items-center gap-2 text-[#3b3a5d] font-bold text-xl tracking-tight mb-4">
                <svg class="w-6 h-6 text-[#5a4fcf]" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M12 2L2 12h3v8h6v-6h2v6h6v-8h3L12 2z" />
                </svg>
                EasyColoc
            </div>
            <p class="text-gray-400 text-sm">
                &copy; {{ date('Y') }} EasyColoc. Conçu pour simplifier votre quotidien.
            </p>
        </div>
    </footer>
</body>

</html>