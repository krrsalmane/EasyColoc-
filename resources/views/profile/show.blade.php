<x-app-layout>
    <div class="max-w-xl mx-auto mt-10 p-6 bg-white rounded shadow">

        @if(session('success'))
            <p class="text-green-600 mb-4">{{ session('success') }}</p>
        @endif

        @if($user->photo)
            <img src="{{ Storage::url($user->photo) }}" class="w-24 h-24 rounded-full mb-4">
        @endif

        <p><strong>Name:</strong> {{ $user->name }}</p>
        <p><strong>Username:</strong> {{ $user->username ?? '—' }}</p>
        <p><strong>Email:</strong> {{ $user->email }}</p>
        <p><strong>Reputation:</strong> {{ $user->reputation_score }}</p>

        <a href="{{ route('profile.edit') }}" class="mt-4 inline-block bg-blue-500 text-white px-4 py-2 rounded">
            Edit Profile
        </a>
    </div>
</x-app-layout>