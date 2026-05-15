@extends('layouts.app')
@section('title', 'Manage Reservations')
@section('hide_footer', true)

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold">Manage Reservations</h1>
        <div class="flex gap-2">
            @foreach([''=>'All','pending'=>'Pending','confirmed'=>'Confirmed','completed'=>'Completed','cancelled'=>'Cancelled'] as $val => $label)
            <a href="{{ route('admin.reservations', ['status' => $val]) }}" class="px-3 py-1.5 text-xs font-medium rounded-full transition-colors {{ request('status') === $val ? 'bg-amber-500 text-white' : 'bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300 hover:bg-gray-200' }}">{{ $label }}</a>
            @endforeach
        </div>
    </div>
    <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-200 dark:border-gray-700 overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 dark:bg-gray-700/50">
                <tr><th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">ID</th><th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Guest</th><th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Room</th><th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Dates</th><th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Amount</th><th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th><th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Action</th></tr>
            </thead>
            <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                @foreach($reservations as $r)
                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/30">
                    <td class="px-6 py-4 font-mono text-gray-400">#{{ $r->id }}</td>
                    <td class="px-6 py-4 font-medium">{{ $r->user->name }}<br><span class="text-xs text-gray-400">{{ $r->user->email }}</span></td>
                    <td class="px-6 py-4">{{ $r->room->name }}</td>
                    <td class="px-6 py-4 text-gray-500">{{ $r->check_in->format('M d') }} — {{ $r->check_out->format('M d, Y') }}</td>
                    <td class="px-6 py-4 font-semibold">${{ number_format($r->total_price, 2) }}</td>
                    <td class="px-6 py-4">
                        <form method="POST" action="{{ route('admin.reservations.status', $r) }}">@csrf @method('PATCH')
                            <select name="status" onchange="this.form.submit()" class="text-xs rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:ring-amber-500">
                                @foreach(['pending','confirmed','cancelled','completed'] as $s)<option value="{{ $s }}" {{ $r->status === $s ? 'selected' : '' }}>{{ ucfirst($s) }}</option>@endforeach
                            </select>
                        </form>
                    </td>
                    <td class="px-6 py-4 text-right">
                        @if($r->payment)<span class="text-xs {{ $r->payment->status === 'completed' ? 'text-emerald-500' : 'text-yellow-500' }}"><i class="fas fa-{{ $r->payment->status === 'completed' ? 'check' : 'clock' }}"></i> {{ ucfirst($r->payment->method) }}</span>@else<span class="text-xs text-gray-400">No payment</span>@endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="mt-6">{{ $reservations->links() }}</div>
</div>
@endsection
