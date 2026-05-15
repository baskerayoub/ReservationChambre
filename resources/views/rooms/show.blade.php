@extends('layouts.app')
@section('title', $room->name)
@section('meta_description', Str::limit($room->description, 160))

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    {{-- Breadcrumb --}}
    <nav class="flex items-center gap-2 text-sm text-gray-400 mb-6">
        <a href="{{ route('home') }}" class="hover:text-amber-500">Home</a>
        <i class="fas fa-chevron-right text-xs"></i>
        <a href="{{ route('rooms.index') }}" class="hover:text-amber-500">Rooms</a>
        <i class="fas fa-chevron-right text-xs"></i>
        <span class="text-gray-700 dark:text-gray-300">{{ $room->name }}</span>
    </nav>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        {{-- Main Content --}}
        <div class="lg:col-span-2 space-y-8">
            {{-- Image Gallery --}}
            <div class="relative h-[400px] bg-gradient-to-br from-amber-100 to-orange-100 dark:from-gray-700 dark:to-gray-600 rounded-2xl overflow-hidden shadow-lg">
                <div class="absolute inset-0 flex items-center justify-center">
                    <i class="fas fa-bed text-8xl text-amber-300/30 dark:text-amber-500/20"></i>
                </div>
                <div class="absolute top-4 left-4 flex gap-2">
                    <span class="px-3 py-1.5 bg-amber-500 text-white text-sm font-semibold rounded-full uppercase">{{ $room->type }}</span>
                    @if($room->is_featured)
                        <span class="px-3 py-1.5 bg-gradient-to-r from-amber-500 to-orange-500 text-white text-sm font-semibold rounded-full"><i class="fas fa-star mr-1"></i> Featured</span>
                    @endif
                </div>
            </div>

            {{-- Room Info --}}
            <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 border border-gray-200 dark:border-gray-700">
                <h1 class="text-2xl sm:text-3xl font-bold">{{ $room->name }}</h1>
                <div class="flex items-center gap-4 mt-3 text-sm text-gray-500 dark:text-gray-400">
                    <span><i class="fas fa-users mr-1.5 text-amber-500"></i> {{ $room->capacity }} guests</span>
                    <span><i class="fas fa-bed mr-1.5 text-amber-500"></i> {{ $room->beds }} bed{{ $room->beds > 1 ? 's' : '' }}</span>
                    <span><i class="fas fa-bath mr-1.5 text-amber-500"></i> {{ $room->bathrooms }} bathroom{{ $room->bathrooms > 1 ? 's' : '' }}</span>
                    @if($room->area)<span><i class="fas fa-ruler-combined mr-1.5 text-amber-500"></i> {{ $room->area }}m²</span>@endif
                    @if($room->floor)<span><i class="fas fa-building mr-1.5 text-amber-500"></i> Floor {{ $room->floor }}</span>@endif
                </div>

                <div class="mt-6">
                    <h3 class="text-lg font-semibold mb-2">Description</h3>
                    <p class="text-gray-600 dark:text-gray-300 leading-relaxed">{{ $room->description }}</p>
                </div>
            </div>

            {{-- Amenities --}}
            @if($room->amenities->count())
            <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 border border-gray-200 dark:border-gray-700">
                <h3 class="text-lg font-semibold mb-4">Room Amenities</h3>
                <div class="grid grid-cols-2 sm:grid-cols-3 gap-3">
                    @foreach($room->amenities as $amenity)
                    <div class="flex items-center gap-3 p-3 bg-gray-50 dark:bg-gray-700/50 rounded-xl">
                        <div class="w-9 h-9 bg-amber-100 dark:bg-amber-500/10 rounded-lg flex items-center justify-center">
                            <i class="fas fa-check text-amber-600 dark:text-amber-400 text-sm"></i>
                        </div>
                        <span class="text-sm font-medium">{{ $amenity->name }}</span>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

            {{-- Reviews --}}
            <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 border border-gray-200 dark:border-gray-700">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-lg font-semibold">Guest Reviews</h3>
                    @if($room->review_count > 0)
                    <div class="flex items-center gap-2">
                        <div class="flex items-center gap-0.5">
                            @for($i = 1; $i <= 5; $i++)
                                <i class="fas fa-star text-sm {{ $i <= round($room->average_rating) ? 'text-amber-400' : 'text-gray-300 dark:text-gray-600' }}"></i>
                            @endfor
                        </div>
                        <span class="text-sm font-semibold">{{ $room->average_rating }}</span>
                        <span class="text-sm text-gray-400">({{ $room->review_count }} reviews)</span>
                    </div>
                    @endif
                </div>

                @forelse($room->reviews as $review)
                <div class="py-4 {{ !$loop->last ? 'border-b border-gray-100 dark:border-gray-700' : '' }}">
                    <div class="flex items-center gap-3 mb-2">
                        <div class="w-10 h-10 rounded-full bg-gradient-to-br from-amber-400 to-orange-500 flex items-center justify-center text-white text-sm font-bold">{{ strtoupper(substr($review->user->name, 0, 1)) }}</div>
                        <div>
                            <p class="text-sm font-semibold">{{ $review->user->name }}</p>
                            <p class="text-xs text-gray-400">{{ $review->created_at->diffForHumans() }}</p>
                        </div>
                        <div class="ml-auto flex items-center gap-0.5">
                            @for($i = 1; $i <= 5; $i++)
                                <i class="fas fa-star text-xs {{ $i <= $review->rating ? 'text-amber-400' : 'text-gray-300 dark:text-gray-600' }}"></i>
                            @endfor
                        </div>
                    </div>
                    <p class="text-sm text-gray-600 dark:text-gray-300">{{ $review->comment }}</p>
                </div>
                @empty
                <p class="text-sm text-gray-400 text-center py-6">No reviews yet. Be the first to review this room!</p>
                @endforelse
            </div>
        </div>

        {{-- Booking Sidebar --}}
        <div class="lg:col-span-1">
            <div class="sticky top-24 space-y-6">
                {{-- Price Card --}}
                <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 border border-gray-200 dark:border-gray-700 shadow-lg">
                    <div class="text-center mb-6">
                        <span class="text-4xl font-bold text-amber-600 dark:text-amber-400">${{ number_format($room->price_per_night) }}</span>
                        <span class="text-gray-400">/night</span>
                    </div>

                    @auth
                        <a href="{{ route('reservations.create', ['room_id' => $room->id]) }}" class="block w-full py-3.5 text-center bg-gradient-to-r from-amber-500 to-orange-500 text-white font-semibold rounded-xl hover:from-amber-600 hover:to-orange-600 shadow-lg shadow-amber-500/25 transition-all hover:-translate-y-0.5">
                            <i class="fas fa-calendar-check mr-2"></i> Book This Room
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="block w-full py-3.5 text-center bg-gradient-to-r from-amber-500 to-orange-500 text-white font-semibold rounded-xl hover:from-amber-600 hover:to-orange-600 shadow-lg shadow-amber-500/25 transition-all">
                            <i class="fas fa-sign-in-alt mr-2"></i> Sign in to Book
                        </a>
                    @endauth

                    <div class="mt-4 space-y-3 text-sm text-gray-500 dark:text-gray-400">
                        <div class="flex items-center gap-2"><i class="fas fa-check-circle text-emerald-500"></i> Free cancellation</div>
                        <div class="flex items-center gap-2"><i class="fas fa-check-circle text-emerald-500"></i> Instant confirmation</div>
                        <div class="flex items-center gap-2"><i class="fas fa-check-circle text-emerald-500"></i> Best price guarantee</div>
                    </div>
                </div>

                {{-- Hotel Policies --}}
                <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 border border-gray-200 dark:border-gray-700">
                    <h4 class="font-semibold mb-3">Hotel Policies</h4>
                    <div class="space-y-3 text-sm text-gray-500 dark:text-gray-400">
                        <div class="flex justify-between"><span>Check-in</span><span class="font-medium text-gray-700 dark:text-gray-300">3:00 PM</span></div>
                        <div class="flex justify-between"><span>Check-out</span><span class="font-medium text-gray-700 dark:text-gray-300">11:00 AM</span></div>
                        <div class="flex justify-between"><span>Cancellation</span><span class="font-medium text-gray-700 dark:text-gray-300">Free / 24h</span></div>
                        <div class="flex justify-between"><span>Pets</span><span class="font-medium text-gray-700 dark:text-gray-300">Not allowed</span></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Similar Rooms --}}
    @if($similarRooms->count())
    <div class="mt-16">
        <h2 class="text-2xl font-bold mb-6">Similar Rooms</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @foreach($similarRooms as $similar)
            <a href="{{ route('rooms.show', $similar) }}" class="group bg-white dark:bg-gray-800 rounded-2xl shadow-sm hover:shadow-lg border border-gray-200 dark:border-gray-700 overflow-hidden transition-all duration-300 hover:-translate-y-1">
                <div class="relative h-48 bg-gradient-to-br from-amber-100 to-orange-100 dark:from-gray-700 dark:to-gray-600">
                    <div class="absolute inset-0 flex items-center justify-center"><i class="fas fa-bed text-4xl text-amber-300/40 dark:text-amber-500/20"></i></div>
                    <div class="absolute top-3 right-3 px-3 py-1.5 bg-white/90 dark:bg-gray-800/90 backdrop-blur rounded-lg text-amber-600 dark:text-amber-400 font-bold text-sm">${{ number_format($similar->price_per_night) }}<span class="text-xs font-normal text-gray-400">/night</span></div>
                </div>
                <div class="p-4">
                    <h3 class="font-bold group-hover:text-amber-600 dark:group-hover:text-amber-400 transition-colors">{{ $similar->name }}</h3>
                    <div class="flex items-center gap-3 mt-2 text-xs text-gray-400">
                        <span><i class="fas fa-users mr-1"></i> {{ $similar->capacity }}</span>
                        <span><i class="fas fa-bed mr-1"></i> {{ $similar->beds }}</span>
                    </div>
                </div>
            </a>
            @endforeach
        </div>
    </div>
    @endif
</div>
@endsection
