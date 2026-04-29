<x-app-layout>
    <x-slot name="header">
        <div>
            <div class="flex items-center gap-2 text-sm text-gray-500">
                <a href="{{ route('admin.chambres.index') }}" class="hover:text-blue-600 transition-colors">Rooms</a>
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" /></svg>
                <span class="text-gray-900 font-medium">Add Room</span>
            </div>
            <h2 class="mt-1 text-xl font-bold text-gray-900">Add New Room</h2>
        </div>
    </x-slot>

    <div class="py-8 animate-fade-in">
        <div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8">
            <form method="POST" action="{{ route('admin.chambres.store') }}" class="card p-6 space-y-6">
                @csrf
                @include('chambres._form')
                <div class="flex items-center justify-end gap-3 border-t border-gray-100 pt-6">
                    <a href="{{ route('admin.chambres.index') }}" class="btn-secondary">Cancel</a>
                    <x-primary-button>
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" /></svg>
                        Create Room
                    </x-primary-button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
