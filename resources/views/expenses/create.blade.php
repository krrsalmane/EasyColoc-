<x-app-layout>
    <x-slot name="header">
        Nouvelle dépense — {{ $colocation->name }}
    </x-slot>

    <x-slot name="headerAction">
        <a href="{{ route('expenses.index', $colocation) }}"
            class="bg-white border border-gray-200 text-gray-600 px-4 py-2 rounded-xl text-sm font-semibold hover:bg-gray-50 transition-colors flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18">
                </path>
            </svg>
            Retour aux dépenses
        </a>
    </x-slot>

    <div class="max-w-2xl mx-auto mt-4">
        <div class="bg-white rounded-2xl p-8 shadow-sm border border-gray-100">

            <form method="POST" action="{{ route('expenses.store', $colocation) }}">
                @csrf

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5 mb-5">
                    <div class="sm:col-span-2">
                        <label class="block text-gray-700 text-sm font-semibold mb-2">Titre de la dépense</label>
                        <input type="text" name="title" value="{{ old('title') }}"
                            placeholder="Ex: Courses, Loyer, Électricité..."
                            class="w-full bg-white border border-gray-200 rounded-xl px-4 py-3 text-gray-800 focus:outline-none focus:border-[#5a4fcf] focus:ring-2 focus:ring-[#5a4fcf]/20 transition-all shadow-sm">
                        @error('title') <p class="text-red-500 text-xs mt-1.5 font-medium">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-gray-700 text-sm font-semibold mb-2">Montant (€)</label>
                        <input type="number" step="0.01" name="amount" value="{{ old('amount') }}" placeholder="0.00"
                            class="w-full bg-white border border-gray-200 rounded-xl px-4 py-3 text-gray-800 focus:outline-none focus:border-[#5a4fcf] focus:ring-2 focus:ring-[#5a4fcf]/20 transition-all shadow-sm">
                        @error('amount') <p class="text-red-500 text-xs mt-1.5 font-medium">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-gray-700 text-sm font-semibold mb-2">Date</label>
                        <input type="date" name="date" value="{{ old('date', now()->toDateString()) }}"
                            class="w-full bg-white border border-gray-200 rounded-xl px-4 py-3 text-gray-800 focus:outline-none focus:border-[#5a4fcf] focus:ring-2 focus:ring-[#5a4fcf]/20 transition-all shadow-sm">
                        @error('date') <p class="text-red-500 text-xs mt-1.5 font-medium">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-gray-700 text-sm font-semibold mb-2">Payé par</label>
                        <select name="user_id"
                            class="w-full bg-white border border-gray-200 rounded-xl px-4 py-3 text-gray-800 focus:outline-none focus:border-[#5a4fcf] focus:ring-2 focus:ring-[#5a4fcf]/20 transition-all shadow-sm">
                            @foreach($members as $member)
                                <option value="{{ $member->id }}" {{ old('user_id', auth()->id()) == $member->id ? 'selected' : '' }}>
                                    {{ $member->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('user_id') <p class="text-red-500 text-xs mt-1.5 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-gray-700 text-sm font-semibold mb-2">Catégorie</label>
                        <select name="category_id"
                            class="w-full bg-white border border-gray-200 rounded-xl px-4 py-3 text-gray-800 focus:outline-none focus:border-[#5a4fcf] focus:ring-2 focus:ring-[#5a4fcf]/20 transition-all shadow-sm">
                            <option value="">— Aucune catégorie —</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="flex items-center gap-4 mt-6">
                    <button type="submit"
                        class="bg-[#5a4fcf] text-white px-6 py-3 rounded-xl text-sm font-semibold hover:bg-[#4a3fbf] transition-colors shadow-sm">
                        Enregistrer la dépense
                    </button>
                    <a href="{{ route('expenses.index', $colocation) }}"
                        class="text-gray-500 text-sm font-medium hover:text-gray-700 transition-colors">Annuler</a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>