<x-guest-layout>
    <div class="mb-6">
        <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Create Account</h2>
        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Join Hotelia and start booking</p>
    </div>

    <form method="POST" action="{{ route('register') }}" class="space-y-5">
        @csrf

        <div>
            <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">Full Name</label>
            <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name"
                   class="w-full rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-amber-500 focus:ring-amber-500" />
            @error('name')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
        </div>

        <div>
            <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">Email</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="username"
                   class="w-full rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-amber-500 focus:ring-amber-500" />
            @error('email')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
        </div>

        <div>
            <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">Password</label>
            <input id="password" type="password" name="password" required autocomplete="new-password"
                   class="w-full rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-amber-500 focus:ring-amber-500" />
            @error('password')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
        </div>

        <div>
            <label for="password_confirmation" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">Confirm Password</label>
            <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password"
                   class="w-full rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-amber-500 focus:ring-amber-500" />
        </div>

        <button type="submit" class="w-full py-3 bg-gradient-to-r from-amber-500 to-orange-500 text-white font-semibold rounded-xl hover:from-amber-600 hover:to-orange-600 shadow-lg shadow-amber-500/25 transition-all">
            <i class="fas fa-user-plus mr-2"></i> Create Account
        </button>

        <p class="text-center text-sm text-gray-500 dark:text-gray-400">
            Already have an account?
            <a href="{{ route('login') }}" class="font-semibold text-amber-600 dark:text-amber-400 hover:text-amber-700">Sign in</a>
        </p>
    </form>
</x-guest-layout>
