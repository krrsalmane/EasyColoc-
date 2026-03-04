<x-app-layout>
    <x-slot name="header">
        ADMINISTRATION GLOBALE
    </x-slot>

    <div class="max-w-7xl mx-auto">

        @if(session('success'))
            <p class="text-green-600 mb-6 bg-green-50 rounded-lg p-3 text-sm font-medium border border-green-100">
                {{ session('success') }}</p>
        @endif
        @if(session('error'))
            <p class="text-red-500 mb-6 bg-red-50 rounded-lg p-3 text-sm font-medium border border-red-100">
                {{ session('error') }}</p>
        @endif

        {{-- Stats Cards --}}
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-5 mb-8">
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
                <div class="w-10 h-10 rounded-xl bg-[#f0effa] flex items-center justify-center mb-4">
                    <svg class="w-5 h-5 text-[#5a4fcf]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z">
                        </path>
                    </svg>
                </div>
                <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">Utilisateurs</p>
                <p class="text-3xl font-bold text-[#1a1b2e]">{{ $totalUsers }}</p>
            </div>

            <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
                <div class="w-10 h-10 rounded-xl bg-[#e6fbf7] flex items-center justify-center mb-4">
                    <svg class="w-5 h-5 text-[#00c896]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
                        </path>
                    </svg>
                </div>
                <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">Colocations</p>
                <p class="text-3xl font-bold text-[#1a1b2e]">{{ $totalColocations }}</p>
            </div>

            <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
                <div class="w-10 h-10 rounded-xl bg-[#fff8e6] flex items-center justify-center mb-4">
                    <svg class="w-5 h-5 text-[#ffbd2d]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                        </path>
                    </svg>
                </div>
                <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">Total Dépenses</p>
                <p class="text-3xl font-bold text-[#1a1b2e]">{{ number_format($totalExpenses, 0) }} €</p>
            </div>

            <div class="bg-white rounded-2xl p-6 shadow-sm border border-red-100">
                <div class="w-10 h-10 rounded-xl bg-red-50 flex items-center justify-center mb-4">
                    <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636">
                        </path>
                    </svg>
                </div>
                <p class="text-xs font-semibold text-red-400 uppercase tracking-wider mb-1">Utilisateurs bannis</p>
                <p class="text-3xl font-bold text-[#1a1b2e]">{{ $bannedUsers }}</p>
            </div>
        </div>

        {{-- Users Table --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="px-6 py-5 border-b border-gray-100 flex justify-between items-center">
                <h3 class="text-base font-bold text-[#1a1b2e]">Tous les utilisateurs</h3>
                <span class="text-xs text-gray-400 font-medium bg-gray-50 px-3 py-1 rounded-lg">{{ $users->total() }}
                    utilisateurs</span>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-50/50 border-b border-gray-100">
                            <th class="px-6 py-4 text-xs font-semibold text-gray-400 tracking-wider uppercase">
                                Utilisateur</th>
                            <th class="px-6 py-4 text-xs font-semibold text-gray-400 tracking-wider uppercase">Email
                            </th>
                            <th class="px-6 py-4 text-xs font-semibold text-gray-400 tracking-wider uppercase">
                                Réputation</th>
                            <th class="px-6 py-4 text-xs font-semibold text-gray-400 tracking-wider uppercase">Statut
                            </th>
                            <th class="px-6 py-4 text-xs font-semibold text-gray-400 tracking-wider uppercase">Action
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $u)
                            <tr class="border-b border-gray-50 last:border-0 hover:bg-gray-50/50 transition-colors">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="h-9 w-9 rounded-full bg-[#1a1b2e] text-white flex items-center justify-center font-bold text-sm shrink-0">
                                            {{ substr($u->name, 0, 1) }}
                                        </div>
                                        <span class="font-semibold text-[#1a1b2e]">{{ $u->name }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-500">{{ $u->email }}</td>
                                <td class="px-6 py-4">
                                    <span
                                        class="text-sm font-bold {{ $u->reputation_score >= 0 ? 'text-[#00c896]' : 'text-red-500' }}">
                                        {{ $u->reputation_score >= 0 ? '+' : '' }}{{ $u->reputation_score }} pts
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    @if($u->is_admin)
                                        <span
                                            class="px-3 py-1 text-xs font-bold rounded-lg bg-[#f0effa] text-[#5a4fcf] uppercase tracking-wide">Admin</span>
                                    @elseif($u->is_banned)
                                        <span
                                            class="px-3 py-1 text-xs font-bold rounded-lg bg-red-50 text-red-600 uppercase tracking-wide">Banni</span>
                                    @else
                                        <span
                                            class="px-3 py-1 text-xs font-bold rounded-lg bg-[#e6fbf7] text-[#00c896] uppercase tracking-wide">Actif</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    @if(!$u->is_admin)
                                        <form action="{{ route('admin.users.toggleBan', $u) }}" method="POST" class="inline">
                                            @csrf
                                            @if($u->is_banned)
                                                <button type="submit"
                                                    class="text-xs font-semibold bg-[#e6fbf7] text-[#00c896] px-3 py-1.5 rounded-lg hover:bg-[#00c896] hover:text-white transition-colors">
                                                    Débannir
                                                </button>
                                            @else
                                                <button type="submit"
                                                    class="text-xs font-semibold bg-red-50 text-red-500 px-3 py-1.5 rounded-lg hover:bg-red-500 hover:text-white transition-colors"
                                                    onclick="return confirm('Bannir {{ $u->name }} ?')">
                                                    Bannir
                                                </button>
                                            @endif
                                        </form>
                                    @else
                                        <span class="text-xs text-gray-300 font-medium italic">Admin protégé</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            @if($users->hasPages())
                <div class="px-6 py-4 border-t border-gray-100">
                    {{ $users->links() }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>