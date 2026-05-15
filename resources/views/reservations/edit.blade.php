@extends('layouts.app')
@section('title', 'Edit Reservation')

@section('content')
<div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <h1 class="text-2xl font-bold mb-6">Modify Reservation #{{ $reservation->id }}</h1>
    <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-200 dark:border-gray-700 p-6">
        <form method="POST" action="{{ route('reservations.update', $reservation) }}" x-data="{ checkIn: '{{ $reservation->check_in->format('Y-m-d') }}', checkOut: '{{ $reservation->check_out->format('Y-m-d') }}', price: {{ $reservation->room->price_per_night }}, get nights(){ if(!this.checkIn||!this.checkOut) return 0; const d=Math.ceil((new Date(this.checkOut)-new Date(this.checkIn))/(864e5)); return d>0?d:0; }, get total(){ return this.nights*this.price; } }">
            @csrf @method('PUT')
            <div class="grid grid-cols-2 gap-6 mb-6">
                <div>
                    <label class="block text-sm font-medium mb-1.5">Check-in</label>
                    <input type="date" name="check_in" x-model="checkIn" min="{{ now()->format('Y-m-d') }}" required class="w-full rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring-amber-500" />
                    @error('check_in')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1.5">Check-out</label>
                    <input type="date" name="check_out" x-model="checkOut" :min="checkIn" required class="w-full rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring-amber-500" />
                    @error('check_out')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
            </div>
            <div class="mb-6">
                <label class="block text-sm font-medium mb-1.5">Guests</label>
                <select name="guests" class="w-full rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring-amber-500">
                    @for($i=1;$i<=$reservation->room->capacity;$i++)
                        <option value="{{ $i }}" {{ $reservation->guests == $i ? 'selected' : '' }}>{{ $i }}</option>
                    @endfor
                </select>
            </div>
            <div class="mb-6">
                <label class="block text-sm font-medium mb-1.5">Special Requests</label>
                <textarea name="special_requests" rows="3" class="w-full rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring-amber-500">{{ $reservation->special_requests }}</textarea>
            </div>
            <div class="bg-gray-50 dark:bg-gray-700/50 rounded-xl p-4 mb-6" x-show="nights>0">
                <div class="flex justify-between"><span class="text-gray-500">Total (<span x-text="nights"></span> nights)</span><span class="font-bold text-amber-600" x-text="'$'+total.toFixed(2)"></span></div>
            </div>
            <div class="flex gap-3">
                <button type="submit" class="flex-1 py-3 bg-gradient-to-r from-amber-500 to-orange-500 text-white font-semibold rounded-xl">Save Changes</button>
                <a href="{{ route('reservations.show', $reservation) }}" class="px-6 py-3 border border-gray-300 dark:border-gray-600 rounded-xl text-sm font-medium hover:bg-gray-50 dark:hover:bg-gray-700">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection
