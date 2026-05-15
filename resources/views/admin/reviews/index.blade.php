@extends('layouts.app')
@section('title', 'Reviews')
@section('hide_footer', true)

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <h1 class="text-2xl font-bold mb-6">Manage Reviews</h1>
    <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-200 dark:border-gray-700 overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 dark:bg-gray-700/50">
                <tr><th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Guest</th><th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Room</th><th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Rating</th><th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Comment</th><th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th><th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Action</th></tr>
            </thead>
            <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                @foreach($reviews as $review)
                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/30">
                    <td class="px-6 py-4 font-medium">{{ $review->user->name }}</td>
                    <td class="px-6 py-4">{{ $review->room->name }}</td>
                    <td class="px-6 py-4">
                        <div class="flex gap-0.5">@for($i=1;$i<=5;$i++)<i class="fas fa-star text-xs {{ $i<=$review->rating?'text-amber-400':'text-gray-300' }}"></i>@endfor</div>
                    </td>
                    <td class="px-6 py-4 text-gray-500 max-w-xs truncate">{{ $review->comment }}</td>
                    <td class="px-6 py-4"><span class="px-2 py-1 text-xs rounded-full font-medium {{ $review->is_approved ? 'bg-emerald-100 text-emerald-700 dark:bg-emerald-500/10 dark:text-emerald-400' : 'bg-yellow-100 text-yellow-700 dark:bg-yellow-500/10 dark:text-yellow-400' }}">{{ $review->is_approved ? 'Approved' : 'Pending' }}</span></td>
                    <td class="px-6 py-4 text-right">
                        <form method="POST" action="{{ route('admin.reviews.toggle', $review) }}">@csrf @method('PATCH')
                            <button class="text-xs px-3 py-1.5 rounded-lg {{ $review->is_approved ? 'bg-red-50 text-red-600 hover:bg-red-100' : 'bg-emerald-50 text-emerald-600 hover:bg-emerald-100' }} font-medium transition-colors">{{ $review->is_approved ? 'Reject' : 'Approve' }}</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="mt-6">{{ $reviews->links() }}</div>
</div>
@endsection
