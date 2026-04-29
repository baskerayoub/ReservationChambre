<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h2 class="text-xl font-bold text-gray-900">
                    {{ $isAdminView ? 'Booking Management' : 'My Bookings' }}
                </h2>
                <p class="mt-1 text-sm text-gray-500">
                    {{ $isAdminView ? 'View and manage all hotel reservations' : 'Track and manage your reservations' }}
                </p>
            </div>
            @unless ($isAdminView)
                <a href="{{ route('reservations.create') }}" class="btn-primary">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                    </svg>
                    New Booking
                </a>
            @endunless
        </div>
    </x-slot>

    <div class="py-8 animate-fade-in">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="card overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-100">
                        <thead class="bg-gray-50/50">
                            <tr>
                                <th class="px-5 py-3.5 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">Room</th>
                                @if ($isAdminView)
                                    <th class="px-5 py-3.5 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">Guest</th>
                                @endif
                                <th class="px-5 py-3.5 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">Dates</th>
                                <th class="px-5 py-3.5 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">Status</th>
                                <th class="px-5 py-3.5 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">Payment</th>
                                <th class="px-5 py-3.5 text-right text-xs font-semibold uppercase tracking-wide text-gray-500">Total</th>
                                <th class="px-5 py-3.5 text-right text-xs font-semibold uppercase tracking-wide text-gray-500">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50 bg-white">
                            @forelse ($reservations as $reservation)
                                <tr class="hover:bg-blue-50/30 transition-colors duration-200">
                                    <td class="whitespace-nowrap px-5 py-4">
                                        <div class="flex items-center gap-3">
                                            <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-blue-100 text-sm font-bold text-blue-700">
                                                {{ $reservation->chambre->numero }}
                                            </div>
                                            <span class="text-sm font-semibold text-gray-900">Room {{ $reservation->chambre->numero }}</span>
                                        </div>
                                    </td>
                                    @if ($isAdminView)
                                        <td class="whitespace-nowrap px-5 py-4">
                                            <div class="flex items-center gap-2">
                                                <div class="flex h-7 w-7 items-center justify-center rounded-lg bg-gray-100 text-xs font-bold text-gray-600">
                                                    {{ strtoupper(substr($reservation->user->name, 0, 1)) }}
                                                </div>
                                                <span class="text-sm text-gray-600">{{ $reservation->user->name }}</span>
                                            </div>
                                        </td>
                                    @endif
                                    <td class="whitespace-nowrap px-5 py-4 text-sm text-gray-500">
                                        {{ $reservation->date_debut->format('M d') }} — {{ $reservation->date_fin->format('M d, Y') }}
                                    </td>
                                    <td class="whitespace-nowrap px-5 py-4">
                                        @php
                                            $badgeClass = match($reservation->status) {
                                                'pending' => 'badge-pending',
                                                'confirmed' => 'badge-confirmed',
                                                'cancelled' => 'badge-cancelled',
                                                default => 'badge-pending',
                                            };
                                        @endphp
                                        <span class="badge {{ $badgeClass }}">{{ $reservation->statusLabel() }}</span>
                                    </td>
                                    <td class="whitespace-nowrap px-5 py-4">
                                        @php
                                            $payStatus = $reservation->payment?->status ?? 'pending';
                                            $payBadge = $payStatus === 'paid' ? 'badge-paid' : 'badge-pending';
                                        @endphp
                                        <span class="badge {{ $payBadge }}">{{ ucfirst($payStatus) }}</span>
                                    </td>
                                    <td class="whitespace-nowrap px-5 py-4 text-right text-sm font-bold text-gray-900">{{ number_format($reservation->prix_total, 2) }} MAD</td>
                                    <td class="whitespace-nowrap px-5 py-4 text-right">
                                        <div class="flex justify-end gap-2">
                                            <a href="{{ route($isAdminView ? 'admin.reservations.show' : 'reservations.show', $reservation) }}" class="inline-flex items-center rounded-lg border border-gray-200 bg-white px-3 py-1.5 text-xs font-semibold text-gray-700 transition-all hover:bg-blue-50 hover:text-blue-700 hover:border-blue-200">
                                                View
                                            </a>
                                            @if ($reservation->status !== 'cancelled')
                                                <a href="{{ route($isAdminView ? 'admin.reservations.edit' : 'reservations.edit', $reservation) }}" class="inline-flex items-center rounded-lg border border-blue-200 bg-blue-50 px-3 py-1.5 text-xs font-semibold text-blue-700 transition-all hover:bg-blue-100">
                                                    Edit
                                                </a>
                                                <form method="POST" action="{{ route($isAdminView ? 'admin.reservations.destroy' : 'reservations.destroy', $reservation) }}" onsubmit="return confirm('Cancel this reservation?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="inline-flex items-center rounded-lg border border-red-200 bg-red-50 px-3 py-1.5 text-xs font-semibold text-red-700 transition-all hover:bg-red-100">
                                                        Cancel
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="{{ $isAdminView ? 7 : 6 }}" class="px-5 py-16 text-center">
                                        <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-2xl bg-blue-50 text-blue-400">
                                            <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5" />
                                            </svg>
                                        </div>
                                        <h3 class="mt-4 text-lg font-semibold text-gray-900">No bookings yet</h3>
                                        <p class="mt-2 text-sm text-gray-500">{{ $isAdminView ? 'No reservations have been made.' : 'Browse our rooms and make your first booking!' }}</p>
                                        @unless ($isAdminView)
                                            <a href="{{ route('chambres.index') }}" class="btn-primary mt-4">Browse Rooms</a>
                                        @endunless
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="mt-6">
                {{ $reservations->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
