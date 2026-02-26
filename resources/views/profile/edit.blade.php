<x-app-layout>
    <div class="max-w-xl mx-auto mt-10 p-6 bg-white rounded shadow">

<form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                @csrf
            @method('PUT')

            <div class="mb-4">
                <label>Name</label>
                <input type="text" name="name" value="{{ old('name', $user->name) }}"
                    class="w-full border rounded px-3 py-2">
                @error('name') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
            </div>

            <div class="mb-4">
                <label>Username</label>
                <input type="text" name="username" value="{{ old('username', $user->username) }}"
                    class="w-full border rounded px-3 py-2">
                @error('username') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
            </div>

            <div class="mb-4">
                <label>Email</label>
                <input type="email" name="email" value="{{ old('email', $user->email) }}"
                    class="w-full border rounded px-3 py-2">
                @error('email') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
            </div>

            <div class="mb-4">
                <label>New Password (leave blank to keep current)</label>
                <input type="password" name="password" class="w-full border rounded px-3 py-2">
                @error('password') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
            </div>

            <div class="mb-4">
                <label>Confirm Password</label>
                <input type="password" name="password_confirmation" class="w-full border rounded px-3 py-2">
            </div>

            <div class="mb-4">
                <label>Profile Photo</label>
                <input type="file" name="photo" class="w-full">
                @error('photo') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
            </div>

<button type="submit" style="background-color: blue; color: white; padding: 8px 16px; border-radius: 4px; cursor: pointer;">Save</button>        </form>
    </div>
</x-app-layout>