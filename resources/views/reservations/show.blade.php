<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <div class="flex items-center gap-2 text-sm text-gray-500">
                    <a href="{{ route($isAdminView ? 'admin.reservations.index' : 'reservations.index') }}" class="hover:text-blue-600 transition-colors">Bookings</a>
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" /></svg>
                    <span class="text-gray-900 font-medium">Booking #{{ $reservation->id }}</span>
                </div>
                <h2 class="mt-1 text-xl font-bold text-gray-900">Booking Confirmation</h2>
            </div>
            @if ($reservation->status !== 'cancelled')
                <a href="{{ route($isAdminView ? 'admin.reservations.edit' : 'reservations.edit', $reservation) }}" class="btn-secondary">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" /></svg>
                    Modify Booking
                </a>
            @endif
        </div>
    </x-slot>

    <div class="py-8 animate-fade-in">
        <div class="mx-auto grid max-w-7xl gap-6 px-4 sm:px-6 lg:grid-cols-3 lg:px-8">
            {{-- ── Booking Details ── --}}
            <section class="card p-6 lg:col-span-2 space-y-6">
                {{-- Booking ID Header --}}
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-blue-100">
                            <svg class="h-6 w-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15 9h3.75M15 12h3.75M15 15h3.75M4.5 19.5h15a2.25 2.25 0 002.25-2.25V6.75A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25v10.5A2.25 2.25 0 004.5 19.5zm6-10.125a1.875 1.875 0 11-3.75 0 1.875 1.875 0 013.75 0zm1.294 6.336a6.721 6.721 0 01-3.17.789 6.721 6.721 0 01-3.168-.789 3.376 3.376 0 016.338 0z" /></svg>
                        </div>
                        <div>
                            <p class="text-xs font-semibold uppercase tracking-wide text-gray-500">Booking ID</p>
                            <p class="text-lg font-bold text-gray-900">#{{ str_pad($reservation->id, 6, '0', STR_PAD_LEFT) }}</p>
                        </div>
                    </div>
                    @php
                        $badgeClass = match($reservation->status) {
                            'pending' => 'badge-pending',
                            'confirmed' => 'badge-confirmed',
                            'cancelled' => 'badge-cancelled',
                            default => 'badge-pending',
                        };
                    @endphp
                    <span class="badge {{ $badgeClass }} !text-sm !px-4 !py-1.5">{{ $reservation->statusLabel() }}</span>
                </div>

                <div class="border-t border-gray-100"></div>

                {{-- Details Grid --}}
                <div class="grid gap-5 sm:grid-cols-2">
                    <div class="flex items-start gap-3">
                        <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-blue-50 text-blue-600">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" /></svg>
                        </div>
                        <div>
                            <p class="text-xs font-semibold uppercase tracking-wide text-gray-500">Room</p>
                            <p class="mt-1 text-sm font-bold text-gray-900">Room {{ $reservation->chambre->numero }} — {{ $reservation->chambre->type }}</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-3">
                        <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-purple-50 text-purple-600">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" /></svg>
                        </div>
                        <div>
                            <p class="text-xs font-semibold uppercase tracking-wide text-gray-500">Guest</p>
                            <p class="mt-1 text-sm font-bold text-gray-900">{{ $reservation->user->name }}</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-3">
                        <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-emerald-50 text-emerald-600">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5" /></svg>
                        </div>
                        <div>
                            <p class="text-xs font-semibold uppercase tracking-wide text-gray-500">Check-in</p>
                            <p class="mt-1 text-sm font-bold text-gray-900">{{ $reservation->date_debut->format('l, M d, Y') }}</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-3">
                        <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-amber-50 text-amber-600">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5" /></svg>
                        </div>
                        <div>
                            <p class="text-xs font-semibold uppercase tracking-wide text-gray-500">Check-out</p>
                            <p class="mt-1 text-sm font-bold text-gray-900">{{ $reservation->date_fin->format('l, M d, Y') }}</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-3">
                        <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-sky-50 text-sky-600">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M21.752 15.002A9.718 9.718 0 0118 15.75c-5.385 0-9.75-4.365-9.75-9.75 0-1.33.266-2.597.748-3.752A9.753 9.753 0 003 11.25C3 16.635 7.365 21 12.75 21a9.753 9.753 0 009.002-5.998z" /></svg>
                        </div>
                        <div>
                            <p class="text-xs font-semibold uppercase tracking-wide text-gray-500">Nights</p>
                            <p class="mt-1 text-sm font-bold text-gray-900">{{ $reservation->nights() }} {{ $reservation->nights() === 1 ? 'night' : 'nights' }}</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-3">
                        <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-pink-50 text-pink-600">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" /></svg>
                        </div>
                        <div>
                            <p class="text-xs font-semibold uppercase tracking-wide text-gray-500">Guests</p>
                            <p class="mt-1 text-sm font-bold text-gray-900">{{ $reservation->nombre_personnes }} {{ $reservation->nombre_personnes === 1 ? 'guest' : 'guests' }}</p>
                        </div>
                    </div>
                </div>

                {{-- Price Summary --}}
                <div class="rounded-xl bg-gradient-to-br from-blue-50 to-blue-100/50 p-5 ring-1 ring-blue-200/50">
                    <div class="flex items-center justify-between text-sm text-gray-600">
                        <span>{{ number_format($reservation->chambre->prix, 2) }} MAD × {{ $reservation->nights() }} nights</span>
                        <span class="font-medium">{{ number_format($reservation->prix_total, 2) }} MAD</span>
                    </div>
                    <div class="mt-3 flex items-center justify-between border-t border-blue-200/50 pt-3">
                        <span class="text-base font-bold text-gray-900">Total</span>
                        <span class="text-2xl font-extrabold text-blue-700">{{ number_format($reservation->prix_total, 2) }} MAD</span>
                    </div>
                </div>
            </section>

            {{-- ── Payment Sidebar ── --}}
            <aside class="space-y-6">
                {{-- Payment Status Card --}}
                <div class="card p-6">
                    <h3 class="text-lg font-bold text-gray-900 flex items-center gap-2">
                        <svg class="h-5 w-5 text-blue-500" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 8.25h19.5M2.25 9h19.5m-16.5 5.25h6m-6 2.25h3m-3.75 3h15a2.25 2.25 0 002.25-2.25V6.75A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25v10.5A2.25 2.25 0 004.5 19.5z" /></svg>
                        Payment
                    </h3>
                    <dl class="mt-4 space-y-4">
                        <div class="flex items-center justify-between">
                            <dt class="text-sm text-gray-500">Status</dt>
                            <dd>
                                @php
                                    $payStatus = $reservation->payment?->status ?? 'pending';
                                    $payBadge = $payStatus === 'paid' ? 'badge-paid' : 'badge-pending';
                                @endphp
                                <span class="badge {{ $payBadge }}">{{ ucfirst($payStatus) }}</span>
                            </dd>
                        </div>
                        <div class="flex items-center justify-between">
                            <dt class="text-sm text-gray-500">Method</dt>
                            <dd class="text-sm font-semibold text-gray-900">{{ $reservation->payment ? (\App\Models\Payment::METHOD_LABELS[$reservation->payment->method] ?? $reservation->payment->method) : '—' }}</dd>
                        </div>
                        <div class="flex items-center justify-between gap-4">
                            <dt class="text-sm text-gray-500">Transaction</dt>
                            <dd class="text-xs font-mono font-semibold text-gray-700 break-all text-right">{{ $reservation->payment?->transaction_id ?? '—' }}</dd>
                        </div>
                    </dl>

                    @if ($reservation->canBePaid())
                        <form method="POST" action="{{ route($isAdminView ? 'admin.payments.store' : 'payments.store', $reservation) }}" class="mt-6 space-y-4">
                            @csrf
                            <div>
                                <x-input-label for="method" value="Payment Method" />
                                <select id="method" name="method" class="form-input-blue mt-1 text-sm">
                                    @foreach (\App\Models\Payment::METHOD_LABELS as $method => $label)
                                        <option value="{{ $method }}">{{ $label }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <button class="btn-primary w-full justify-center !py-3">
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                Process Payment
                            </button>
                        </form>
                    @endif
                </div>

                {{-- Cancel --}}
                @if ($reservation->status !== 'cancelled')
                    <form method="POST" action="{{ route($isAdminView ? 'admin.reservations.destroy' : 'reservations.destroy', $reservation) }}" onsubmit="return confirm('Are you sure you want to cancel this booking?')">
                        @csrf
                        @method('DELETE')
                        <button class="btn-danger w-full justify-center">
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>
                            Cancel Booking
                        </button>
                    </form>
                @endif
            </aside>
        </div>
    </div>
</x-app-layout>
