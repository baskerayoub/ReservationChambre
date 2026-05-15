@extends('layouts.app')
@section('title', 'Profile Settings')

@section('content')
<div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <h1 class="text-2xl font-bold mb-6">Profile Settings</h1>

    {{-- Update Info --}}
    <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-200 dark:border-gray-700 p-6 mb-6">
        <h3 class="text-lg font-semibold mb-4">Personal Information</h3>
        <form method="POST" action="{{ route('profile.update') }}">
            @csrf @method('PATCH')
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium mb-1">Name</label>
                    <input type="text" name="name" value="{{ old('name', $user->name) }}" required class="w-full rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring-amber-500"/>
                    @error('name')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">Email</label>
                    <input type="email" name="email" value="{{ old('email', $user->email) }}" required class="w-full rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring-amber-500"/>
                    @error('email')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                <button type="submit" class="px-6 py-2.5 bg-gradient-to-r from-amber-500 to-orange-500 text-white font-semibold rounded-xl">Save Changes</button>
            </div>
        </form>
    </div>

    {{-- Update Password --}}
    <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-200 dark:border-gray-700 p-6 mb-6">
        <h3 class="text-lg font-semibold mb-4">Change Password</h3>
        <form method="POST" action="{{ route('password.update') }}">
            @csrf @method('PUT')
            <div class="space-y-4">
                <div><label class="block text-sm font-medium mb-1">Current Password</label><input type="password" name="current_password" required class="w-full rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring-amber-500"/>@error('current_password')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror</div>
                <div><label class="block text-sm font-medium mb-1">New Password</label><input type="password" name="password" required class="w-full rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring-amber-500"/>@error('password')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror</div>
                <div><label class="block text-sm font-medium mb-1">Confirm New Password</label><input type="password" name="password_confirmation" required class="w-full rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring-amber-500"/></div>
                <button type="submit" class="px-6 py-2.5 bg-gray-800 dark:bg-gray-600 text-white font-semibold rounded-xl">Update Password</button>
            </div>
        </form>
    </div>

    {{-- Delete Account --}}
    <div class="bg-white dark:bg-gray-800 rounded-2xl border border-red-200 dark:border-red-500/20 p-6">
        <h3 class="text-lg font-semibold text-red-600 mb-2">Danger Zone</h3>
        <p class="text-sm text-gray-500 mb-4">Once your account is deleted, all of its data will be permanently removed.</p>
        <form method="POST" action="{{ route('profile.destroy') }}" onsubmit="return confirm('Are you absolutely sure? This cannot be undone.')">
            @csrf @method('DELETE')
            <div class="mb-3"><input type="password" name="password" placeholder="Enter your password to confirm" required class="w-full rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring-red-500"/></div>
            <button type="submit" class="px-6 py-2.5 bg-red-600 text-white font-semibold rounded-xl hover:bg-red-700">Delete Account</button>
        </form>
    </div>
</div>
@endsection
