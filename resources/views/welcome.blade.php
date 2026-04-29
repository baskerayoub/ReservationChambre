<x-app-layout>
    <div class="py-8">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="card p-8 text-center">
                <h1 class="text-3xl font-bold text-gray-900">Welcome to Family Hotel</h1>
                <p class="mt-3 text-gray-500 max-w-lg mx-auto">Your home away from home. Browse our rooms, book your stay, and enjoy premium comfort for the whole family.</p>
                <a href="{{ route('chambres.index') }}" class="btn-primary mt-6 inline-flex">
                    Browse Rooms
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
