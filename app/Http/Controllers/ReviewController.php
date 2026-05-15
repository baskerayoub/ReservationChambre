<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    /**
     * Store a review for a completed reservation.
     */
    public function store(Request $request, Reservation $reservation)
    {
        if ($reservation->user_id !== Auth::id()) {
            abort(403);
        }

        if ($reservation->status !== 'completed') {
            return back()->with('error', 'You can only review completed stays.');
        }

        if ($reservation->review) {
            return back()->with('error', 'You have already reviewed this stay.');
        }

        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:2000',
        ]);

        Review::create([
            'user_id' => Auth::id(),
            'room_id' => $reservation->room_id,
            'reservation_id' => $reservation->id,
            'rating' => $request->rating,
            'comment' => $request->comment,
            'is_approved' => false,
        ]);

        return back()->with('success', 'Thank you for your review! It will be published after moderation.');
    }
}
