@extends('layouts.app')
@section('title', 'Admin Dashboard')
@section('hide_footer', true)

@section('content')
<div class="flex min-h-[calc(100vh-64px)]">
    {{-- Sidebar --}}
    <aside class="hidden lg:flex w-64 flex-col bg-white dark:bg-gray-800 border-r border-gray-200 dark:border-gray-700 p-4">
        <div class="mb-6">
            <h3 class="text-xs font-semibold uppercase text-gray-400 tracking-wider px-3 mb-2">Management</h3>
            <nav class="space-y-1">
                @foreach([
                    ['admin.dashboard', 'gauge-high', 'Dashboard'],
                    ['admin.rooms', 'bed', 'Rooms'],
                    ['admin.reservations', 'calendar-check', 'Reservations'],
                    ['admin.users', 'users', 'Users'],
                    ['admin.payments', 'credit-card', 'Payments'],
                    ['admin.reviews', 'star', 'Reviews'],
                ] as $item)
                <a href="{{ route($item[0]) }}" class="flex items-center gap-3 px-3 py-2.5 text-sm font-medium rounded-xl transition-colors {{ request()->routeIs($item[0]) ? 'bg-amber-50 dark:bg-amber-500/10 text-amber-600 dark:text-amber-400' : 'text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                    <i class="fas fa-{{ $item[1] }} w-5 text-center"></i> {{ $item[2] }}
                </a>
                @endforeach
            </nav>
        </div>
    </aside>

    {{-- Main Content --}}
    <div class="flex-1 p-6 lg:p-8 overflow-y-auto">
        <div class="max-w-6xl mx-auto">
            <h1 class="text-2xl font-bold mb-6">Dashboard</h1>

            {{-- Stats Grid --}}
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
                @foreach([
                    ['Total Rooms', $stats['total_rooms'], 'bed', 'from-blue-500 to-indigo-500', 'blue'],
                    ['Reservations', $stats['total_reservations'], 'calendar-check', 'from-emerald-500 to-teal-500', 'emerald'],
                    ['Monthly Revenue', '$'.number_format($stats['monthly_revenue'],0), 'dollar-sign', 'from-amber-500 to-orange-500', 'amber'],
                    ['Occupancy', $stats['occupancy_rate'].'%', 'chart-pie', 'from-purple-500 to-pink-500', 'purple'],
                ] as $stat)
                <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-200 dark:border-gray-700 p-5 hover:shadow-lg transition-shadow">
                    <div class="flex items-center justify-between mb-3">
                        <span class="text-xs font-medium text-gray-400 uppercase tracking-wider">{{ $stat[0] }}</span>
                        <div class="w-9 h-9 bg-gradient-to-br {{ $stat[3] }} rounded-xl flex items-center justify-center">
                            <i class="fas fa-{{ $stat[2] }} text-white text-sm"></i>
                        </div>
                    </div>
                    <p class="text-2xl font-bold">{{ $stat[1] }}</p>
                </div>
                @endforeach
            </div>

            {{-- Second Row Stats --}}
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
                @foreach([
                    ['Available', $stats['available_rooms'], 'check-circle', 'text-emerald-500'],
                    ['Pending', $stats['pending_reservations'], 'clock', 'text-yellow-500'],
                    ['Active Now', $stats['active_reservations'], 'door-open', 'text-blue-500'],
                    ['Total Revenue', '$'.number_format($stats['total_revenue'],0), 'coins', 'text-amber-500'],
                ] as $stat)
                <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-200 dark:border-gray-700 p-4 flex items-center gap-3">
                    <i class="fas fa-{{ $stat[2] }} text-xl {{ $stat[3] }}"></i>
                    <div>
                        <p class="text-xs text-gray-400">{{ $stat[0] }}</p>
                        <p class="text-lg font-bold">{{ $stat[1] }}</p>
                    </div>
                </div>
                @endforeach
            </div>

            {{-- Revenue Chart --}}
            <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-200 dark:border-gray-700 p-6 mb-8">
                <h3 class="font-semibold mb-4">Revenue Overview (Last 6 Months)</h3>
                <div class="flex items-end gap-3 h-48">
                    @php $maxRev = $revenueChart->max('revenue') ?: 1; @endphp
                    @foreach($revenueChart as $item)
                    <div class="flex-1 flex flex-col items-center gap-2">
                        <span class="text-xs font-medium">${{ number_format($item['revenue'], 0) }}</span>
                        <div class="w-full bg-gradient-to-t from-amber-500 to-orange-400 rounded-t-lg transition-all duration-500" style="height: {{ max(($item['revenue'] / $maxRev) * 100, 4) }}%"></div>
                        <span class="text-xs text-gray-400">{{ Str::limit($item['month'], 3, '') }}</span>
                    </div>
                    @endforeach
                </div>
            </div>

            {{-- Recent Reservations --}}
            <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-200 dark:border-gray-700 overflow-hidden">
                <div class="p-6 border-b border-gray-200 dark:border-gray-700 flex justify-between items-center">
                    <h3 class="font-semibold">Recent Reservations</h3>
                    <a href="{{ route('admin.reservations') }}" class="text-sm text-amber-500 hover:underline">View All</a>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead class="bg-gray-50 dark:bg-gray-700/50">
                            <tr><th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Guest</th><th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Room</th><th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Dates</th><th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th><th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Amount</th></tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                            @foreach($recentReservations as $r)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/30">
                                <td class="px-6 py-4 font-medium">{{ $r->user->name }}</td>
                                <td class="px-6 py-4 text-gray-500">{{ $r->room->name }}</td>
                                <td class="px-6 py-4 text-gray-500">{{ $r->check_in->format('M d') }} — {{ $r->check_out->format('M d') }}</td>
                                <td class="px-6 py-4">
                                    @php $colors=['pending'=>'yellow','confirmed'=>'emerald','cancelled'=>'red','completed'=>'blue']; @endphp
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-{{ $colors[$r->status] }}-100 text-{{ $colors[$r->status] }}-700 dark:bg-{{ $colors[$r->status] }}-500/10 dark:text-{{ $colors[$r->status] }}-400">{{ ucfirst($r->status) }}</span>
                                </td>
                                <td class="px-6 py-4 text-right font-bold">${{ number_format($r->total_price, 2) }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
