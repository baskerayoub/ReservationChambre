@extends('layouts.app')
@section('title', 'Welcome to Hotelia')
@section('meta_description', 'Experience luxury at Hotelia — Premium family hotel with stunning rooms, spa, pool, and world-class hospitality.')

@section('content')

{{-- Hero Section --}}
<section class="relative overflow-hidden bg-gradient-to-br from-gray-900 via-gray-800 to-gray-900 min-h-[600px] flex items-center">
    {{-- Decorative Elements --}}
    <div class="absolute inset-0">
        <div class="absolute top-20 left-10 w-72 h-72 bg-amber-500/10 rounded-full blur-3xl animate-float"></div>
        <div class="absolute bottom-20 right-10 w-96 h-96 bg-orange-500/10 rounded-full blur-3xl animate-float" style="animation-delay: 1.5s"></div>
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[600px] h-[600px] bg-amber-500/5 rounded-full blur-3xl"></div>
    </div>
    {{-- Grid Pattern --}}
    <div class="absolute inset-0 opacity-[0.03]" style="background-image: url('data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 width=%2260%22 height=%2260%22><rect width=%2260%22 height=%2260%22 fill=%22none%22 stroke=%22white%22 stroke-width=%220.5%22/></svg>');"></div>

    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24 text-center">
        <div class="inline-flex items-center gap-2 px-4 py-2 bg-amber-500/10 border border-amber-500/20 rounded-full text-amber-400 text-sm font-medium mb-8 animate-fade-in">
            <i class="fas fa-star text-xs"></i>
            <span>Premium Family Hotel</span>
            <i class="fas fa-star text-xs"></i>
        </div>

        <h1 class="text-4xl sm:text-5xl lg:text-7xl font-bold text-white leading-tight mb-6 animate-fade-in-up" style="animation-delay: 0.1s">
            Your Luxury Escape
            <br>
            <span class="bg-gradient-to-r from-amber-400 via-orange-400 to-amber-500 bg-clip-text text-transparent">Starts Here</span>
        </h1>

        <p class="text-lg sm:text-xl text-gray-400 max-w-2xl mx-auto mb-10 animate-fade-in-up" style="animation-delay: 0.2s">
            Experience world-class hospitality in an atmosphere of unparalleled comfort and elegance. Where every moment becomes an unforgettable memory.
        </p>

        <div class="flex flex-col sm:flex-row items-center justify-center gap-4 animate-fade-in-up" style="animation-delay: 0.3s">
            <a href="{{ route('rooms.index') }}" class="px-8 py-4 text-base font-semibold text-white bg-gradient-to-r from-amber-500 to-orange-500 rounded-xl hover:from-amber-600 hover:to-orange-600 shadow-xl shadow-amber-500/25 hover:shadow-amber-500/40 transition-all hover:-translate-y-0.5">
                <i class="fas fa-search mr-2"></i> Explore Our Rooms
            </a>
            <a href="#featured" class="px-8 py-4 text-base font-semibold text-white border border-white/20 rounded-xl hover:bg-white/10 transition-all">
                <i class="fas fa-play mr-2"></i> Learn More
            </a>
        </div>

        {{-- Stats --}}
        <div class="grid grid-cols-3 gap-8 max-w-lg mx-auto mt-16 animate-fade-in-up" style="animation-delay: 0.4s">
            <div class="text-center">
                <div class="text-3xl font-bold text-white">{{ $stats['rooms'] }}+</div>
                <div class="text-sm text-gray-400 mt-1">Luxury Rooms</div>
            </div>
            <div class="text-center">
                <div class="text-3xl font-bold text-white">{{ $stats['happy_guests'] ?: '500' }}+</div>
                <div class="text-sm text-gray-400 mt-1">Happy Guests</div>
            </div>
            <div class="text-center">
                <div class="text-3xl font-bold text-white">{{ $stats['avg_rating'] }}</div>
                <div class="text-sm text-gray-400 mt-1">
                    <i class="fas fa-star text-amber-400 text-xs"></i> Rating
                </div>
            </div>
        </div>
    </div>
</section>

{{-- Search Bar --}}
<section class="max-w-5xl mx-auto px-4 -mt-8 relative z-10 mb-16">
    <form action="{{ route('rooms.index') }}" method="GET" class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl p-6 border border-gray-200 dark:border-gray-700">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
            <div>
                <label class="block text-sm font-medium text-gray-600 dark:text-gray-400 mb-2">Room Type</label>
                <select name="type" class="w-full rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring-amber-500 focus:border-amber-500">
                    <option value="">All Types</option>
                    <option value="single">Single</option>
                    <option value="double">Double</option>
                    <option value="deluxe">Deluxe</option>
                    <option value="suite">Suite</option>
                    <option value="family">Family</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-600 dark:text-gray-400 mb-2">Guests</label>
                <select name="capacity" class="w-full rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring-amber-500 focus:border-amber-500">
                    <option value="">Any</option>
                    <option value="1">1 Guest</option>
                    <option value="2">2 Guests</option>
                    <option value="3">3 Guests</option>
                    <option value="4">4+ Guests</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-600 dark:text-gray-400 mb-2">Max Price</label>
                <select name="max_price" class="w-full rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring-amber-500 focus:border-amber-500">
                    <option value="">No Limit</option>
                    <option value="100">Up to $100</option>
                    <option value="200">Up to $200</option>
                    <option value="300">Up to $300</option>
                    <option value="500">Up to $500</option>
                </select>
            </div>
            <button type="submit" class="w-full px-6 py-3 bg-gradient-to-r from-amber-500 to-orange-500 text-white font-semibold rounded-xl hover:from-amber-600 hover:to-orange-600 shadow-lg shadow-amber-500/25 transition-all">
                <i class="fas fa-search mr-2"></i> Search
            </button>
        </div>
    </form>
</section>

{{-- Featured Rooms --}}
<section id="featured" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mb-20">
    <div class="text-center mb-12">
        <span class="text-amber-500 dark:text-amber-400 text-sm font-semibold uppercase tracking-wider">Our Collection</span>
        <h2 class="text-3xl sm:text-4xl font-bold mt-2">Featured Rooms</h2>
        <p class="text-gray-500 dark:text-gray-400 mt-3 max-w-xl mx-auto">Discover our handpicked selection of premium rooms designed for your ultimate comfort.</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        @foreach($featuredRooms as $room)
        <a href="{{ route('rooms.show', $room) }}" class="group bg-white dark:bg-gray-800 rounded-2xl shadow-md hover:shadow-xl border border-gray-200 dark:border-gray-700 overflow-hidden transition-all duration-300 hover:-translate-y-1">
            <div class="relative h-56 bg-gradient-to-br from-amber-100 to-orange-100 dark:from-gray-700 dark:to-gray-600 overflow-hidden">
                <div class="absolute inset-0 flex items-center justify-center">
                    <i class="fas fa-bed text-5xl text-amber-300/40 dark:text-amber-500/20"></i>
                </div>
                <div class="absolute top-3 left-3 px-3 py-1 bg-amber-500 text-white text-xs font-semibold rounded-full uppercase">{{ $room->type }}</div>
                <div class="absolute top-3 right-3 px-3 py-1.5 bg-white/90 dark:bg-gray-800/90 backdrop-blur rounded-lg text-amber-600 dark:text-amber-400 font-bold text-sm">${{ number_format($room->price_per_night) }}<span class="text-xs font-normal text-gray-400">/night</span></div>
            </div>
            <div class="p-5">
                <h3 class="text-lg font-bold group-hover:text-amber-600 dark:group-hover:text-amber-400 transition-colors">{{ $room->name }}</h3>
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1 line-clamp-2">{{ $room->description }}</p>
                <div class="flex items-center gap-4 mt-4 text-xs text-gray-400">
                    <span><i class="fas fa-users mr-1"></i> {{ $room->capacity }} guests</span>
                    <span><i class="fas fa-bed mr-1"></i> {{ $room->beds }} bed{{ $room->beds > 1 ? 's' : '' }}</span>
                    <span><i class="fas fa-ruler-combined mr-1"></i> {{ $room->area }}m²</span>
                </div>
            </div>
        </a>
        @endforeach
    </div>

    <div class="text-center mt-10">
        <a href="{{ route('rooms.index') }}" class="inline-flex items-center gap-2 px-8 py-3 border-2 border-amber-500 text-amber-600 dark:text-amber-400 font-semibold rounded-xl hover:bg-amber-50 dark:hover:bg-amber-500/10 transition-all">
            View All Rooms <i class="fas fa-arrow-right"></i>
        </a>
    </div>
</section>

{{-- Services --}}
<section class="bg-gray-100 dark:bg-gray-900/50 py-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <span class="text-amber-500 dark:text-amber-400 text-sm font-semibold uppercase tracking-wider">World-Class Amenities</span>
            <h2 class="text-3xl sm:text-4xl font-bold mt-2">Hotel Services</h2>
        </div>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
            @foreach([
                ['icon' => 'fa-spa', 'name' => 'Spa & Wellness', 'desc' => 'Rejuvenate body and mind'],
                ['icon' => 'fa-swimmer', 'name' => 'Swimming Pool', 'desc' => 'Infinity pool with ocean view'],
                ['icon' => 'fa-utensils', 'name' => 'Fine Dining', 'desc' => 'Award-winning cuisine'],
                ['icon' => 'fa-concierge-bell', 'name' => '24/7 Service', 'desc' => 'Always at your service'],
                ['icon' => 'fa-wifi', 'name' => 'Free Wi-Fi', 'desc' => 'High-speed everywhere'],
                ['icon' => 'fa-shuttle-van', 'name' => 'Airport Transfer', 'desc' => 'Free shuttle service'],
                ['icon' => 'fa-parking', 'name' => 'Free Parking', 'desc' => 'Secure underground parking'],
                ['icon' => 'fa-child', 'name' => 'Kids Club', 'desc' => 'Fun activities for children'],
            ] as $service)
            <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 text-center border border-gray-200 dark:border-gray-700 hover:shadow-lg hover:-translate-y-1 transition-all duration-300">
                <div class="w-14 h-14 mx-auto bg-amber-100 dark:bg-amber-500/10 rounded-xl flex items-center justify-center mb-4">
                    <i class="fas {{ $service['icon'] }} text-xl text-amber-600 dark:text-amber-400"></i>
                </div>
                <h3 class="font-semibold text-sm">{{ $service['name'] }}</h3>
                <p class="text-xs text-gray-400 mt-1">{{ $service['desc'] }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- Testimonials --}}
@if($latestReviews->count())
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
    <div class="text-center mb-12">
        <span class="text-amber-500 dark:text-amber-400 text-sm font-semibold uppercase tracking-wider">Testimonials</span>
        <h2 class="text-3xl sm:text-4xl font-bold mt-2">What Our Guests Say</h2>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        @foreach($latestReviews as $review)
        <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 border border-gray-200 dark:border-gray-700 hover:shadow-lg transition-shadow">
            <div class="flex items-center gap-1 mb-3">
                @for($i = 1; $i <= 5; $i++)
                    <i class="fas fa-star text-sm {{ $i <= $review->rating ? 'text-amber-400' : 'text-gray-300 dark:text-gray-600' }}"></i>
                @endfor
            </div>
            <p class="text-sm text-gray-600 dark:text-gray-300 leading-relaxed mb-4">"{{ $review->comment }}"</p>
            <div class="flex items-center gap-3 border-t border-gray-100 dark:border-gray-700 pt-4">
                <div class="w-10 h-10 rounded-full bg-gradient-to-br from-amber-400 to-orange-500 flex items-center justify-center text-white text-sm font-bold">{{ strtoupper(substr($review->user->name, 0, 1)) }}</div>
                <div>
                    <p class="text-sm font-semibold">{{ $review->user->name }}</p>
                    <p class="text-xs text-gray-400">{{ $review->room->name }}</p>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</section>
@endif

{{-- CTA --}}
<section class="relative overflow-hidden bg-gradient-to-r from-amber-500 to-orange-500 py-20">
    <div class="absolute inset-0 opacity-10">
        <div class="absolute top-0 left-0 w-full h-full" style="background-image: url('data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 width=%2260%22 height=%2260%22><circle cx=%2230%22 cy=%2230%22 r=%221%22 fill=%22white%22/></svg>');"></div>
    </div>
    <div class="relative max-w-3xl mx-auto px-4 text-center">
        <h2 class="text-3xl sm:text-4xl font-bold text-white mb-4">Ready for an Unforgettable Stay?</h2>
        <p class="text-white/80 text-lg mb-8">Book your dream room today and enjoy exclusive rates and premium services.</p>
        <a href="{{ route('rooms.index') }}" class="inline-flex items-center gap-2 px-8 py-4 bg-white text-amber-600 font-bold rounded-xl hover:bg-gray-50 shadow-xl transition-all hover:-translate-y-0.5">
            <i class="fas fa-calendar-check"></i> Reserve Your Room
        </a>
    </div>
</section>

@endsection
