<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Reservation;
use App\Models\Room;
use App\Models\RoomImage;
use App\Models\User;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    /**
     * Dashboard with analytics.
     */
    public function dashboard()
    {
        $stats = [
            'total_rooms' => Room::count(),
            'available_rooms' => Room::available()->count(),
            'total_reservations' => Reservation::count(),
            'pending_reservations' => Reservation::status('pending')->count(),
            'active_reservations' => Reservation::active()->count(),
            'total_revenue' => Payment::where('status', 'completed')->sum('amount'),
            'monthly_revenue' => Payment::where('status', 'completed')
                ->whereMonth('created_at', now()->month)
                ->whereYear('created_at', now()->year)
                ->sum('amount'),
            'total_users' => User::where('role', 'client')->count(),
            'occupancy_rate' => $this->calculateOccupancy(),
        ];

        $recentReservations = Reservation::with(['user', 'room'])
            ->latest()
            ->take(5)
            ->get();

        // Monthly revenue chart data (last 6 months)
        $revenueChart = collect(range(5, 0))->map(function ($i) {
            $date = now()->subMonths($i);
            return [
                'month' => $date->format('M Y'),
                'revenue' => Payment::where('status', 'completed')
                    ->whereMonth('created_at', $date->month)
                    ->whereYear('created_at', $date->year)
                    ->sum('amount'),
            ];
        });

        return view('admin.dashboard', compact('stats', 'recentReservations', 'revenueChart'));
    }

    /**
     * Manage rooms.
     */
    public function rooms()
    {
        $rooms = Room::with('primaryImage')
            ->withCount('reservations')
            ->latest()
            ->paginate(10);

        return view('admin.rooms.index', compact('rooms'));
    }

    /**
     * Create room form.
     */
    public function createRoom()
    {
        $amenities = \App\Models\Amenity::all();
        return view('admin.rooms.create', compact('amenities'));
    }

    /**
     * Store a new room.
     */
    public function storeRoom(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'type' => 'required|in:single,double,suite,deluxe,family',
            'price_per_night' => 'required|numeric|min:0',
            'capacity' => 'required|integer|min:1|max:10',
            'beds' => 'required|integer|min:1',
            'bathrooms' => 'required|integer|min:1',
            'area' => 'nullable|integer|min:1',
            'floor' => 'nullable|integer',
            'status' => 'required|in:available,maintenance,occupied',
            'is_featured' => 'boolean',
            'amenities' => 'nullable|array',
            'amenities.*' => 'exists:amenities,id',
            'images' => 'nullable|array|max:10',
            'images.*' => 'image|max:5120',
        ]);

        $room = Room::create($request->except(['amenities', 'images']));

        if ($request->has('amenities')) {
            $room->amenities()->sync($request->amenities);
        }

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $i => $image) {
                $path = $image->store('rooms', 'public');
                RoomImage::create([
                    'room_id' => $room->id,
                    'path' => $path,
                    'is_primary' => $i === 0,
                    'sort_order' => $i,
                ]);
            }
        }

        return redirect()
            ->route('admin.rooms')
            ->with('success', 'Room created successfully.');
    }

    /**
     * Edit room form.
     */
    public function editRoom(Room $room)
    {
        $room->load(['images', 'amenities']);
        $amenities = \App\Models\Amenity::all();
        return view('admin.rooms.edit', compact('room', 'amenities'));
    }

    /**
     * Update room.
     */
    public function updateRoom(Request $request, Room $room)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'type' => 'required|in:single,double,suite,deluxe,family',
            'price_per_night' => 'required|numeric|min:0',
            'capacity' => 'required|integer|min:1|max:10',
            'beds' => 'required|integer|min:1',
            'bathrooms' => 'required|integer|min:1',
            'area' => 'nullable|integer|min:1',
            'floor' => 'nullable|integer',
            'status' => 'required|in:available,maintenance,occupied',
            'is_featured' => 'boolean',
            'amenities' => 'nullable|array',
            'images' => 'nullable|array|max:10',
            'images.*' => 'image|max:5120',
        ]);

        $room->update($request->except(['amenities', 'images']));
        $room->amenities()->sync($request->input('amenities', []));

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $i => $image) {
                $path = $image->store('rooms', 'public');
                RoomImage::create([
                    'room_id' => $room->id,
                    'path' => $path,
                    'sort_order' => $room->images()->count() + $i,
                ]);
            }
        }

        return redirect()
            ->route('admin.rooms')
            ->with('success', 'Room updated successfully.');
    }

    /**
     * Delete room.
     */
    public function destroyRoom(Room $room)
    {
        // Delete associated images from storage
        foreach ($room->images as $image) {
            Storage::disk('public')->delete($image->path);
        }

        $room->delete();

        return redirect()
            ->route('admin.rooms')
            ->with('success', 'Room deleted successfully.');
    }

    /**
     * Manage reservations.
     */
    public function reservations(Request $request)
    {
        $query = Reservation::with(['user', 'room', 'payment'])->latest();

        if ($status = $request->input('status')) {
            $query->status($status);
        }

        $reservations = $query->paginate(15);
        return view('admin.reservations.index', compact('reservations'));
    }

    /**
     * Update reservation status.
     */
    public function updateReservationStatus(Request $request, Reservation $reservation)
    {
        $request->validate([
            'status' => 'required|in:pending,confirmed,cancelled,completed',
        ]);

        $reservation->update(['status' => $request->status]);

        return back()->with('success', 'Reservation status updated.');
    }

    /**
     * Manage users.
     */
    public function users(Request $request)
    {
        $query = User::withCount('reservations')->latest();

        if ($role = $request->input('role')) {
            $query->where('role', $role);
        }

        $users = $query->paginate(15);
        return view('admin.users.index', compact('users'));
    }

    /**
     * Update user role.
     */
    public function updateUserRole(Request $request, User $user)
    {
        $request->validate([
            'role' => 'required|in:admin,receptionist,client',
        ]);

        $user->update(['role' => $request->role]);
        return back()->with('success', 'User role updated.');
    }

    /**
     * Manage payments.
     */
    public function payments()
    {
        $payments = Payment::with(['user', 'reservation.room'])
            ->latest()
            ->paginate(15);

        return view('admin.payments.index', compact('payments'));
    }

    /**
     * Manage reviews.
     */
    public function reviews()
    {
        $reviews = Review::with(['user', 'room'])
            ->latest()
            ->paginate(15);

        return view('admin.reviews.index', compact('reviews'));
    }

    /**
     * Toggle review approval.
     */
    public function toggleReviewApproval(Review $review)
    {
        $review->update(['is_approved' => ! $review->is_approved]);
        return back()->with('success', 'Review status updated.');
    }

    /**
     * Calculate today's occupancy rate.
     */
    private function calculateOccupancy(): float
    {
        $totalRooms = Room::count();
        if ($totalRooms === 0) return 0;

        $occupied = Reservation::where('status', 'confirmed')
            ->where('check_in', '<=', now()->toDateString())
            ->where('check_out', '>=', now()->toDateString())
            ->count();

        return round(($occupied / $totalRooms) * 100, 1);
    }
}
