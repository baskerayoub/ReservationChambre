@extends('layouts.app')
@section('title', 'My Reservations')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-3xl font-bold">My Reservations</h1>
            <p class="text-gray-500 dark:text-gray-400 mt-1">Manage your hotel bookings</p>
        </div>
        <a href="{{ route('rooms.index') }}" class="px-5 py-2.5 bg-gradient-to-r from-amber-500 to-orange-500 text-white text-sm font-semibold rounded-xl hover:from-amber-600 hover:to-orange-600 shadow-lg shadow-amber-500/25 transition-all">
            <i class="fas fa-plus mr-1"></i> New Booking
        </a>
    </div>

    @if($reservations->isEmpty())
        <div class="text-center py-20 bg-white dark:bg-gray-800 rounded-2xl border border-gray-200 dark:border-gray-700">
            <i class="fas fa-calendar-xmark text-5xl text-gray-300 dark:text-gray-600 mb-4"></i>
            <h3 class="text-xl font-semibold text-gray-500">No reservations yet</h3>
            <p class="text-gray-400 mt-1 mb-6">Start by exploring our rooms and book your perfect stay.</p>
            <a href="{{ route('rooms.index') }}" class="px-6 py-3 bg-gradient-to-r from-amber-500 to-orange-500 text-white font-semibold rounded-xl">Browse Rooms</a>
        </div>
    @else
        <div class="space-y-4">
            @foreach($reservations as $reservation)
            <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-200 dark:border-gray-700 overflow-hidden hover:shadow-lg transition-shadow">
                <div class="flex flex-col md:flex-row">
                    {{-- Room Preview --}}
                    <div class="md:w-48 h-32 md:h-auto bg-gradient-to-br from-amber-100 to-orange-100 dark:from-gray-700 dark:to-gray-600 flex items-center justify-center flex-shrink-0">
                        <i class="fas fa-bed text-3xl text-amber-300/50 dark:text-amber-500/20"></i>
                    </div>

                    {{-- Details --}}
                    <div class="flex-1 p-5">
                        <div class="flex items-start justify-between">
                            <div>
                                <h3 class="font-bold text-lg">{{ $reservation->room->name }}</h3>
                                <p class="text-sm text-gray-400 mt-0.5">Reservation #{{ $reservation->id }}</p>
                            </div>
                            @php
                                $statusColors = [
                                    'pending' => 'bg-yellow-100 text-yellow-700 dark:bg-yellow-500/10 dark:text-yellow-400',
                                    'confirmed' => 'bg-emerald-100 text-emerald-700 dark:bg-emerald-500/10 dark:text-emerald-400',
                                    'cancelled' => 'bg-red-100 text-red-700 dark:bg-red-500/10 dark:text-red-400',
                                    'completed' => 'bg-blue-100 text-blue-700 dark:bg-blue-500/10 dark:text-blue-400',
                                ];
                            @endphp
                            <span class="px-3 py-1 text-xs font-semibold rounded-full {{ $statusColors[$reservation->status] }}">
                                {{ ucfirst($reservation->status) }}
                            </span>
                        </div>

                        <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 mt-4 text-sm">
                            <div>
                                <span class="text-gray-400 text-xs block">Check-in</span>
                                <span class="font-medium">{{ $reservation->check_in->format('M d, Y') }}</span>
                            </div>
                            <div>
                                <span class="text-gray-400 text-xs block">Check-out</span>
                                <span class="font-medium">{{ $reservation->check_out->format('M d, Y') }}</span>
                            </div>
                            <div>
                                <span class="text-gray-400 text-xs block">Guests</span>
                                <span class="font-medium">{{ $reservation->guests }}</span>
                            </div>
                            <div>
                                <span class="text-gray-400 text-xs block">Total</span>
                                <span class="font-bold text-amber-600 dark:text-amber-400">${{ number_format($reservation->total_price, 2) }}</span>
                            </div>
                        </div>

                        <div class="flex items-center gap-3 mt-4 pt-4 border-t border-gray-100 dark:border-gray-700">
                            <a href="{{ route('reservations.show', $reservation) }}" class="px-4 py-2 text-sm font-medium text-amber-600 dark:text-amber-400 bg-amber-50 dark:bg-amber-500/10 rounded-lg hover:bg-amber-100 dark:hover:bg-amber-500/20 transition-colors">
                                <i class="fas fa-eye mr-1"></i> View Details
                            </a>
                            @if($reservation->status === 'pending' && !$reservation->isPaid())
                                <a href="{{ route('reservations.show', $reservation) }}" class="px-4 py-2 text-sm font-medium text-white bg-gradient-to-r from-amber-500 to-orange-500 rounded-lg">
                                    <i class="fas fa-credit-card mr-1"></i> Pay Now
                                </a>
                            @endif
                            @if($reservation->canBeCancelled())
                                <form method="POST" action="{{ route('reservations.destroy', $reservation) }}" onsubmit="return confirm('Are you sure you want to cancel?')">
                                    @csrf @method('DELETE')
                                    <button class="px-4 py-2 text-sm font-medium text-red-600 bg-red-50 dark:bg-red-500/10 rounded-lg hover:bg-red-100 dark:hover:bg-red-500/20 transition-colors">
                                        <i class="fas fa-times mr-1"></i> Cancel
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <div class="mt-8">
            {{ $reservations->links() }}
        </div>
    @endif
</div>
@endsection
