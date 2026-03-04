<x-app-layout>
    <x-slot name="header">
        NOUVELLE COLOCATION
    </x-slot>

    <div class="max-w-3xl mx-auto mt-8 sm:px-6 lg:px-8">
        <div class="bg-white rounded-2xl p-8 shadow-sm border border-gray-100">
            @if(session('error'))
                <p class="text-red-500 mb-6 bg-red-50 rounded-lg p-3 text-sm font-medium border border-red-100">
                    {{ session('error') }}</p>
            @endif

            <form method="POST" action="{{ route('colocations.store') }}">
                @csrf
                <div class="mb-6">
                    <label class="block text-gray-700 text-sm font-medium mb-2">Nom de la colocation</label>
                    <input type="text" name="name"
                        class="w-full bg-white border border-gray-200 rounded-xl px-4 py-3 text-gray-800 focus:outline-none focus:border-[#5a4fcf] focus:ring-2 focus:ring-[#5a4fcf]/20 transition-all shadow-sm"
                        placeholder="Ex: Ma super coloc...">
                    @error('name') <p class="text-red-500 text-xs mt-2 font-medium">{{ $message }}</p> @enderror
                </div>

                <div class="mb-8">
                    <label class="block text-gray-700 text-sm font-medium mb-2">Description (optionnelle)</label>
                    <textarea
                        class="w-full bg-white border border-gray-200 rounded-xl px-4 py-3 text-gray-800 focus:outline-none focus:border-[#5a4fcf] focus:ring-2 focus:ring-[#5a4fcf]/20 transition-all shadow-sm h-24 resize-none"
                        placeholder="Décrivez brièvement votre colocation..."></textarea>
                </div>

                <div class="flex items-center gap-4">
                    <button type="submit"
                        class="bg-[#5a4fcf] text-white px-6 py-3 rounded-xl text-sm font-semibold hover:bg-[#4a3fbf] transition-colors shadow-sm">
                        Créer la colocation
                    </button>
                    <a href="{{ route('dashboard') }}"
                        class="text-gray-500 text-sm font-medium hover:text-gray-700 transition-colors">
                        Annuler
                    </a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>