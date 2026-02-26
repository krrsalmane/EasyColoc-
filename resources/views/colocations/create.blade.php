<x-app-layout>
    <div class="max-w-xl mx-auto mt-10 p-6 bg-white rounded shadow">
        <h2 class="text-xl font-bold mb-4">Create Colocation</h2>

        @if(session('error'))
            <p class="text-red-500 mb-4">{{ session('error') }}</p>
        @endif

        <form method="POST" action="{{ route('colocations.store') }}">
            @csrf
            <div class="mb-4">
                <label>Name</label>
                <input type="text" name="name" class="w-full border rounded px-3 py-2">
                @error('name') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
            </div>
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Create</button>
        </form>
    </div>
</x-app-layout>