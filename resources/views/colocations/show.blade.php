<x-app-layout>
    <div class="max-w-xl mx-auto mt-10 p-6 bg-white rounded shadow">

        @if(session('success'))
            <p class="text-green-600 mb-4">{{ session('success') }}</p>
        @endif
        @if(session('error'))
            <p class="text-red-500 mb-4">{{ session('error') }}</p>
        @endif

        <h2 class="text-xl font-bold mb-4">{{ $colocation->name }}</h2>
        <p>Status: {{ $colocation->status }}</p>
        <p>Owner: {{ $colocation->owner->name }}</p>

        <h3 class="font-bold mt-6 mb-2">Members</h3>
        @foreach($colocation->members as $member)
            <p>{{ $member->name }} — {{ $member->pivot->role }}</p>
        @endforeach

        @if(auth()->id() === $colocation->owner_id)
            <h3 class="font-bold mt-6 mb-2">Invite a Member</h3>
            <form method="POST" action="{{ route('colocations.invite', $colocation) }}">
                @csrf
                <input type="email" name="email" placeholder="Email" class="border rounded px-3 py-2 w-full mb-2">
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Send Invitation</button>
            </form>

            <form method="POST" action="{{ route('colocations.cancel', $colocation) }}" class="mt-4">
                @csrf
                <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded">Cancel Colocation</button>
            </form>
        @else
            <form method="POST" action="{{ route('colocations.leave', $colocation) }}" class="mt-4">
                @csrf
                <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded">Leave Colocation</button>
            </form>
        @endif
    </div>
</x-app-layout>