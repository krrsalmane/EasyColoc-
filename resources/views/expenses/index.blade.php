<x-app-layout>
    <div class="max-w-4xl mx-auto mt-10 p-6 bg-white rounded shadow">

        @if(session('success'))
            <p class="text-green-600 mb-4">{{ session('success') }}</p>
        @endif

        <div class="flex justify-between items-center mb-4">
            <h2 class="text-xl font-bold">Expenses — {{ $colocation->name }}</h2>
            <a href="{{ route('expenses.create', $colocation) }}" class="bg-blue-500 text-white px-4 py-2 rounded">Add Expense</a>
        </div>

        {{-- Month filter --}}
        <form method="GET" class="mb-4">
            <input type="month" name="month" value="{{ request('month') }}" class="border rounded px-3 py-2">
            <button type="submit" class="bg-gray-500 text-white px-3 py-2 rounded">Filter</button>
            <a href="{{ route('expenses.index', $colocation) }}" class="ml-2 text-gray-500">Clear</a>
        </form>

        {{-- Expenses list --}}
        <table class="w-full text-left border mb-6">
            <thead>
                <tr class="bg-gray-100">
                    <th class="p-2">Title</th>
                    <th class="p-2">Amount</th>
                    <th class="p-2">Paid by</th>
                    <th class="p-2">Category</th>
                    <th class="p-2">Date</th>
                    <th class="p-2">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($expenses as $expense)
                <tr class="border-t">
                    <td class="p-2">{{ $expense->title }}</td>
                    <td class="p-2">{{ $expense->amount }} €</td>
                    <td class="p-2">{{ $expense->user->name }}</td>
                    <td class="p-2">{{ $expense->category->name ?? '—' }}</td>
                    <td class="p-2">{{ $expense->date }}</td>
                    <td class="p-2">
                        <form method="POST" action="{{ route('expenses.destroy', [$colocation, $expense]) }}">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-500">Delete</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" class="p-2 text-center text-gray-400">No expenses yet.</td></tr>
                @endforelse
            </tbody>
        </table>

        {{-- Balances --}}
        <h3 class="font-bold text-lg mb-2">Balances</h3>
        @foreach($data['balances'] as $balance)
        <p>
            {{ $balance['user']->name }} —
            Paid: {{ $balance['paid'] }}€ |
            Share: {{ round($balance['share'], 2) }}€ |
            Balance:
            <span class="{{ $balance['balance'] >= 0 ? 'text-green-600' : 'text-red-500' }}">
                {{ $balance['balance'] }}€
            </span>
        </p>
        @endforeach

        {{-- Who owes whom --}}
        <h3 class="font-bold text-lg mt-6 mb-2">Who owes whom</h3>
        @forelse($data['settlements'] as $s)
            <p>{{ $s['from']->name }} owes {{ $s['to']->name }} <strong>{{ $s['amount'] }}€</strong></p>
        @empty
            <p class="text-gray-400">All settled up!</p>
        @endforelse

    </div>
</x-app-layout>