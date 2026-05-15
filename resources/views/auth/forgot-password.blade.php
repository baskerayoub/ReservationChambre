<x-guest-layout>
    <div class="mb-6">
        <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Forgot Password</h2>
        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Enter your email and we'll send you a reset link</p>
    </div>

    @if (session('status'))
        <div class="mb-4 text-sm font-medium text-emerald-600">{{ session('status') }}</div>
    @endif

    <form method="POST" action="{{ route('password.email') }}" class="space-y-5">
        @csrf
        <div>
            <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">Email</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                   class="w-full rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-amber-500 focus:ring-amber-500" />
            @error('email')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
        </div>
        <button type="submit" class="w-full py-3 bg-gradient-to-r from-amber-500 to-orange-500 text-white font-semibold rounded-xl hover:from-amber-600 hover:to-orange-600 shadow-lg shadow-amber-500/25 transition-all">
            Send Reset Link
        </button>
        <p class="text-center text-sm text-gray-500 dark:text-gray-400">
            <a href="{{ route('login') }}" class="font-semibold text-amber-600 dark:text-amber-400">Back to Sign In</a>
        </p>
    </form>
</x-guest-layout>
