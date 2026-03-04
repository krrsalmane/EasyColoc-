<x-app-layout>
    <x-slot name="header">
        TABLEAU DE BORD
    </x-slot>

    <x-slot name="headerAction">
        @if(!$activeColocation)
            <a href="{{ route('colocations.create') }}"
                class="bg-[#5a4fcf] text-white px-5 py-2 rounded-xl text-sm font-semibold hover:bg-[#4a3fbf] transition-colors shadow-sm flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Nouvelle colocation
            </a>
        @else
            <a href="{{ route('colocations.show', $activeColocation) }}"
                class="bg-[#5a4fcf] text-white px-5 py-2 rounded-xl text-sm font-semibold hover:bg-[#4a3fbf] transition-colors shadow-sm flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
                    </path>
                </svg>
                Ma colocation
            </a>
        @endif
    </x-slot>

    {{-- Top Stats Cards --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
        {{-- Reputation Card --}}
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 flex flex-col justify-between">
            <div class="w-10 h-10 rounded-xl bg-[#e6fbf7] flex items-center justify-center mb-4">
                <svg class="w-5 h-5 text-[#00c896]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <p class="text-gray-500 text-sm mb-1">Mon score réputation</p>
            <p class="text-3xl font-bold text-[#1a1b2e]">{{ auth()->user()->reputation_score ?? 0 }}</p>
            <p class="text-xs text-gray-400 mt-2">+1 en quittant sans dette · -1 avec dette</p>
        </div>

        {{-- Active Colocation Card --}}
        @if($activeColocation)
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 flex flex-col justify-between">
                <div class="w-10 h-10 rounded-xl bg-[#f0effa] flex items-center justify-center mb-4">
                    <svg class="w-5 h-5 text-[#5a4fcf]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
                        </path>
                    </svg>
                </div>
                <p class="text-gray-500 text-sm mb-1">Colocation active</p>
                <p class="text-2xl font-bold text-[#1a1b2e]">{{ $activeColocation->name }}</p>
                <div class="flex gap-4 mt-2">
                    <a href="{{ route('expenses.index', $activeColocation) }}"
                        class="text-xs text-[#5a4fcf] font-semibold hover:underline">Voir les dépenses →</a>
                </div>
            </div>
        @else
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 flex flex-col justify-between">
                <div class="w-10 h-10 rounded-xl bg-gray-100 flex items-center justify-center mb-4">
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
                        </path>
                    </svg>
                </div>
                <p class="text-gray-500 text-sm mb-1">Aucune colocation active</p>
                <a href="{{ route('colocations.create') }}"
                    class="text-sm font-semibold text-[#5a4fcf] hover:underline mt-1">Créer une colocation →</a>
            </div>
        @endif
    </div>

    {{-- Main Content Area --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        {{-- Recent Expenses Table --}}
        <div class="lg:col-span-2">
            <div class="flex justify-between items-end mb-4">
                <h3 class="text-lg font-bold text-[#1a1b2e]">Dépenses récentes</h3>
                @if($activeColocation)
                    <a href="{{ route('expenses.index', $activeColocation) }}"
                        class="text-sm font-medium text-[#5a4fcf] hover:underline">Voir tout</a>
                @endif
            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-50/50 border-b border-gray-100">
                            <th class="p-4 text-xs font-semibold text-gray-400 tracking-wider uppercase">Titre /
                                Catégorie</th>
                            <th class="p-4 text-xs font-semibold text-gray-400 tracking-wider uppercase">Payeur</th>
                            <th class="p-4 text-xs font-semibold text-gray-400 tracking-wider uppercase">Montant</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if($recentExpenses && $recentExpenses->count() > 0)
                            @foreach($recentExpenses as $expense)
                                <tr class="border-b border-gray-50 last:border-0 hover:bg-gray-50/50 transition-colors">
                                    <td class="p-4">
                                        <p class="font-semibold text-[#1a1b2e] text-sm">{{ $expense->title }}</p>
                                        <p class="text-xs text-[#5a4fcf] font-semibold mt-0.5">
                                            {{ $expense->category->name ?? '—' }}</p>
                                    </td>
                                    <td class="p-4 text-sm text-gray-500">{{ $expense->user->name }}</td>
                                    <td class="p-4 text-sm font-bold text-[#1a1b2e]">{{ number_format($expense->amount, 2) }} €
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="3" class="p-8 text-center text-gray-400 text-sm">
                                    @if($activeColocation)
                                        Aucune dépense récente. <a href="{{ route('expenses.create', $activeColocation) }}"
                                            class="text-[#5a4fcf] font-semibold hover:underline">Ajouter une dépense</a>
                                    @else
                                        Rejoignez ou créez une colocation pour commencer.
                                    @endif
                                </td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Colocation Members Sidebar --}}
        <div>
            <div class="bg-[#1a1b2e] rounded-2xl p-6 shadow-md text-white">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="font-bold">Membres de la coloc</h3>
                    @if($activeColocation)
                        <span
                            class="text-[10px] font-bold tracking-wider bg-white/10 text-white px-2 py-1 rounded-md uppercase">{{ $activeColocation->members()->wherePivotNull('left_at')->count() }}
                            membres</span>
                    @else
                        <span
                            class="text-[10px] font-bold tracking-wider bg-white/10 text-white px-2 py-1 rounded-md uppercase">VIDE</span>
                    @endif
                </div>

                @if($activeColocation)
                    <div class="space-y-3">
                        @foreach($activeColocation->members()->wherePivotNull('left_at')->get() as $member)
                            <div class="flex items-center gap-3 bg-[#24253a] rounded-xl p-3 border border-[#343552]">
                                <div
                                    class="h-9 w-9 rounded-full bg-white text-[#1a1b2e] flex items-center justify-center font-bold text-sm shrink-0">
                                    {{ substr($member->name, 0, 1) }}
                                </div>
                                <div>
                                    <p class="font-semibold text-white text-sm">{{ $member->name }}</p>
                                    <p class="text-[10px] text-gray-400 uppercase font-bold tracking-wider">
                                        {{ $member->pivot->role }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <a href="{{ route('colocations.show', $activeColocation) }}"
                        class="flex items-center justify-center gap-2 w-full mt-5 text-sm font-semibold text-white bg-white/5 hover:bg-white/10 rounded-xl px-4 py-3 transition-colors border border-white/10">
                        Gérer la colocation
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </a>
                @else
                    <div class="text-center py-6 text-gray-400 text-sm">
                        Aucune colocation active.
                    </div>
                    <a href="{{ route('colocations.create') }}"
                        class="flex items-center justify-center gap-2 w-full mt-2 text-sm font-semibold text-white bg-[#5a4fcf]/80 hover:bg-[#5a4fcf] rounded-xl px-4 py-3 transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        Créer une colocation
                    </a>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>