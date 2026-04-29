<x-app-layout>
    <div class="animate-fade-in">
        {{-- ────────────── HERO SECTION ────────────── --}}
        @unless ($isAdminView)
            <section class="relative overflow-hidden bg-gradient-to-br from-blue-900 via-blue-800 to-blue-950">
                <!-- Background decorations -->
                <div class="absolute inset-0 pointer-events-none">
                    <div class="absolute -top-20 -right-20 h-72 w-72 rounded-full bg-blue-500/20 blur-3xl"></div>
                    <div class="absolute bottom-0 left-1/4 h-64 w-64 rounded-full bg-blue-400/10 blur-3xl"></div>
                </div>
                <!-- Background image with overlay -->
                <div class="absolute inset-0">
                    <img src="https://images.unsplash.com/photo-1566073771259-6a8506099945?auto=format&fit=crop&w=2000&q=80" alt="Family Hotel" class="h-full w-full object-cover opacity-20">
                </div>

                <div class="relative mx-auto max-w-7xl px-4 py-16 sm:px-6 sm:py-24 lg:px-8">
                    <div class="max-w-3xl">
                        <div class="inline-flex items-center gap-2 rounded-full bg-white/10 px-4 py-1.5 text-sm font-medium text-blue-200 ring-1 ring-white/20 backdrop-blur-sm">
                            <span class="h-1.5 w-1.5 rounded-full bg-emerald-400 animate-pulse"></span>
                            Now accepting online reservations
                        </div>
                        <h1 class="mt-6 text-4xl font-extrabold tracking-tight text-white sm:text-5xl lg:text-6xl">
                            Your Perfect <br>
                            <span class="bg-gradient-to-r from-blue-200 to-blue-400 bg-clip-text text-transparent">Family Getaway</span>
                        </h1>
                        <p class="mt-6 max-w-2xl text-lg leading-relaxed text-blue-100/80">
                            Discover our handpicked rooms designed for comfort and togetherness.
                            Browse availability, book online, and pay securely with Stripe or PayPal.
                        </p>

                        <!-- Quick features -->
                        <div class="mt-8 grid gap-3 sm:grid-cols-3 max-w-xl">
                            <div class="flex items-center gap-3 rounded-xl bg-white/10 px-4 py-3 backdrop-blur-sm ring-1 ring-white/10">
                                <svg class="h-5 w-5 text-blue-300 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5" />
                                </svg>
                                <span class="text-sm font-medium text-white">Real-time Availability</span>
                            </div>
                            <div class="flex items-center gap-3 rounded-xl bg-white/10 px-4 py-3 backdrop-blur-sm ring-1 ring-white/10">
                                <svg class="h-5 w-5 text-blue-300 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 8.25h19.5M2.25 9h19.5m-16.5 5.25h6m-6 2.25h3m-3.75 3h15a2.25 2.25 0 002.25-2.25V6.75A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25v10.5A2.25 2.25 0 004.5 19.5z" />
                                </svg>
                                <span class="text-sm font-medium text-white">Secure Payment</span>
                            </div>
                            <div class="flex items-center gap-3 rounded-xl bg-white/10 px-4 py-3 backdrop-blur-sm ring-1 ring-white/10">
                                <svg class="h-5 w-5 text-blue-300 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12c0 1.268-.63 2.39-1.593 3.068a3.745 3.745 0 01-1.043 3.296 3.745 3.745 0 01-3.296 1.043A3.745 3.745 0 0112 21c-1.268 0-2.39-.63-3.068-1.593a3.746 3.746 0 01-3.296-1.043 3.745 3.745 0 01-1.043-3.296A3.745 3.745 0 013 12c0-1.268.63-2.39 1.593-3.068a3.745 3.745 0 011.043-3.296 3.746 3.746 0 013.296-1.043A3.746 3.746 0 0112 3c1.268 0 2.39.63 3.068 1.593a3.746 3.746 0 013.296 1.043 3.745 3.745 0 011.043 3.296A3.745 3.745 0 0121 12z" />
                                </svg>
                                <span class="text-sm font-medium text-white">Free Cancellation</span>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        @endunless

        {{-- ────────────── PAGE HEADER (Admin) ────────────── --}}
        @if ($isAdminView)
            <x-slot name="header">
                <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                    <div>
                        <h2 class="text-xl font-bold text-gray-900">Room Management</h2>
                        <p class="mt-1 text-sm text-gray-500">Create, edit, and manage hotel rooms</p>
                    </div>
                    <a href="{{ route('admin.chambres.create') }}" class="btn-primary">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                        </svg>
                        Add Room
                    </a>
                </div>
            </x-slot>
        @endif

        <div class="py-8">
            <div class="mx-auto max-w-7xl space-y-8 px-4 sm:px-6 lg:px-8">
                {{-- ────────────── SEARCH / FILTER BAR ────────────── --}}
                <form method="GET" action="{{ route($isAdminView ? 'admin.chambres.index' : 'chambres.index') }}"
                      class="card p-6 animate-fade-in-up">
                    <div class="flex items-center gap-3 mb-5">
                        <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-blue-50 text-blue-600">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-base font-bold text-gray-900">Search & Filter</h3>
                            <p class="text-sm text-gray-500">Find the perfect room for your stay</p>
                        </div>
                    </div>

                    <div class="grid gap-4 md:grid-cols-3 lg:grid-cols-6">
                        <div>
                            <label class="block text-xs font-semibold text-gray-600 uppercase tracking-wide mb-1.5" for="type">Room Type</label>
                            <select id="type" name="type" class="form-input-blue text-sm">
                                <option value="">All Types</option>
                                @foreach ($types as $type)
                                    <option value="{{ $type }}" @selected(($filters['type'] ?? '') === $type)>{{ $type }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-gray-600 uppercase tracking-wide mb-1.5" for="confort">Comfort</label>
                            <select id="confort" name="confort" class="form-input-blue text-sm">
                                <option value="">All Levels</option>
                                @foreach ($conforts as $confort)
                                    <option value="{{ $confort }}" @selected(($filters['confort'] ?? '') === $confort)>{{ $confort }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-gray-600 uppercase tracking-wide mb-1.5" for="prix_min">Min Price</label>
                            <input id="prix_min" name="prix_min" type="number" min="0" step="0.01" value="{{ $filters['prix_min'] ?? '' }}" placeholder="0.00" class="form-input-blue text-sm">
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-gray-600 uppercase tracking-wide mb-1.5" for="prix_max">Max Price</label>
                            <input id="prix_max" name="prix_max" type="number" min="0" step="0.01" value="{{ $filters['prix_max'] ?? '' }}" placeholder="∞" class="form-input-blue text-sm">
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-gray-600 uppercase tracking-wide mb-1.5" for="date_debut">Check-in</label>
                            <input id="date_debut" name="date_debut" type="date" value="{{ $filters['date_debut'] ?? '' }}" class="form-input-blue text-sm">
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-gray-600 uppercase tracking-wide mb-1.5" for="date_fin">Check-out</label>
                            <input id="date_fin" name="date_fin" type="date" value="{{ $filters['date_fin'] ?? '' }}" class="form-input-blue text-sm">
                        </div>
                    </div>

                    {{-- Amenities --}}
                    <fieldset class="mt-5">
                        <legend class="text-xs font-semibold text-gray-600 uppercase tracking-wide mb-2">Amenities</legend>
                        <div class="flex flex-wrap gap-2">
                            @foreach ($equipements as $equipement)
                                <label class="group cursor-pointer">
                                    <input type="checkbox" name="equipements[]" value="{{ $equipement }}" @checked(in_array($equipement, $filters['equipements'] ?? [], true)) class="peer sr-only">
                                    <span class="inline-flex items-center gap-1.5 rounded-full border border-gray-200 bg-gray-50 px-3.5 py-1.5 text-xs font-medium text-gray-600 transition-all duration-200 peer-checked:border-blue-300 peer-checked:bg-blue-50 peer-checked:text-blue-700 hover:border-blue-200 hover:bg-blue-50/50">
                                        {{ $equipement }}
                                    </span>
                                </label>
                            @endforeach
                        </div>
                    </fieldset>

                    <div class="mt-5 flex flex-wrap gap-3">
                        <button class="btn-primary">
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                            </svg>
                            Search Rooms
                        </button>
                        <a href="{{ route($isAdminView ? 'admin.chambres.index' : 'chambres.index') }}" class="btn-secondary">
                            Reset Filters
                        </a>
                    </div>
                </form>

                {{-- ────────────── ROOM CARDS ────────────── --}}
                <div class="grid gap-6 md:grid-cols-2 xl:grid-cols-3">
                    @forelse ($chambres as $index => $chambre)
                        <article class="card overflow-hidden hover-lift group animate-fade-in-up animation-delay-{{ min($index * 100, 800) }}">
                            {{-- Image --}}
                            <div class="aspect-[4/3] overflow-hidden relative">
                                @if ($chambre->image)
                                    <img src="{{ $chambre->image }}" alt="Room {{ $chambre->numero }}" class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-110">
                                @else
                                    <div class="flex h-full items-center justify-center bg-gradient-to-br from-blue-600 to-blue-800 text-lg font-bold uppercase tracking-wider text-white">
                                        Room {{ $chambre->numero }}
                                    </div>
                                @endif
                                {{-- Overlay gradient --}}
                                <div class="absolute inset-0 bg-gradient-to-t from-black/40 via-transparent to-transparent opacity-0 transition-opacity duration-300 group-hover:opacity-100"></div>
                                {{-- Price badge --}}
                                <div class="absolute top-4 right-4">
                                    <span class="rounded-xl bg-white/90 backdrop-blur-sm px-3 py-1.5 text-sm font-bold text-blue-700 shadow-lg ring-1 ring-white/50">
                                        {{ number_format($chambre->prix, 0) }} MAD<span class="text-xs font-medium text-gray-500">/night</span>
                                    </span>
                                </div>
                                {{-- Status badge --}}
                                <div class="absolute top-4 left-4">
                                    @php
                                        $statusClass = match($chambre->status) {
                                            'disponible' => 'badge-available',
                                            'occupee' => 'badge-occupied',
                                            'maintenance' => 'badge-maintenance',
                                            default => 'badge-available',
                                        };
                                    @endphp
                                    <span class="badge {{ $statusClass }}">{{ $chambre->statusLabel() }}</span>
                                </div>
                            </div>

                            {{-- Content --}}
                            <div class="p-5 space-y-4">
                                <div>
                                    <h3 class="text-lg font-bold text-gray-900 group-hover:text-blue-700 transition-colors">Room {{ $chambre->numero }}</h3>
                                    <p class="text-sm text-gray-500 mt-0.5">{{ $chambre->type }} · {{ $chambre->confort }}</p>
                                </div>

                                <p class="text-sm text-gray-600 line-clamp-2">{{ $chambre->description ?: 'A comfortable room designed for a wonderful family stay.' }}</p>

                                {{-- Amenities --}}
                                <div class="flex flex-wrap gap-1.5">
                                    @foreach ($chambre->equipements_list as $item)
                                        <span class="inline-flex items-center rounded-lg bg-blue-50 px-2.5 py-1 text-xs font-medium text-blue-700 ring-1 ring-blue-100">{{ $item }}</span>
                                    @endforeach
                                </div>

                                {{-- Actions --}}
                                <div class="flex items-center justify-between border-t border-gray-100 pt-4">
                                    <a href="{{ route($isAdminView ? 'admin.chambres.show' : 'chambres.show', $chambre) }}" class="btn-secondary !py-2 !px-4 !text-xs">
                                        View Details
                                    </a>
                                    @if ($isAdminView)
                                        <a href="{{ route('admin.chambres.edit', $chambre) }}" class="btn-primary !py-2 !px-4 !text-xs">
                                            Edit Room
                                        </a>
                                    @else
                                        <a href="{{ route('reservations.create', [
                                            'chambre_id' => $chambre->id,
                                            'date_debut' => $filters['date_debut'] ?? null,
                                            'date_fin' => $filters['date_fin'] ?? null,
                                        ]) }}" class="btn-primary !py-2 !px-4 !text-xs">
                                            Book Now
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </article>
                    @empty
                        <div class="card p-12 text-center md:col-span-2 xl:col-span-3">
                            <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-2xl bg-blue-50 text-blue-400">
                                <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                                </svg>
                            </div>
                            <h3 class="mt-4 text-lg font-semibold text-gray-900">No rooms found</h3>
                            <p class="mt-2 text-sm text-gray-500">Try adjusting your filters or dates to find available rooms.</p>
                        </div>
                    @endforelse
                </div>

                {{-- Pagination --}}
                <div class="mt-2">
                    {{ $chambres->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
