@extends('layouts.app')
@section('title', 'Our Rooms')
@section('meta_description', 'Browse our collection of premium hotel rooms — from cozy singles to luxurious suites.')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    {{-- Header --}}
    <div class="mb-8">
        <h1 class="text-3xl font-bold">Our Rooms</h1>
        <p class="text-gray-500 dark:text-gray-400 mt-1">Find the perfect room for your stay</p>
    </div>

    {{-- Filters --}}
    <form method="GET" action="{{ route('rooms.index') }}" class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700 p-6 mb-8">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4 items-end">
            <div>
                <label class="block text-xs font-medium text-gray-500 mb-1.5">Search</label>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Room name..." class="w-full rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white text-sm focus:ring-amber-500 focus:border-amber-500" />
            </div>
            <div>
                <label class="block text-xs font-medium text-gray-500 mb-1.5">Type</label>
                <select name="type" class="w-full rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white text-sm focus:ring-amber-500 focus:border-amber-500">
                    <option value="">All Types</option>
                    @foreach($types as $type)
                        <option value="{{ $type }}" {{ request('type') === $type ? 'selected' : '' }}>{{ ucfirst($type) }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-xs font-medium text-gray-500 mb-1.5">Guests</label>
                <select name="capacity" class="w-full rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white text-sm focus:ring-amber-500 focus:border-amber-500">
                    <option value="">Any</option>
                    @for($i = 1; $i <= 6; $i++)
                        <option value="{{ $i }}" {{ request('capacity') == $i ? 'selected' : '' }}>{{ $i }}+ guest{{ $i > 1 ? 's' : '' }}</option>
                    @endfor
                </select>
            </div>
            <div>
                <label class="block text-xs font-medium text-gray-500 mb-1.5">Sort By</label>
                <select name="sort" class="w-full rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white text-sm focus:ring-amber-500 focus:border-amber-500">
                    <option value="price_asc" {{ request('sort') === 'price_asc' ? 'selected' : '' }}>Price: Low to High</option>
                    <option value="price_desc" {{ request('sort') === 'price_desc' ? 'selected' : '' }}>Price: High to Low</option>
                    <option value="name" {{ request('sort') === 'name' ? 'selected' : '' }}>Name</option>
                    <option value="capacity" {{ request('sort') === 'capacity' ? 'selected' : '' }}>Capacity</option>
                </select>
            </div>
            <button type="submit" class="px-6 py-2.5 bg-gradient-to-r from-amber-500 to-orange-500 text-white text-sm font-semibold rounded-xl hover:from-amber-600 hover:to-orange-600 transition-all">
                <i class="fas fa-filter mr-1"></i> Filter
            </button>
        </div>
    </form>

    {{-- Results --}}
    @if($rooms->isEmpty())
        <div class="text-center py-20">
            <i class="fas fa-bed text-5xl text-gray-300 dark:text-gray-600 mb-4"></i>
            <h3 class="text-xl font-semibold text-gray-500">No rooms found</h3>
            <p class="text-gray-400 mt-1">Try adjusting your filters.</p>
        </div>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($rooms as $room)
            <a href="{{ route('rooms.show', $room) }}" class="group bg-white dark:bg-gray-800 rounded-2xl shadow-sm hover:shadow-xl border border-gray-200 dark:border-gray-700 overflow-hidden transition-all duration-300 hover:-translate-y-1">
                <div class="relative h-56 bg-gradient-to-br from-amber-100 to-orange-100 dark:from-gray-700 dark:to-gray-600 overflow-hidden">
                    <div class="absolute inset-0 flex items-center justify-center">
                        <i class="fas fa-bed text-5xl text-amber-300/40 dark:text-amber-500/20 group-hover:scale-110 transition-transform duration-300"></i>
                    </div>
                    <div class="absolute top-3 left-3 px-3 py-1 bg-amber-500 text-white text-xs font-semibold rounded-full uppercase">{{ $room->type }}</div>
                    <div class="absolute top-3 right-3 px-3 py-1.5 bg-white/90 dark:bg-gray-800/90 backdrop-blur rounded-lg">
                        <span class="text-amber-600 dark:text-amber-400 font-bold">${{ number_format($room->price_per_night) }}</span>
                        <span class="text-xs text-gray-400">/night</span>
                    </div>
                    @if($room->is_featured)
                        <div class="absolute bottom-3 left-3 px-2.5 py-1 bg-gradient-to-r from-amber-500 to-orange-500 text-white text-xs font-semibold rounded-full">
                            <i class="fas fa-star mr-1"></i> Featured
                        </div>
                    @endif
                </div>
                <div class="p-5">
                    <h3 class="text-lg font-bold group-hover:text-amber-600 dark:group-hover:text-amber-400 transition-colors">{{ $room->name }}</h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-1 line-clamp-2">{{ $room->description }}</p>

                    <div class="flex items-center gap-3 mt-4 text-xs text-gray-400">
                        <span class="flex items-center gap-1"><i class="fas fa-users"></i> {{ $room->capacity }}</span>
                        <span class="flex items-center gap-1"><i class="fas fa-bed"></i> {{ $room->beds }}</span>
                        <span class="flex items-center gap-1"><i class="fas fa-bath"></i> {{ $room->bathrooms }}</span>
                        @if($room->area)<span class="flex items-center gap-1"><i class="fas fa-ruler-combined"></i> {{ $room->area }}m²</span>@endif
                    </div>

                    @if($room->amenities->count())
                    <div class="flex flex-wrap gap-1.5 mt-3">
                        @foreach($room->amenities->take(4) as $amenity)
                            <span class="px-2 py-0.5 bg-gray-100 dark:bg-gray-700 text-xs text-gray-500 dark:text-gray-400 rounded-md">{{ $amenity->name }}</span>
                        @endforeach
                        @if($room->amenities->count() > 4)
                            <span class="px-2 py-0.5 bg-amber-100 dark:bg-amber-500/10 text-xs text-amber-600 dark:text-amber-400 rounded-md">+{{ $room->amenities->count() - 4 }}</span>
                        @endif
                    </div>
                    @endif
                </div>
            </a>
            @endforeach
        </div>

        <div class="mt-10">
            {{ $rooms->links() }}
        </div>
    @endif
</div>
@endsection
