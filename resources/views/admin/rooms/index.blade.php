@extends('layouts.app')
@section('title', 'Manage Rooms')
@section('hide_footer', true)

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold">Manage Rooms</h1>
        <a href="{{ route('admin.rooms.create') }}" class="px-5 py-2.5 bg-gradient-to-r from-amber-500 to-orange-500 text-white text-sm font-semibold rounded-xl"><i class="fas fa-plus mr-1"></i> Add Room</a>
    </div>
    <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-200 dark:border-gray-700 overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 dark:bg-gray-700/50">
                <tr><th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Room</th><th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Type</th><th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Price</th><th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th><th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Bookings</th><th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Actions</th></tr>
            </thead>
            <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                @foreach($rooms as $room)
                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/30">
                    <td class="px-6 py-4 font-medium">{{ $room->name }}</td>
                    <td class="px-6 py-4"><span class="px-2 py-1 bg-amber-100 dark:bg-amber-500/10 text-amber-700 dark:text-amber-400 text-xs rounded-full font-medium">{{ ucfirst($room->type) }}</span></td>
                    <td class="px-6 py-4 font-semibold">${{ number_format($room->price_per_night,2) }}</td>
                    <td class="px-6 py-4"><span class="px-2 py-1 text-xs rounded-full font-medium {{ $room->status === 'available' ? 'bg-emerald-100 text-emerald-700 dark:bg-emerald-500/10 dark:text-emerald-400' : 'bg-red-100 text-red-700 dark:bg-red-500/10 dark:text-red-400' }}">{{ ucfirst($room->status) }}</span></td>
                    <td class="px-6 py-4 text-gray-500">{{ $room->reservations_count }}</td>
                    <td class="px-6 py-4 text-right">
                        <a href="{{ route('admin.rooms.edit', $room) }}" class="text-amber-500 hover:text-amber-600 mr-3"><i class="fas fa-edit"></i></a>
                        <form method="POST" action="{{ route('admin.rooms.destroy', $room) }}" class="inline" onsubmit="return confirm('Delete this room?')">@csrf @method('DELETE')
                            <button class="text-red-500 hover:text-red-600"><i class="fas fa-trash"></i></button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="mt-6">{{ $rooms->links() }}</div>
</div>
@endsection
