<x-app-layout>
    <x-slot name="header">
        MES COLOCATIONS
    </x-slot>

    <x-slot name="headerAction">
        <a href="{{ route('colocations.create') }}"
            class="bg-[#5a4fcf] text-white px-5 py-2 rounded-xl text-sm font-semibold hover:bg-[#4a3fbf] transition-colors shadow-sm flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            Nouvelle colocation
        </a>
    </x-slot>

    <div class="max-w-7xl mx-auto mt-8 sm:px-6 lg:px-8">
        <div
            class="bg-white rounded-3xl shadow-sm border border-gray-100 p-16 flex flex-col items-center justify-center min-h-[400px]">
            <div class="w-20 h-20 bg-gray-50 rounded-2xl flex items-center justify-center mb-6">
                <svg class="w-10 h-10 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
                    </path>
                </svg>
            </div>

            <h3 class="text-xl font-bold text-gray-400 mb-2">Aucune colocation</h3>
            <p class="text-gray-400 text-sm">Commencez par en créer une nouvelle.</p>
        </div>
    </div>
</x-app-layout>