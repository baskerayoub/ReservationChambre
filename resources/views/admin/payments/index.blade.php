@extends('layouts.app')
@section('title', 'Payments')
@section('hide_footer', true)

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <h1 class="text-2xl font-bold mb-6">Payments</h1>
    <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-200 dark:border-gray-700 overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 dark:bg-gray-700/50">
                <tr><th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">ID</th><th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Guest</th><th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Room</th><th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Method</th><th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th><th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Amount</th><th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Date</th></tr>
            </thead>
            <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                @foreach($payments as $p)
                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/30">
                    <td class="px-6 py-4 font-mono text-gray-400">#{{ $p->id }}</td>
                    <td class="px-6 py-4 font-medium">{{ $p->user->name }}</td>
                    <td class="px-6 py-4">{{ $p->reservation->room->name ?? 'N/A' }}</td>
                    <td class="px-6 py-4"><span class="px-2 py-1 text-xs rounded-full font-medium {{ $p->method === 'stripe' ? 'bg-indigo-100 text-indigo-700 dark:bg-indigo-500/10 dark:text-indigo-400' : 'bg-blue-100 text-blue-700 dark:bg-blue-500/10 dark:text-blue-400' }}"><i class="fab fa-{{ $p->method }} mr-1"></i>{{ ucfirst($p->method) }}</span></td>
                    <td class="px-6 py-4"><span class="px-2 py-1 text-xs rounded-full font-medium {{ $p->status === 'completed' ? 'bg-emerald-100 text-emerald-700 dark:bg-emerald-500/10 dark:text-emerald-400' : 'bg-yellow-100 text-yellow-700' }}">{{ ucfirst($p->status) }}</span></td>
                    <td class="px-6 py-4 text-right font-bold">${{ number_format($p->amount, 2) }}</td>
                    <td class="px-6 py-4 text-right text-gray-400">{{ $p->created_at->format('M d, Y') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="mt-6">{{ $payments->links() }}</div>
</div>
@endsection
