<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\Review;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    /**
     * List rooms with search & filtering.
     */
    public function index(Request $request)
    {
        $query = Room::with(['primaryImage', 'amenities'])
            ->available();

        // Search
        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Filter by type
        if ($type = $request->input('type')) {
            $query->ofType($type);
        }

        // Filter by max price
        if ($maxPrice = $request->input('max_price')) {
            $query->maxPrice((float) $maxPrice);
        }

        // Filter by capacity
        if ($capacity = $request->input('capacity')) {
            $query->minCapacity((int) $capacity);
        }

        // Sort
        $sort = $request->input('sort', 'price_asc');
        match ($sort) {
            'price_desc' => $query->orderByDesc('price_per_night'),
            'name' => $query->orderBy('name'),
            'capacity' => $query->orderByDesc('capacity'),
            default => $query->orderBy('price_per_night'),
        };

        $rooms = $query->paginate(9)->withQueryString();
        $types = Room::select('type')->distinct()->pluck('type');

        return view('rooms.index', compact('rooms', 'types'));
    }

    /**
     * Show room details.
     */
    public function show(Room $room)
    {
        $room->load(['images', 'amenities', 'reviews' => function ($q) {
            $q->where('is_approved', true)->with('user')->latest()->take(10);
        }]);

        $similarRooms = Room::available()
            ->where('id', '!=', $room->id)
            ->where('type', $room->type)
            ->with('primaryImage')
            ->take(3)
            ->get();

        return view('rooms.show', compact('room', 'similarRooms'));
    }
}
