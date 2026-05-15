@extends('layouts.app')
@section('title', 'Book ' . $room->name)

@section('content')
<div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <nav class="flex items-center gap-2 text-sm text-gray-400 mb-6">
        <a href="{{ route('rooms.index') }}" class="hover:text-amber-500">Rooms</a>
        <i class="fas fa-chevron-right text-xs"></i>
        <a href="{{ route('rooms.show', $room) }}" class="hover:text-amber-500">{{ $room->name }}</a>
        <i class="fas fa-chevron-right text-xs"></i>
        <span class="text-gray-700 dark:text-gray-300">Book</span>
    </nav>

    <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-200 dark:border-gray-700 shadow-lg overflow-hidden">
        {{-- Room Summary --}}
        <div class="bg-gradient-to-r from-amber-500 to-orange-500 p-6 text-white">
            <h1 class="text-2xl font-bold">Book {{ $room->name }}</h1>
            <p class="text-white/70 mt-1">{{ ucfirst($room->type) }} · {{ $room->capacity }} guests · ${{ number_format($room->price_per_night) }}/night</p>
        </div>

        <form method="POST" action="{{ route('reservations.store') }}" class="p-6 space-y-6" x-data="bookingForm()">
            @csrf
            <input type="hidden" name="room_id" value="{{ $room->id }}">

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">Check-in Date</label>
                    <input type="date" name="check_in" x-model="checkIn" min="{{ now()->format('Y-m-d') }}" required class="w-full rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring-amber-500 focus:border-amber-500" />
                    @error('check_in')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">Check-out Date</label>
                    <input type="date" name="check_out" x-model="checkOut" :min="checkIn || '{{ now()->addDay()->format('Y-m-d') }}'" required class="w-full rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring-amber-500 focus:border-amber-500" />
                    @error('check_out')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">Number of Guests</label>
                <select name="guests" required class="w-full rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring-amber-500 focus:border-amber-500">
                    @for($i = 1; $i <= $room->capacity; $i++)
                        <option value="{{ $i }}">{{ $i }} guest{{ $i > 1 ? 's' : '' }}</option>
                    @endfor
                </select>
                @error('guests')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">Special Requests <span class="text-gray-400">(optional)</span></label>
                <textarea name="special_requests" rows="3" placeholder="Any special requests or preferences..." class="w-full rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring-amber-500 focus:border-amber-500">{{ old('special_requests') }}</textarea>
            </div>

            {{-- Price Summary --}}
            <div class="bg-gray-50 dark:bg-gray-700/50 rounded-xl p-4" x-show="nights > 0">
                <div class="flex justify-between items-center text-sm mb-2">
                    <span class="text-gray-500">${{ number_format($room->price_per_night) }} × <span x-text="nights"></span> night(s)</span>
                    <span class="font-semibold" x-text="'$' + total.toFixed(2)"></span>
                </div>
                <div class="border-t border-gray-200 dark:border-gray-600 pt-2 mt-2 flex justify-between items-center">
                    <span class="font-semibold">Total</span>
                    <span class="text-xl font-bold text-amber-600 dark:text-amber-400" x-text="'$' + total.toFixed(2)"></span>
                </div>
            </div>

            <button type="submit" class="w-full py-3.5 bg-gradient-to-r from-amber-500 to-orange-500 text-white font-semibold rounded-xl hover:from-amber-600 hover:to-orange-600 shadow-lg shadow-amber-500/25 transition-all hover:-translate-y-0.5">
                <i class="fas fa-check mr-2"></i> Confirm Reservation
            </button>
        </form>
    </div>
</div>

@push('scripts')
<script>
function bookingForm() {
    return {
        checkIn: '{{ old("check_in") }}',
        checkOut: '{{ old("check_out") }}',
        pricePerNight: {{ $room->price_per_night }},
        get nights() {
            if (!this.checkIn || !this.checkOut) return 0;
            const d1 = new Date(this.checkIn), d2 = new Date(this.checkOut);
            const diff = Math.ceil((d2 - d1) / (1000 * 60 * 60 * 24));
            return diff > 0 ? diff : 0;
        },
        get total() { return this.nights * this.pricePerNight; }
    };
}
</script>
@endpush
@endsection
