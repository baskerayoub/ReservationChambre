<x-guest-layout>
    <div class="mb-6">
        <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Confirm Password</h2>
        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Please confirm your password before continuing.</p>
    </div>
    <form method="POST" action="{{ route('password.confirm') }}" class="space-y-5">
        @csrf
        <div>
            <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">Password</label>
            <input id="password" type="password" name="password" required autocomplete="current-password"
                   class="w-full rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-amber-500 focus:ring-amber-500" />
            @error('password')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
        </div>
        <button type="submit" class="w-full py-3 bg-gradient-to-r from-amber-500 to-orange-500 text-white font-semibold rounded-xl">Confirm</button>
    </form>
</x-guest-layout>
