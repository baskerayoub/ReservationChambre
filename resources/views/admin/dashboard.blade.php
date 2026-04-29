<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h2 class="text-xl font-bold text-gray-900">Dashboard</h2>
                <p class="mt-1 text-sm text-gray-500">Welcome back! Here's an overview of your hotel operations.</p>
            </div>
            <div class="flex gap-3">
                <a href="{{ route('admin.chambres.index') }}" class="btn-secondary !py-2">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" /></svg>
                    Rooms
                </a>
                <a href="{{ route('admin.reservations.index') }}" class="btn-primary !py-2">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5" /></svg>
                    Bookings
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-8 animate-fade-in">
        <div class="mx-auto max-w-7xl space-y-8 px-4 sm:px-6 lg:px-8">
            {{-- ────────────── STAT CARDS ────────────── --}}
            <div class="grid gap-5 sm:grid-cols-2 xl:grid-cols-4">
                {{-- Total Rooms --}}
                <div class="stat-card bg-gradient-to-br from-blue-500 to-blue-700 animate-fade-in-up">
                    <div class="relative z-10 flex items-start justify-between">
                        <div>
                            <p class="text-sm font-medium text-blue-100">Total Rooms</p>
                            <p class="mt-2 text-4xl font-extrabold">{{ $totalRooms }}</p>
                            <p class="mt-1 text-sm text-blue-200">{{ $availableRooms }} available · {{ $maintenanceRooms }} maintenance</p>
                        </div>
                        <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-white/15">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" /></svg>
                        </div>
                    </div>
                </div>

                {{-- Total Bookings --}}
                <div class="stat-card bg-gradient-to-br from-emerald-500 to-emerald-700 animate-fade-in-up animation-delay-100">
                    <div class="relative z-10 flex items-start justify-between">
                        <div>
                            <p class="text-sm font-medium text-emerald-100">Total Bookings</p>
                            <p class="mt-2 text-4xl font-extrabold">{{ $totalReservations }}</p>
                            <p class="mt-1 text-sm text-emerald-200">{{ $pendingReservations }} pending</p>
                        </div>
                        <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-white/15">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5" /></svg>
                        </div>
                    </div>
                </div>

                {{-- Confirmed --}}
                <div class="stat-card bg-gradient-to-br from-amber-500 to-orange-600 animate-fade-in-up animation-delay-200">
                    <div class="relative z-10 flex items-start justify-between">
                        <div>
                            <p class="text-sm font-medium text-amber-100">Confirmed</p>
                            <p class="mt-2 text-4xl font-extrabold">{{ $confirmedReservations }}</p>
                            <p class="mt-1 text-sm text-amber-200">{{ $cancelledReservations }} cancelled</p>
                        </div>
                        <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-white/15">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                        </div>
                    </div>
                </div>

                {{-- Revenue --}}
                <div class="stat-card bg-gradient-to-br from-purple-500 to-purple-700 animate-fade-in-up animation-delay-300">
                    <div class="relative z-10 flex items-start justify-between">
                        <div>
                            <p class="text-sm font-medium text-purple-100">Total Revenue</p>
                            <p class="mt-2 text-4xl font-extrabold">{{ number_format($totalRevenue, 0) }}</p>
                            <p class="mt-1 text-sm text-purple-200">MAD collected</p>
                        </div>
                        <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-white/15">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18.75a60.07 60.07 0 0115.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 013 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 00-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 01-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 003 15h-.75M15 10.5a3 3 0 11-6 0 3 3 0 016 0zm3 0h.008v.008H18V10.5zm-12 0h.008v.008H6V10.5z" /></svg>
                        </div>
                    </div>
                </div>
            </div>

            {{-- ────────────── MAIN CONTENT ────────────── --}}
            <div class="grid gap-6 lg:grid-cols-3">
                {{-- Recent Bookings --}}
                <section class="card overflow-hidden lg:col-span-2 animate-fade-in-up animation-delay-400">
                    <div class="flex items-center justify-between border-b border-gray-100 px-6 py-4">
                        <h3 class="text-base font-bold text-gray-900 flex items-center gap-2">
                            <svg class="h-5 w-5 text-blue-500" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                            Recent Bookings
                        </h3>
                        <a href="{{ route('admin.reservations.index') }}" class="text-sm font-semibold text-blue-600 hover:text-blue-700 transition-colors">View all →</a>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-100">
                            <thead class="bg-gray-50/50">
                                <tr>
                                    <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">Guest</th>
                                    <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">Room</th>
                                    <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">Dates</th>
                                    <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">Status</th>
                                    <th class="px-5 py-3 text-right text-xs font-semibold uppercase tracking-wide text-gray-500">Total</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-50">
                                @forelse ($recentReservations as $reservation)
                                    <tr class="hover:bg-blue-50/30 transition-colors">
                                        <td class="whitespace-nowrap px-5 py-4">
                                            <div class="flex items-center gap-3">
                                                <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-blue-100 text-xs font-bold text-blue-700">
                                                    {{ strtoupper(substr($reservation->user->name, 0, 1)) }}
                                                </div>
                                                <span class="text-sm font-medium text-gray-900">{{ $reservation->user->name }}</span>
                                            </div>
                                        </td>
                                        <td class="whitespace-nowrap px-5 py-4 text-sm font-semibold text-gray-900">Room {{ $reservation->chambre->numero }}</td>
                                        <td class="whitespace-nowrap px-5 py-4 text-sm text-gray-500">{{ $reservation->date_debut->format('M d') }} — {{ $reservation->date_fin->format('M d, Y') }}</td>
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
                                        <td class="whitespace-nowrap px-5 py-4 text-right text-sm font-bold text-gray-900">{{ number_format($reservation->prix_total, 0) }} MAD</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-5 py-12 text-center text-sm text-gray-400">No bookings yet.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </section>

                {{-- Payment Breakdown --}}
                <section class="card p-6 animate-fade-in-up animation-delay-500">
                    <h3 class="text-base font-bold text-gray-900 flex items-center gap-2">
                        <svg class="h-5 w-5 text-blue-500" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 8.25h19.5M2.25 9h19.5m-16.5 5.25h6m-6 2.25h3m-3.75 3h15a2.25 2.25 0 002.25-2.25V6.75A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25v10.5A2.25 2.25 0 004.5 19.5z" /></svg>
                        Revenue by Method
                    </h3>

                    <div class="mt-6 space-y-5">
                        {{-- Stripe --}}
                        <div>
                            <div class="flex justify-between text-sm mb-2">
                                <span class="font-semibold text-gray-700 flex items-center gap-2">
                                    <span class="h-2.5 w-2.5 rounded-full bg-indigo-500"></span>
                                    Stripe
                                </span>
                                <span class="font-bold text-gray-900">{{ number_format($stripeRevenue, 0) }} MAD</span>
                            </div>
                            <div class="h-2.5 rounded-full bg-gray-100 overflow-hidden">
                                <div class="h-full rounded-full bg-gradient-to-r from-indigo-400 to-indigo-600 transition-all duration-1000 ease-out" style="width: {{ $totalRevenue > 0 ? min(100, ($stripeRevenue / $totalRevenue) * 100) : 0 }}%"></div>
                            </div>
                        </div>

                        {{-- PayPal --}}
                        <div>
                            <div class="flex justify-between text-sm mb-2">
                                <span class="font-semibold text-gray-700 flex items-center gap-2">
                                    <span class="h-2.5 w-2.5 rounded-full bg-sky-500"></span>
                                    PayPal
                                </span>
                                <span class="font-bold text-gray-900">{{ number_format($paypalRevenue, 0) }} MAD</span>
                            </div>
                            <div class="h-2.5 rounded-full bg-gray-100 overflow-hidden">
                                <div class="h-full rounded-full bg-gradient-to-r from-sky-400 to-sky-600 transition-all duration-1000 ease-out" style="width: {{ $totalRevenue > 0 ? min(100, ($paypalRevenue / $totalRevenue) * 100) : 0 }}%"></div>
                            </div>
                        </div>

                        {{-- Cash --}}
                        <div>
                            <div class="flex justify-between text-sm mb-2">
                                <span class="font-semibold text-gray-700 flex items-center gap-2">
                                    <span class="h-2.5 w-2.5 rounded-full bg-emerald-500"></span>
                                    On-site Payment
                                </span>
                                <span class="font-bold text-gray-900">{{ number_format($cashRevenue, 0) }} MAD</span>
                            </div>
                            <div class="h-2.5 rounded-full bg-gray-100 overflow-hidden">
                                <div class="h-full rounded-full bg-gradient-to-r from-emerald-400 to-emerald-600 transition-all duration-1000 ease-out" style="width: {{ $totalRevenue > 0 ? min(100, ($cashRevenue / $totalRevenue) * 100) : 0 }}%"></div>
                            </div>
                        </div>
                    </div>

                    {{-- Room Status --}}
                    <div class="mt-8 pt-6 border-t border-gray-100">
                        <h4 class="text-sm font-bold text-gray-900 mb-4">Room Status</h4>
                        <div class="space-y-3">
                            @foreach ($roomsByStatus as $status => $count)
                                @php
                                    $statusInfo = match($status) {
                                        'disponible' => ['label' => 'Available', 'color' => 'bg-emerald-500', 'bg' => 'bg-emerald-50', 'text' => 'text-emerald-700'],
                                        'occupee' => ['label' => 'Occupied', 'color' => 'bg-purple-500', 'bg' => 'bg-purple-50', 'text' => 'text-purple-700'],
                                        'maintenance' => ['label' => 'Maintenance', 'color' => 'bg-orange-500', 'bg' => 'bg-orange-50', 'text' => 'text-orange-700'],
                                        default => ['label' => ucfirst($status), 'color' => 'bg-gray-500', 'bg' => 'bg-gray-50', 'text' => 'text-gray-700'],
                                    };
                                @endphp
                                <div class="flex items-center justify-between rounded-xl {{ $statusInfo['bg'] }} px-4 py-3">
                                    <span class="flex items-center gap-2 text-sm font-medium {{ $statusInfo['text'] }}">
                                        <span class="h-2 w-2 rounded-full {{ $statusInfo['color'] }}"></span>
                                        {{ $statusInfo['label'] }}
                                    </span>
                                    <span class="text-sm font-bold {{ $statusInfo['text'] }}">{{ $count }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    {{-- Quick Actions --}}
                    <div class="mt-6 grid gap-3">
                        <a href="{{ route('admin.chambres.create') }}" class="btn-primary w-full justify-center">
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" /></svg>
                            Add New Room
                        </a>
                    </div>
                </section>
            </div>
        </div>
    </div>
</x-app-layout>
