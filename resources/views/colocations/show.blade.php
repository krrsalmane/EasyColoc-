<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center uppercase tracking-wide">
            {{ $colocation->name }}
        </div>
    </x-slot>

    <x-slot name="headerAction">
        <div class="flex items-center gap-4">
            @if(auth()->id() === $colocation->owner_id)
                <form method="POST" action="{{ route('colocations.cancel', $colocation) }}" class="inline-block">
                    @csrf
                    <button type="submit"
                        class="flex items-center gap-2 text-red-500 font-semibold text-sm hover:text-red-700 transition-colors"
                        onclick="return confirm('Annuler cette colocation ?')">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Annuler la colocation
                    </button>
                </form>
            @else
                <form method="POST" action="{{ route('colocations.leave', $colocation) }}" class="inline-block">
                    @csrf
                    <button type="submit"
                        class="flex items-center gap-2 text-red-500 font-semibold text-sm hover:text-red-700 transition-colors"
                        onclick="return confirm('Quitter cette colocation ?')">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1">
                            </path>
                        </svg>
                        Quitter la colocation
                    </button>
                </form>
            @endif

            <a href="{{ route('dashboard') }}"
                class="bg-[#1a1b2e] text-white px-5 py-2 rounded-xl text-sm font-semibold hover:bg-gray-800 transition-colors shadow-sm flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Retour
            </a>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto" x-data="{ inviteModal: false }">

        @if(session('success'))
            <p class="text-green-600 mb-6 bg-green-50 rounded-lg p-3 text-sm font-medium border border-green-100 shadow-sm">
                {{ session('success') }}</p>
        @endif
        @if(session('error'))
            <p class="text-red-500 mb-6 bg-red-50 rounded-lg p-3 text-sm font-medium border border-red-100 shadow-sm">
                {{ session('error') }}</p>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Left Side: Expenses -->
            <div class="lg:col-span-2">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-xl font-bold text-[#1a1b2e]">Dépenses récentes</h3>
                    <div class="flex items-center gap-2">
                        <a href="{{ route('expenses.create', $colocation) }}"
                            class="bg-[#5a4fcf] text-white px-4 py-2 rounded-xl text-sm font-semibold hover:bg-[#4a3fbf] transition-colors flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 4v16m8-8H4"></path>
                            </svg>
                            Ajouter
                        </a>
                        <a href="{{ route('expenses.index', $colocation) }}"
                            class="bg-white border border-gray-200 text-gray-600 px-4 py-2 rounded-xl text-sm font-semibold hover:bg-gray-50 transition-colors">
                            Voir tout
                        </a>
                    </div>
                </div>

                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-gray-50/50 border-b border-gray-100">
                                <th class="p-5 text-xs font-semibold text-gray-400 tracking-wider uppercase">Titre /
                                    Catégorie</th>
                                <th class="p-5 text-xs font-semibold text-gray-400 tracking-wider uppercase">Payeur</th>
                                <th class="p-5 text-xs font-semibold text-gray-400 tracking-wider uppercase">Montant
                                </th>
                                <th class="p-5 text-xs font-semibold text-gray-400 tracking-wider uppercase">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(isset($expenses) && $expenses->count() > 0)
                                @foreach($expenses as $expense)
                                    <tr class="border-b border-gray-50 last:border-0 hover:bg-gray-50/50 transition-colors">
                                        <td class="p-5">
                                            <p class="font-bold text-[#1a1b2e]">{{ $expense->title }}</p>
                                            <p class="text-xs text-[#5a4fcf] font-semibold mt-0.5">
                                                {{ $expense->category->name ?? '—' }}</p>
                                        </td>
                                        <td class="p-5 text-sm font-medium text-gray-600">{{ $expense->user->name }}</td>
                                        <td class="p-5 text-sm font-bold text-[#1a1b2e]">
                                            {{ number_format($expense->amount, 2) }} €</td>
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
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="4" class="p-10 text-center text-gray-400 text-sm font-medium">
                                        Aucune dépense pour le moment.
                                        <a href="{{ route('expenses.create', $colocation) }}"
                                            class="text-[#5a4fcf] font-semibold hover:underline ml-1">Ajouter une dépense
                                            →</a>
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>

                <!-- Categories Panel -->
                <div class="mt-8">
                    <h3 class="text-lg font-bold text-[#1a1b2e] mb-4">Catégories de dépenses</h3>

                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5">
                        @if($categories->count() > 0)
                            <ul class="divide-y divide-gray-100 mb-5">
                                @foreach($categories as $cat)
                                    <li class="flex items-center gap-3 py-2.5">
                                        <span class="w-2 h-2 rounded-full bg-[#5a4fcf] shrink-0"></span>
                                        <span class="text-gray-700 font-medium text-sm">{{ $cat->name }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            <p class="text-gray-400 text-sm mb-4">Aucune catégorie pour le moment.</p>
                        @endif

                        @if(auth()->id() === $colocation->owner_id)
                            <form method="POST" action="{{ route('colocations.storeCategory', $colocation) }}" class="flex gap-2 mt-1">
                                @csrf
                                <input type="text" name="name" required placeholder="Ex: Loyer, Courses, Électricité..." class="flex-1 border border-gray-200 rounded-xl px-4 py-2.5 text-sm text-gray-800 focus:outline-none focus:border-[#5a4fcf] focus:ring-2 focus:ring-[#5a4fcf]/20 transition-all">
                                <button type="submit" class="bg-[#5a4fcf] text-white px-4 py-2.5 rounded-xl text-sm font-semibold hover:bg-[#4a3fbf] transition-colors whitespace-nowrap">
                                    Ajouter
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Right Side: Members -->
            <div class="space-y-8">

                <!-- "Qui doit à qui" quick link -->
                <div>
                    <h3 class="text-xl font-bold text-[#1a1b2e] mb-4">Remboursements</h3>
                    <a href="{{ route('expenses.index', $colocation) }}"
                        class="flex items-center justify-between bg-white rounded-2xl shadow-sm border border-gray-100 p-5 hover:bg-gray-50 transition-colors group">
                        <div>
                            <p class="font-semibold text-[#1a1b2e] text-sm">Voir les soldes & qui doit à qui</p>
                            <p class="text-xs text-gray-400 mt-0.5">Balances, remboursements, marquer payé</p>
                        </div>
                        <svg class="w-5 h-5 text-[#5a4fcf] group-hover:translate-x-1 transition-transform" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7">
                            </path>
                        </svg>
                    </a>
                </div>

                <!-- Members -->
                <div class="bg-[#1a1b2e] rounded-2xl p-6 shadow-md text-white">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="font-bold text-lg">Membres de la coloc</h3>
                        <span
                            class="text-[10px] font-bold tracking-wider bg-[#2a2b42] text-white px-2.5 py-1 rounded-lg uppercase">ACTIFS</span>
                    </div>

                    <div class="space-y-3 mb-6">
                        @foreach($colocation->members()->wherePivotNull('left_at')->get() as $member)
                            <div
                                class="flex items-center justify-between bg-[#24253a] rounded-xl p-3 border border-[#343552]">
                                <div class="flex items-center gap-3">
                                    <div
                                        class="h-10 w-10 rounded-full bg-white text-[#1a1b2e] flex items-center justify-center font-bold text-sm shadow-sm shrink-0">
                                        {{ substr($member->name, 0, 1) }}
                                    </div>
                                    <div class="flex flex-col">
                                        <span class="font-bold text-white text-sm tracking-wide">{{ $member->name }}</span>
                                        <div class="flex items-center gap-1 mt-0.5">
                                            @if($member->pivot->role === 'owner')
                                                <svg class="w-3 h-3 text-[#ffbd2d]" fill="currentColor" viewBox="0 0 20 20">
                                                    <path
                                                        d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                                                    </path>
                                                </svg>
                                                <span
                                                    class="text-[10px] text-[#ffbd2d] uppercase font-bold tracking-wider">OWNER</span>
                                            @else
                                                <span
                                                    class="text-[10px] text-gray-400 uppercase font-bold tracking-wider">MEMBER</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                @if(auth()->id() === $colocation->owner_id && $member->id !== $colocation->owner_id)
                                    <form method="POST"
                                        action="{{ route('colocations.removeMember', [$colocation, $member]) }}">
                                        @csrf
                                        <button type="submit" class="text-[#00c896] hover:text-white transition-colors"
                                            onclick="return confirm('Retirer ce membre ?')">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1">
                                                </path>
                                            </svg>
                                        </button>
                                    </form>
                                @endif
                            </div>
                        @endforeach
                    </div>

                    @if(auth()->id() === $colocation->owner_id)
                        <button @click="inviteModal = true"
                            class="w-full bg-white/5 hover:bg-white/10 text-white border border-white/10 rounded-xl px-4 py-3 text-sm font-semibold transition-colors flex items-center justify-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z">
                                </path>
                            </svg>
                            Inviter un membre
                        </button>
                    @endif
                </div>
            </div>
        </div>

        <!-- Invite Modal -->
        <div x-show="inviteModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black/50"
            style="display: none;">
            <div @click.away="inviteModal = false" class="bg-white rounded-3xl p-8 max-w-lg w-full mx-4 shadow-2xl"
                x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 scale-95"
                x-transition:enter-end="opacity-100 scale-100" x-transition:leave="transition ease-in duration-150"
                x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95">
                <h2 class="text-2xl font-extrabold text-[#1a1b2e] mb-6 tracking-tight">Inviter un membre</h2>
                <form method="POST" action="{{ route('colocations.invite', $colocation) }}">
                    @csrf
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-semibold mb-2">Email du membre</label>
                        <input type="email" name="email" required placeholder="user@example.com"
                            class="w-full border border-gray-200 rounded-xl px-4 py-3 text-gray-800 focus:outline-none focus:border-[#5a4fcf] focus:ring-2 focus:ring-[#5a4fcf]/20 transition-shadow">
                        <p class="text-xs text-gray-400 mt-2">Un email avec un lien d'invitation sera envoyé.</p>
                    </div>
                    <div class="flex items-center justify-end gap-4 mt-6">
                        <button type="button" @click="inviteModal = false"
                            class="text-gray-600 px-5 py-2.5 rounded-xl text-sm font-semibold hover:bg-gray-50 border border-transparent hover:border-gray-200 transition-colors">Annuler</button>
                        <button type="submit"
                            class="bg-[#5a4fcf] text-white px-6 py-2.5 rounded-xl text-sm font-semibold hover:bg-[#4a3fbf] transition-colors shadow-sm">Envoyer
                            l'invitation</button>
                    </div>
                </form>
            </div>
        </div>

    </div>
</x-app-layout>
