<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <div class="flex items-center gap-2 text-sm text-gray-500">
                    <a href="{{ route($isAdminView ? 'admin.chambres.index' : 'chambres.index') }}" class="hover:text-blue-600 transition-colors">Rooms</a>
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" /></svg>
                    <span class="text-gray-900 font-medium">Room {{ $chambre->numero }}</span>
                </div>
                <h2 class="mt-1 text-xl font-bold text-gray-900">Room {{ $chambre->numero }} — {{ $chambre->type }}</h2>
            </div>
            @if ($isAdminView)
                <a href="{{ route('admin.chambres.edit', $chambre) }}" class="btn-primary">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" /></svg>
                    Edit Room
                </a>
            @endif
        </div>
    </x-slot>

    <div class="py-8 animate-fade-in">
        <div class="mx-auto grid max-w-7xl gap-6 px-4 sm:px-6 lg:grid-cols-3 lg:px-8">
            {{-- ── Main Content ── --}}
            <section class="space-y-6 lg:col-span-2">
                {{-- Image --}}
                <div class="card overflow-hidden">
                    <div class="aspect-[16/9] overflow-hidden relative">
                        @if ($chambre->image)
                            <img src="{{ $chambre->image }}" alt="Room {{ $chambre->numero }}" class="h-full w-full object-cover">
                        @else
                            <div class="flex h-full items-center justify-center bg-gradient-to-br from-blue-600 to-blue-800 text-2xl font-bold text-white">
                                Room {{ $chambre->numero }}
                            </div>
                        @endif
                        {{-- Status overlay --}}
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
                </div>

                {{-- Details --}}
                <div class="card p-6 space-y-6">
                    <div class="flex flex-wrap items-start justify-between gap-4">
                        <div>
                            <p class="text-sm font-semibold text-blue-600">{{ $chambre->type }} · {{ $chambre->confort }}</p>
                            <h3 class="mt-1 text-3xl font-extrabold text-gray-900">{{ number_format($chambre->prix, 2) }} MAD <span class="text-base font-medium text-gray-400">/ night</span></h3>
                        </div>
                    </div>

                    <p class="text-gray-600 leading-relaxed">{{ $chambre->description ?: 'A wonderful room prepared for your comfort. Enjoy your stay with premium amenities and a relaxing atmosphere.' }}</p>

                    {{-- Info grid --}}
                    <div class="grid gap-4 sm:grid-cols-2">
                        <div class="rounded-xl border border-gray-100 bg-gray-50/50 p-4 flex items-start gap-3">
                            <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-blue-100 text-blue-600">
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" /></svg>
                            </div>
                            <div>
                                <p class="text-xs font-semibold uppercase tracking-wide text-gray-500">Room Type</p>
                                <p class="mt-1 text-sm font-semibold text-gray-900">{{ $chambre->type }}</p>
                            </div>
                        </div>
                        <div class="rounded-xl border border-gray-100 bg-gray-50/50 p-4 flex items-start gap-3">
                            <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-purple-100 text-purple-600">
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9.813 15.904L9 18.75l-.813-2.846a4.5 4.5 0 00-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 003.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 003.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 00-3.09 3.09zM18.259 8.715L18 9.75l-.259-1.035a3.375 3.375 0 00-2.455-2.456L14.25 6l1.036-.259a3.375 3.375 0 002.455-2.456L18 2.25l.259 1.035a3.375 3.375 0 002.455 2.456L21.75 6l-1.036.259a3.375 3.375 0 00-2.455 2.456zM16.894 20.567L16.5 21.75l-.394-1.183a2.25 2.25 0 00-1.423-1.423L13.5 18.75l1.183-.394a2.25 2.25 0 001.423-1.423l.394-1.183.394 1.183a2.25 2.25 0 001.423 1.423l1.183.394-1.183.394a2.25 2.25 0 00-1.423 1.423z" /></svg>
                            </div>
                            <div>
                                <p class="text-xs font-semibold uppercase tracking-wide text-gray-500">Comfort Level</p>
                                <p class="mt-1 text-sm font-semibold text-gray-900">{{ $chambre->confort }}</p>
                            </div>
                        </div>
                    </div>

                    {{-- Amenities --}}
                    <div>
                        <h4 class="text-sm font-bold text-gray-900 flex items-center gap-2">
                            <svg class="h-4 w-4 text-blue-500" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9.568 3H5.25A2.25 2.25 0 003 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581c.699.699 1.78.872 2.607.33a18.095 18.095 0 005.223-5.223c.542-.827.369-1.908-.33-2.607L11.16 3.66A2.25 2.25 0 009.568 3z" /><path stroke-linecap="round" stroke-linejoin="round" d="M6 6h.008v.008H6V6z" /></svg>
                            Amenities
                        </h4>
                        <div class="mt-3 flex flex-wrap gap-2">
                            @forelse ($chambre->equipements_list as $item)
                                <span class="inline-flex items-center gap-1.5 rounded-xl bg-blue-50 px-3.5 py-2 text-sm font-medium text-blue-700 ring-1 ring-blue-100">
                                    <svg class="h-3.5 w-3.5 text-blue-400" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" /></svg>
                                    {{ $item }}
                                </span>
                            @empty
                                <span class="text-sm text-gray-400 italic">No amenities listed.</span>
                            @endforelse
                        </div>
                    </div>
                </div>
            </section>

            {{-- ── Sidebar ── --}}
            <aside class="space-y-6">
                {{-- Availability Checker --}}
                <div class="card p-6">
                    <h3 class="text-lg font-bold text-gray-900 flex items-center gap-2">
                        <svg class="h-5 w-5 text-blue-500" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5" /></svg>
                        Check Availability
                    </h3>
                    <form method="GET" action="{{ route($isAdminView ? 'admin.chambres.show' : 'chambres.show', $chambre) }}" class="mt-4 space-y-4">
                        <div>
                            <x-input-label for="date_debut" value="Check-in" />
                            <x-text-input id="date_debut" name="date_debut" type="date" class="mt-1 block w-full" :value="$filters['date_debut'] ?? ''" />
                        </div>
                        <div>
                            <x-input-label for="date_fin" value="Check-out" />
                            <x-text-input id="date_fin" name="date_fin" type="date" class="mt-1 block w-full" :value="$filters['date_fin'] ?? ''" />
                        </div>
                        <button class="btn-secondary w-full">
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" /></svg>
                            Check Dates
                        </button>
                    </form>

                    @if (! is_null($isAvailableForDates))
                        <div class="mt-5 flex items-center gap-3 rounded-xl px-4 py-3 text-sm font-medium {{ $isAvailableForDates ? 'bg-emerald-50 text-emerald-700 ring-1 ring-emerald-200' : 'bg-red-50 text-red-700 ring-1 ring-red-200' }}">
                            @if ($isAvailableForDates)
                                <svg class="h-5 w-5 shrink-0 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                Available for your selected dates!
                            @else
                                <svg class="h-5 w-5 shrink-0 text-red-500" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9.75 9.75l4.5 4.5m0-4.5l-4.5 4.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                Not available for these dates.
                            @endif
                        </div>
                    @endif
                </div>

                {{-- Book Now Card --}}
                @if (! $isAdminView)
                    <div class="card overflow-hidden">
                        <div class="bg-gradient-to-br from-blue-600 to-blue-700 p-6 text-center">
                            <p class="text-blue-200 text-sm font-medium">Starting from</p>
                            <p class="mt-1 text-3xl font-extrabold text-white">{{ number_format($chambre->prix, 0) }} MAD</p>
                            <p class="text-blue-200 text-sm">per night</p>
                        </div>
                        <div class="p-5">
                            <a href="{{ route('reservations.create', [
                                'chambre_id' => $chambre->id,
                                'date_debut' => $filters['date_debut'] ?? null,
                                'date_fin' => $filters['date_fin'] ?? null,
                            ]) }}" class="btn-primary w-full justify-center !py-3.5 !text-base">
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5m-9-3.75h.008v.008H12v-.008z" /></svg>
                                Book This Room
                            </a>
                            <p class="mt-3 text-center text-xs text-gray-500">Free cancellation · Instant confirmation</p>
                        </div>
                    </div>
                @endif
            </aside>
        </div>
    </div>
</x-app-layout>
