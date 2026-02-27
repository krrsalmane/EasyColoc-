<x-app-layout>
    <div class="max-w-xl mx-auto mt-10 p-6 bg-white rounded shadow">
        <h2 class="text-xl font-bold mb-4">Add Expense</h2>

        <form method="POST" action="{{ route('expenses.store', $colocation) }}">
            @csrf

            <div class="mb-4">
                <label>Title</label>
                <input type="text" name="title" value="{{ old('title') }}" class="w-full border rounded px-3 py-2">
                @error('title') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
            </div>

            <div class="mb-4">
                <label>Amount (€)</label>
                <input type="number" step="0.01" name="amount" value="{{ old('amount') }}" class="w-full border rounded px-3 py-2">
                @error('amount') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
            </div>

            <div class="mb-4">
                <label>Date</label>
                <input type="date" name="date" value="{{ old('date', now()->toDateString()) }}" class="w-full border rounded px-3 py-2">
                @error('date') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
            </div>

            <div class="mb-4">
                <label>Paid by</label>
                <select name="user_id" class="w-full border rounded px-3 py-2">
                    @foreach($members as $member)
                        <option value="{{ $member->id }}" {{ old('user_id') == $member->id ? 'selected' : '' }}>
                            {{ $member->name }}
                        </option>
                    @endforeach
                </select>
                @error('user_id') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
            </div>

            <div class="mb-4">
                <label>Category</label>
                <select name="category_id" class="w-full border rounded px-3 py-2">
                    <option value="">— No category —</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Add Expense</button>
        </form>
    </div>
</x-app-layout>