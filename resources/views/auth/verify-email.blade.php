<x-guest-layout>
    <div class="mb-6">
        <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Verify Email</h2>
        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Please verify your email address by clicking the link we sent you.</p>
    </div>

    @if (session('status') == 'verification-link-sent')
        <div class="mb-4 text-sm font-medium text-emerald-600">A new verification link has been sent.</div>
    @endif

    <div class="flex items-center justify-between">
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf
            <button type="submit" class="px-5 py-2.5 bg-gradient-to-r from-amber-500 to-orange-500 text-white font-semibold rounded-xl text-sm">Resend Email</button>
        </form>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="text-sm text-gray-500 hover:text-gray-700">Log Out</button>
        </form>
    </div>
</x-guest-layout>
