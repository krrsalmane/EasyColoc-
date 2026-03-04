<x-app-layout>
    <x-slot name="header">MON PROFIL</x-slot>

    <x-slot name="headerAction">
        <a href="{{ route('profile.edit') }}"
            class="bg-[#5a4fcf] text-white px-5 py-2 rounded-xl text-sm font-semibold hover:bg-[#4a3fbf] transition-colors shadow-sm flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                </path>
            </svg>
            Modifier le profil
        </a>
    </x-slot>

    <div class="max-w-2xl mx-auto">

        @if(session('success'))
            <p class="text-green-600 mb-6 bg-green-50 rounded-lg p-3 text-sm font-medium border border-green-100">
                {{ session('success') }}</p>
        @endif

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">

            {{-- Profile Header --}}
            <div class="bg-[#1a1b2e] px-8 py-10 flex flex-col items-center text-center">
                @if($user->photo)
                    <img src="{{ Storage::url($user->photo) }}"
                        class="w-24 h-24 rounded-full object-cover border-4 border-white shadow-lg mb-4">
                @else
                    <div
                        class="w-24 h-24 rounded-full bg-[#5a4fcf] text-white flex items-center justify-center text-3xl font-bold shadow-lg mb-4 border-4 border-white">
                        {{ substr($user->name, 0, 1) }}
                    </div>
                @endif

                <h2 class="text-2xl font-bold text-white">{{ $user->name }}</h2>
                @if($user->username)
                    <p class="text-[#5ce1e6] text-sm font-medium mt-1">@{{ $user->username }}</p>
                @endif
                <p class="text-gray-400 text-sm mt-1">{{ $user->email }}</p>
            </div>

            {{-- Profile Info --}}
            <div class="px-8 py-6 space-y-4">
                <div class="flex items-center justify-between py-3 border-b border-gray-100">
                    <span class="text-sm font-semibold text-gray-400 uppercase tracking-wider">Nom complet</span>
                    <span class="text-sm font-bold text-[#1a1b2e]">{{ $user->name }}</span>
                </div>
                <div class="flex items-center justify-between py-3 border-b border-gray-100">
                    <span class="text-sm font-semibold text-gray-400 uppercase tracking-wider">Nom d'utilisateur</span>
                    <span class="text-sm font-bold text-[#1a1b2e]">{{ $user->username ?? '—' }}</span>
                </div>
                <div class="flex items-center justify-between py-3 border-b border-gray-100">
                    <span class="text-sm font-semibold text-gray-400 uppercase tracking-wider">Email</span>
                    <span class="text-sm font-bold text-[#1a1b2e]">{{ $user->email }}</span>
                </div>
                <div class="flex items-center justify-between py-3 border-b border-gray-100">
                    <span class="text-sm font-semibold text-gray-400 uppercase tracking-wider">Score Réputation</span>
                    <span
                        class="text-sm font-bold {{ $user->reputation_score >= 0 ? 'text-[#00c896]' : 'text-red-500' }}">
                        {{ $user->reputation_score >= 0 ? '+' : '' }}{{ $user->reputation_score }} pts
                    </span>
                </div>
                <div class="flex items-center justify-between py-3">
                    <span class="text-sm font-semibold text-gray-400 uppercase tracking-wider">Statut</span>
                    @if($user->is_admin)
                        <span
                            class="px-3 py-1 text-xs font-bold rounded-lg bg-[#f0effa] text-[#5a4fcf] uppercase tracking-wide">Admin
                            Global</span>
                    @elseif($user->is_banned)
                        <span
                            class="px-3 py-1 text-xs font-bold rounded-lg bg-red-50 text-red-500 uppercase tracking-wide">Banni</span>
                    @else
                        <span
                            class="px-3 py-1 text-xs font-bold rounded-lg bg-[#e6fbf7] text-[#00c896] uppercase tracking-wide">Actif</span>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>