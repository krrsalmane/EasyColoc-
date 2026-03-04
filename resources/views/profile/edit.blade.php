<x-app-layout>
    <x-slot name="header">MODIFIER MON PROFIL</x-slot>

    <x-slot name="headerAction">
        <a href="{{ route('profile.show') }}"
            class="bg-white border border-gray-200 text-gray-600 px-4 py-2 rounded-xl text-sm font-semibold hover:bg-gray-50 transition-colors flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18">
                </path>
            </svg>
            Retour au profil
        </a>
    </x-slot>

    <div class="max-w-2xl mx-auto mt-4">
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">

            {{-- Current Avatar Preview --}}
            <div class="flex items-center gap-5 mb-8 pb-8 border-b border-gray-100">
                @if($user->photo)
                    <img src="{{ Storage::url($user->photo) }}"
                        class="w-20 h-20 rounded-full object-cover border-4 border-[#f0effa] shadow-sm">
                @else
                    <div
                        class="w-20 h-20 rounded-full bg-[#1a1b2e] text-white flex items-center justify-center text-2xl font-bold border-4 border-[#f0effa] shadow-sm">
                        {{ substr($user->name, 0, 1) }}
                    </div>
                @endif
                <div>
                    <p class="font-bold text-[#1a1b2e] text-lg">{{ $user->name }}</p>
                    <p class="text-gray-400 text-sm">{{ $user->email }}</p>
                </div>
            </div>

            <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5 mb-5">
                    <div>
                        <label class="block text-gray-700 text-sm font-semibold mb-2">Nom complet</label>
                        <input type="text" name="name" value="{{ old('name', $user->name) }}"
                            class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm text-gray-800 focus:outline-none focus:border-[#5a4fcf] focus:ring-2 focus:ring-[#5a4fcf]/20 transition-all">
                        @error('name') <p class="text-red-500 text-xs mt-1.5 font-medium">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-gray-700 text-sm font-semibold mb-2">Nom d'utilisateur</label>
                        <div class="relative">
                            <span
                                class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 font-medium text-sm">@</span>
                            <input type="text" name="username" value="{{ old('username', $user->username) }}"
                                placeholder="username"
                                class="w-full border border-gray-200 rounded-xl pl-7 pr-4 py-3 text-sm text-gray-800 focus:outline-none focus:border-[#5a4fcf] focus:ring-2 focus:ring-[#5a4fcf]/20 transition-all">
                        </div>
                        @error('username') <p class="text-red-500 text-xs mt-1.5 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="sm:col-span-2">
                        <label class="block text-gray-700 text-sm font-semibold mb-2">Email</label>
                        <input type="email" name="email" value="{{ old('email', $user->email) }}"
                            class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm text-gray-800 focus:outline-none focus:border-[#5a4fcf] focus:ring-2 focus:ring-[#5a4fcf]/20 transition-all">
                        @error('email') <p class="text-red-500 text-xs mt-1.5 font-medium">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-gray-700 text-sm font-semibold mb-2">Nouveau mot de passe</label>
                        <input type="password" name="password" placeholder="Laisser vide pour ne pas changer"
                            class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm text-gray-800 focus:outline-none focus:border-[#5a4fcf] focus:ring-2 focus:ring-[#5a4fcf]/20 transition-all">
                        @error('password') <p class="text-red-500 text-xs mt-1.5 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-gray-700 text-sm font-semibold mb-2">Confirmer le mot de passe</label>
                        <input type="password" name="password_confirmation" placeholder="Répétez le mot de passe"
                            class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm text-gray-800 focus:outline-none focus:border-[#5a4fcf] focus:ring-2 focus:ring-[#5a4fcf]/20 transition-all">
                    </div>

                    <div class="sm:col-span-2">
                        <label class="block text-gray-700 text-sm font-semibold mb-2">Photo de profil</label>
                        <input type="file" name="photo" accept="image/*"
                            class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm text-gray-600 focus:outline-none focus:border-[#5a4fcf] focus:ring-2 focus:ring-[#5a4fcf]/20 transition-all file:mr-4 file:py-1 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-[#f0effa] file:text-[#5a4fcf]">
                        @error('photo') <p class="text-red-500 text-xs mt-1.5 font-medium">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div class="flex items-center gap-4 mt-6">
                    <button type="submit"
                        class="bg-[#5a4fcf] text-white px-6 py-3 rounded-xl text-sm font-semibold hover:bg-[#4a3fbf] transition-colors shadow-sm">
                        Enregistrer les modifications
                    </button>
                    <a href="{{ route('profile.show') }}"
                        class="text-gray-500 text-sm font-medium hover:text-gray-700 transition-colors">Annuler</a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>