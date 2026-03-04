<x-app-layout>
    <x-slot name="header">
        Dépenses — {{ $colocation->name }}
    </x-slot>

    <x-slot name="headerAction">
        <div class="flex items-center gap-3">
            <a href="{{ route('expenses.create', $colocation) }}"
                class="bg-[#5a4fcf] text-white px-5 py-2 rounded-xl text-sm font-semibold hover:bg-[#4a3fbf] transition-colors shadow-sm flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Ajouter une dépense
            </a>
            <a href="{{ route('colocations.show', $colocation) }}"
                class="bg-white border border-gray-200 text-gray-600 px-4 py-2 rounded-xl text-sm font-semibold hover:bg-gray-50 transition-colors flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Retour à la coloc
            </a>
        </div>
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

        {{-- Month Filter Bar --}}
        <div class="flex flex-col sm:flex-row gap-4 items-start sm:items-center justify-between mb-6">
            <form method="GET" class="flex items-center gap-3">
                <svg class="w-4 h-4 text-[#5a4fcf]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z">
                    </path>
                </svg>
                <span class="text-sm font-medium text-gray-600">Filtrer par mois :</span>
                <input type="month" name="month" value="{{ request('month') }}"
                    class="bg-white border border-gray-200 rounded-xl px-3 py-2 text-sm text-gray-700 focus:outline-none focus:border-[#5a4fcf] focus:ring-2 focus:ring-[#5a4fcf]/20 transition-all">
                <button type="submit"
                    class="bg-[#5a4fcf] text-white px-4 py-2 rounded-xl text-sm font-semibold hover:bg-[#4a3fbf] transition-colors">Filtrer</button>
                @if(request('month'))
                    <a href="{{ route('expenses.index', $colocation) }}"
                        class="text-sm text-gray-500 hover:text-gray-700 font-medium">Effacer</a>
                @endif
            </form>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

            {{-- LEFT: Expense Table --}}
            <div class="lg:col-span-2">
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-gray-50/50 border-b border-gray-100">
                                <th class="p-5 text-xs font-semibold text-gray-400 tracking-wider uppercase">Titre /
                                    Catégorie</th>
                                <th class="p-5 text-xs font-semibold text-gray-400 tracking-wider uppercase">Montant
                                </th>
                                <th class="p-5 text-xs font-semibold text-gray-400 tracking-wider uppercase">Payeur</th>
                                <th class="p-5 text-xs font-semibold text-gray-400 tracking-wider uppercase">Date</th>
                                <th class="p-5 text-xs font-semibold text-gray-400 tracking-wider uppercase">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($expenses as $expense)
                                <tr class="border-b border-gray-50 last:border-0 hover:bg-gray-50/50 transition-colors">
                                    <td class="p-5">
                                        <p class="font-bold text-[#1a1b2e]">{{ $expense->title }}</p>
                                        <p class="text-xs text-[#5a4fcf] font-semibold mt-0.5">
                                            {{ $expense->category->name ?? '—' }}</p>
                                    </td>
                                    <td class="p-5 text-sm font-bold text-[#1a1b2e]">
                                        {{ number_format($expense->amount, 2) }} €</td>
                                    <td class="p-5 text-sm font-medium text-gray-600">{{ $expense->user->name }}</td>
                                    <td class="p-5 text-sm text-gray-500">
                                        {{ \Carbon\Carbon::parse($expense->date)->format('d M Y') }}</td>
                                    <td class="p-5">
                                        <form method="POST"
                                            action="{{ route('expenses.destroy', [$colocation, $expense]) }}">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="text-red-500 hover:text-red-700 bg-red-50 rounded-lg p-2 transition-colors"
                                                onclick="return confirm('Supprimer cette dépense ?')">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                                    </path>
                                                </svg>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="p-10 text-center text-gray-400 text-sm font-medium">
                                        Aucune dépense enregistrée pour cette période.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- RIGHT: Balances + Settlements --}}
            <div class="space-y-6">

                {{-- Balances Card --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                    <h3 class="text-base font-bold text-[#1a1b2e] mb-4">Soldes individuels</h3>
                    <div class="space-y-3">
                        @foreach($data['balances'] as $balance)
                            <div class="flex items-center justify-between bg-gray-50 rounded-xl p-3">
                                <div class="flex flex-col">
                                    <span class="font-semibold text-sm text-[#1a1b2e]">{{ $balance['user']->name }}</span>
                                    <span class="text-xs text-gray-400 mt-0.5">Payé:
                                        {{ number_format($balance['paid'], 2) }} € · Part:
                                        {{ number_format($balance['share'], 2) }} €</span>
                                </div>
                                <span
                                    class="font-bold text-sm {{ $balance['balance'] >= 0 ? 'text-[#00c896]' : 'text-red-500' }}">
                                    {{ $balance['balance'] >= 0 ? '+' : '' }}{{ number_format($balance['balance'], 2) }} €
                                </span>
                            </div>
                        @endforeach
                    </div>
                </div>

                {{-- Settlements / Qui doit à qui --}}
                <div class="bg-[#1a1b2e] rounded-2xl p-6 text-white shadow-md">
                    <h3 class="text-base font-bold mb-4">Qui doit à qui ?</h3>
                    <div class="space-y-3 mb-5">
                        @forelse($data['settlements'] as $s)
                            <div
                                class="bg-[#24253a] rounded-xl p-3 border border-[#343552] flex items-center justify-between">
                                <div class="text-sm">
                                    <span class="text-red-400 font-semibold">{{ $s['from']->name }}</span>
                                    <span class="text-gray-400 mx-1">→</span>
                                    <span class="text-[#00c896] font-semibold">{{ $s['to']->name }}</span>
                                </div>
                                <span class="text-[#ffbd2d] font-bold text-sm">{{ number_format($s['amount'], 2) }} €</span>
                            </div>
                        @empty
                            <div
                                class="text-center text-gray-400 text-sm py-4 bg-[#24253a] rounded-xl border border-[#343552]">
                                ✓ Tous les comptes sont à jour
                            </div>
                        @endforelse
                    </div>

                    {{-- Mark as Paid --}}
                    @php $hasPayments = false; @endphp
                    @foreach($data['settlements'] as $s)
                        @if($s['from']->id === auth()->id())
                            @php $hasPayments = true; @endphp
                            <div class="bg-[#24253a] border border-red-900/50 rounded-xl p-4 mb-3">
                                <p class="text-sm mb-3 text-gray-300">Vous devez <span
                                        class="text-[#00c896] font-bold">{{ $s['to']->name }}</span> — <span
                                        class="text-[#ffbd2d] font-bold">{{ number_format($s['amount'], 2) }} €</span></p>
                                <form method="POST" action="{{ route('payments.store', $colocation) }}">
                                    @csrf
                                    <input type="hidden" name="to_user_id" value="{{ $s['to']->id }}">
                                    <input type="hidden" name="amount" value="{{ $s['amount'] }}">
                                    <button type="submit"
                                        class="w-full bg-[#00c896] text-[#1a1b2e] font-bold px-4 py-2.5 rounded-xl text-sm hover:bg-[#00b085] transition-colors">
                                        ✓ Marquer payé
                                    </button>
                                </form>
                            </div>
                        @endif
                    @endforeach
                    @if(!$hasPayments)
                        <p class="text-center text-gray-500 text-xs">Aucun paiement requis de votre part.</p>
                    @endif
                </div>

            </div>
        </div>
    </div>
</x-app-layout>