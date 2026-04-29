<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">Dashboard</h2>
    </x-slot>

    <div class="py-8">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="rounded-lg bg-white p-6 shadow-sm">
                <a href="{{ route('chambres.index') }}" class="font-semibold text-gray-900 hover:text-gray-700">Browse available rooms</a>
            </div>
        </div>
    </div>
</x-app-layout>
