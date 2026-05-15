<x-guest-layout>
    <div class="mb-6">
        <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Reset Password</h2>
    </div>
    <form method="POST" action="{{ route('password.store') }}" class="space-y-5">
        @csrf
        <input type="hidden" name="token" value="{{ $request->route('token') }}">
        <div>
            <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">Email</label>
            <input id="email" type="email" name="email" value="{{ old('email', $request->email) }}" required autofocus
                   class="w-full rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-amber-500 focus:ring-amber-500" />
            @error('email')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
        </div>
        <div>
            <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">New Password</label>
            <input id="password" type="password" name="password" required
                   class="w-full rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-amber-500 focus:ring-amber-500" />
            @error('password')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
        </div>
        <div>
            <label for="password_confirmation" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">Confirm Password</label>
            <input id="password_confirmation" type="password" name="password_confirmation" required
                   class="w-full rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-amber-500 focus:ring-amber-500" />
        </div>
        <button type="submit" class="w-full py-3 bg-gradient-to-r from-amber-500 to-orange-500 text-white font-semibold rounded-xl">Reset Password</button>
    </form>
</x-guest-layout>
