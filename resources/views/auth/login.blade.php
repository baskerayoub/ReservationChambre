<x-guest-layout>
    @if (session('status'))
        <div class="mb-4 text-sm font-medium text-emerald-600">{{ session('status') }}</div>
    @endif

    <div class="mb-6">
        <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Welcome back</h2>
        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Sign in to manage your bookings</p>
    </div>

    <form method="POST" action="{{ route('login') }}" class="space-y-5">
        @csrf

        <div>
            <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">Email</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username"
                   class="w-full rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-amber-500 focus:ring-amber-500" />
            @error('email')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
        </div>

        <div>
            <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">Password</label>
            <input id="password" type="password" name="password" required autocomplete="current-password"
                   class="w-full rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-amber-500 focus:ring-amber-500" />
            @error('password')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
        </div>

        <div class="flex items-center justify-between">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-amber-500 shadow-sm focus:ring-amber-500" name="remember">
                <span class="ms-2 text-sm text-gray-600 dark:text-gray-400">Remember me</span>
            </label>
            @if (Route::has('password.request'))
                <a class="text-sm font-medium text-amber-600 dark:text-amber-400 hover:text-amber-700 transition-colors" href="{{ route('password.request') }}">Forgot password?</a>
            @endif
        </div>

        <button type="submit" class="w-full py-3 bg-gradient-to-r from-amber-500 to-orange-500 text-white font-semibold rounded-xl hover:from-amber-600 hover:to-orange-600 shadow-lg shadow-amber-500/25 transition-all">
            <i class="fas fa-sign-in-alt mr-2"></i> Sign In
        </button>

        <p class="text-center text-sm text-gray-500 dark:text-gray-400">
            Don't have an account?
            <a href="{{ route('register') }}" class="font-semibold text-amber-600 dark:text-amber-400 hover:text-amber-700">Create one</a>
        </p>
    </form>
</x-guest-layout>
