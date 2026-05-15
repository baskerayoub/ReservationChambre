<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\Review;

class HomeController extends Controller
{
    /**
     * Landing page.
     */
    public function index()
    {
        $featuredRooms = Room::featured()
            ->available()
            ->with(['primaryImage', 'amenities'])
            ->take(6)
            ->get();

        $latestReviews = Review::where('is_approved', true)
            ->with(['user', 'room'])
            ->latest()
            ->take(6)
            ->get();

        $stats = [
            'rooms' => Room::count(),
            'happy_guests' => \App\Models\Reservation::where('status', 'completed')->count(),
            'avg_rating' => round(Review::where('is_approved', true)->avg('rating') ?? 4.8, 1),
        ];

        return view('welcome', compact('featuredRooms', 'latestReviews', 'stats'));
    }
}
