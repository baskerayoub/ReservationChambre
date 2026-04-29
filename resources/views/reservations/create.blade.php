<x-app-layout>
    <x-slot name="header">
        <div>
            <div class="flex items-center gap-2 text-sm text-gray-500">
                <a href="{{ route('chambres.index') }}" class="hover:text-blue-600 transition-colors">Rooms</a>
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" /></svg>
                <span class="text-gray-900 font-medium">New Booking</span>
            </div>
            <h2 class="mt-1 text-xl font-bold text-gray-900">Book Your Stay</h2>
        </div>
    </x-slot>

    <div class="py-8 animate-fade-in">
        <div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8">
            {{-- Selected Room Preview --}}
            @if ($selectedChambre)
                <div class="card overflow-hidden mb-6 animate-fade-in-up">
                    <div class="grid sm:grid-cols-[240px_1fr]">
                        <div class="h-48 sm:h-full overflow-hidden">
                            @if ($selectedChambre->image)
                                <img src="{{ $selectedChambre->image }}" alt="Room {{ $selectedChambre->numero }}" class="h-full w-full object-cover">
                            @else
                                <div class="flex h-full items-center justify-center bg-gradient-to-br from-blue-600 to-blue-800 text-white font-bold">
                                    Room {{ $selectedChambre->numero }}
                                </div>
                            @endif
                        </div>
                        <div class="p-5 flex flex-col justify-center">
                            <p class="text-xs font-semibold uppercase tracking-wide text-blue-600">Selected Room</p>
                            <p class="mt-1 text-lg font-bold text-gray-900">
                                Room {{ $selectedChambre->numero }} — {{ $selectedChambre->type }}
                            </p>
                            <p class="mt-1 text-2xl font-extrabold text-blue-700">{{ number_format($selectedChambre->prix, 2) }} MAD<span class="text-sm font-medium text-gray-400"> / night</span></p>
                            <p class="mt-2 text-sm text-gray-500 line-clamp-2">{{ $selectedChambre->description }}</p>
                        </div>
                    </div>
                </div>
            @endif

            {{-- Booking Form --}}
            <form method="POST" action="{{ route('reservations.store') }}" class="card p-6 space-y-6 animate-fade-in-up animation-delay-200">
                @csrf
                @php($isAdminView = false)
                @include('reservations._form')

                {{-- Info Card --}}
                <div class="flex items-start gap-3 rounded-xl bg-blue-50 px-5 py-4 ring-1 ring-blue-200/50">
                    <svg class="h-5 w-5 shrink-0 text-blue-500 mt-0.5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z" />
                    </svg>
                    <div class="text-sm text-blue-800">
                        <p class="font-semibold">How it works</p>
                        <p class="mt-1 text-blue-600">The total price is calculated automatically based on the room rate and number of nights. After booking, you can pay with Stripe, PayPal, or on-site.</p>
                    </div>
                </div>

                <div class="flex items-center justify-end gap-3 border-t border-gray-100 pt-6">
                    <a href="{{ route('chambres.index') }}" class="btn-secondary">Cancel</a>
                    <x-primary-button>
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                        Confirm Booking
                    </x-primary-button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
