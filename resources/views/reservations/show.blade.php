@extends('layouts.app')
@section('title', 'Reservation #' . $reservation->id)

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <nav class="flex items-center gap-2 text-sm text-gray-400 mb-6">
        <a href="{{ route('reservations.index') }}" class="hover:text-amber-500">My Reservations</a>
        <i class="fas fa-chevron-right text-xs"></i>
        <span class="text-gray-700 dark:text-gray-300">#{{ $reservation->id }}</span>
    </nav>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <div class="lg:col-span-2 space-y-6">
            @php
                $sc = ['pending'=>['bg-yellow-50 dark:bg-yellow-500/10 border-yellow-200 dark:border-yellow-500/20','text-yellow-700 dark:text-yellow-400','clock'],'confirmed'=>['bg-emerald-50 dark:bg-emerald-500/10 border-emerald-200 dark:border-emerald-500/20','text-emerald-700 dark:text-emerald-400','check-circle'],'cancelled'=>['bg-red-50 dark:bg-red-500/10 border-red-200 dark:border-red-500/20','text-red-700 dark:text-red-400','times-circle'],'completed'=>['bg-blue-50 dark:bg-blue-500/10 border-blue-200 dark:border-blue-500/20','text-blue-700 dark:text-blue-400','flag-checkered']];
                $s = $sc[$reservation->status];
            @endphp
            <div class="p-4 rounded-xl border {{ $s[0] }} {{ $s[1] }} flex items-center gap-3">
                <i class="fas fa-{{ $s[2] }} text-xl"></i>
                <div><p class="font-semibold">Status: {{ ucfirst($reservation->status) }}</p></div>
            </div>

            <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-200 dark:border-gray-700 p-6">
                <h2 class="text-xl font-bold">{{ $reservation->room->name }}</h2>
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 mt-6">
                    @foreach([['calendar-check','Check-in',$reservation->check_in->format('M d, Y')],['calendar-minus','Check-out',$reservation->check_out->format('M d, Y')],['moon','Nights',$reservation->nights],['users','Guests',$reservation->guests]] as $item)
                    <div class="bg-gray-50 dark:bg-gray-700/50 rounded-xl p-3 text-center">
                        <i class="fas fa-{{ $item[0] }} text-amber-500 mb-1"></i>
                        <p class="text-xs text-gray-400">{{ $item[1] }}</p>
                        <p class="text-sm font-semibold">{{ $item[2] }}</p>
                    </div>
                    @endforeach
                </div>
                @if($reservation->special_requests)
                <div class="mt-4 p-3 bg-amber-50 dark:bg-amber-500/5 rounded-xl">
                    <p class="text-xs font-medium text-amber-700 dark:text-amber-400"><i class="fas fa-comment-dots mr-1"></i> Special Requests</p>
                    <p class="text-sm text-gray-600 dark:text-gray-300">{{ $reservation->special_requests }}</p>
                </div>
                @endif
            </div>

            @if($reservation->status === 'completed' && !$reservation->review)
            <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-200 dark:border-gray-700 p-6">
                <h3 class="text-lg font-semibold mb-4"><i class="fas fa-star text-amber-400 mr-2"></i>Leave a Review</h3>
                <form method="POST" action="{{ route('reviews.store', $reservation) }}">
                    @csrf
                    <div class="mb-4" x-data="{ rating: 5 }">
                        <div class="flex gap-1">
                            @for($i = 1; $i <= 5; $i++)
                            <button type="button" @click="rating = {{ $i }}" class="text-2xl focus:outline-none">
                                <i :class="rating >= {{ $i }} ? 'fas fa-star text-amber-400' : 'far fa-star text-gray-300'"></i>
                            </button>
                            @endfor
                        </div>
                        <input type="hidden" name="rating" :value="rating" />
                    </div>
                    <textarea name="comment" rows="3" placeholder="Your experience..." class="w-full mb-3 rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring-amber-500"></textarea>
                    <button type="submit" class="px-6 py-2.5 bg-gradient-to-r from-amber-500 to-orange-500 text-white font-semibold rounded-xl">Submit</button>
                </form>
            </div>
            @endif
        </div>

        <div class="space-y-6">
            <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-200 dark:border-gray-700 p-6">
                <h3 class="font-semibold mb-4">Price Summary</h3>
                <div class="text-sm space-y-2">
                    <div class="flex justify-between"><span class="text-gray-500">${{ number_format($reservation->room->price_per_night,2) }} × {{ $reservation->nights }} nights</span><span>${{ number_format($reservation->total_price,2) }}</span></div>
                    <div class="border-t pt-2 flex justify-between"><span class="font-bold">Total</span><span class="text-xl font-bold text-amber-600 dark:text-amber-400">${{ number_format($reservation->total_price,2) }}</span></div>
                </div>
                @if($reservation->payment)
                <div class="mt-4 p-3 rounded-lg {{ $reservation->payment->status === 'completed' ? 'bg-emerald-50 dark:bg-emerald-500/10 text-emerald-700 dark:text-emerald-400' : 'bg-yellow-50 dark:bg-yellow-500/10 text-yellow-700 dark:text-yellow-400' }}">
                    <p class="text-sm font-medium"><i class="fas fa-{{ $reservation->payment->status === 'completed' ? 'check-circle' : 'clock' }} mr-1"></i> {{ ucfirst($reservation->payment->status) }} via {{ ucfirst($reservation->payment->method) }}</p>
                </div>
                @endif
            </div>

            @if($reservation->status === 'pending' && !$reservation->isPaid())
            <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-200 dark:border-gray-700 p-6 space-y-3">
                <h3 class="font-semibold mb-2">Pay Now</h3>
                <form method="POST" action="{{ route('payment.stripe', $reservation) }}">@csrf
                    <button class="w-full py-3 bg-[#635bff] text-white font-semibold rounded-xl hover:bg-[#5046e5] transition-colors"><i class="fab fa-stripe mr-2"></i>Stripe</button>
                </form>
                <form method="POST" action="{{ route('payment.paypal', $reservation) }}">@csrf
                    <button class="w-full py-3 bg-[#0070ba] text-white font-semibold rounded-xl hover:bg-[#005a99] transition-colors"><i class="fab fa-paypal mr-2"></i>PayPal</button>
                </form>
            </div>
            @endif

            @if($reservation->canBeCancelled())
            <div class="space-y-3">
                <a href="{{ route('reservations.edit', $reservation) }}" class="block w-full py-2.5 text-center text-sm font-medium border border-gray-300 dark:border-gray-600 rounded-xl hover:bg-gray-50 dark:hover:bg-gray-700"><i class="fas fa-edit mr-1"></i> Modify</a>
                <form method="POST" action="{{ route('reservations.destroy', $reservation) }}" onsubmit="return confirm('Cancel this reservation?')">@csrf @method('DELETE')
                    <button class="w-full py-2.5 text-sm font-medium text-red-600 border border-red-300 rounded-xl hover:bg-red-50 dark:hover:bg-red-500/10"><i class="fas fa-times mr-1"></i> Cancel</button>
                </form>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
