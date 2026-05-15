<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreReservationRequest;
use App\Models\Reservation;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReservationController extends Controller
{
    /**
     * Show user's reservations.
     */
    public function index()
    {
        $reservations = Auth::user()
            ->reservations()
            ->with(['room.primaryImage', 'payment'])
            ->latest()
            ->paginate(10);

        return view('reservations.index', compact('reservations'));
    }

    /**
     * Show booking form for a room.
     */
    public function create(Request $request)
    {
        $room = Room::findOrFail($request->query('room_id'));
        return view('reservations.create', compact('room'));
    }

    /**
     * Store a new reservation.
     */
    public function store(StoreReservationRequest $request)
    {
        $room = Room::findOrFail($request->room_id);

        // Validate capacity
        if ($request->guests > $room->capacity) {
            return back()->withErrors(['guests' => "This room has a maximum capacity of {$room->capacity} guests."]);
        }

        // Check availability (prevent double booking)
        if (! $room->isAvailableBetween($request->check_in, $request->check_out)) {
            return back()->withErrors(['check_in' => 'This room is not available for the selected dates.']);
        }

        $checkIn = \Carbon\Carbon::parse($request->check_in);
        $checkOut = \Carbon\Carbon::parse($request->check_out);
        $nights = $checkIn->diffInDays($checkOut);
        $totalPrice = $nights * $room->price_per_night;

        $reservation = Reservation::create([
            'user_id' => Auth::id(),
            'room_id' => $room->id,
            'check_in' => $request->check_in,
            'check_out' => $request->check_out,
            'guests' => $request->guests,
            'total_price' => $totalPrice,
            'special_requests' => $request->special_requests,
            'status' => 'pending',
        ]);

        return redirect()
            ->route('reservations.show', $reservation)
            ->with('success', 'Reservation created successfully! Please proceed to payment.');
    }

    /**
     * Show reservation details.
     */
    public function show(Reservation $reservation)
    {
        $this->authorizeAccess($reservation);
        $reservation->load(['room.images', 'room.amenities', 'payment', 'review']);

        return view('reservations.show', compact('reservation'));
    }

    /**
     * Show edit form.
     */
    public function edit(Reservation $reservation)
    {
        $this->authorizeAccess($reservation);

        if (! $reservation->canBeCancelled()) {
            return back()->with('error', 'This reservation cannot be modified.');
        }

        return view('reservations.edit', compact('reservation'));
    }

    /**
     * Update reservation.
     */
    public function update(Request $request, Reservation $reservation)
    {
        $this->authorizeAccess($reservation);

        if (! $reservation->canBeCancelled()) {
            return back()->with('error', 'This reservation cannot be modified.');
        }

        $request->validate([
            'check_in' => 'required|date|after_or_equal:today',
            'check_out' => 'required|date|after:check_in',
            'guests' => 'required|integer|min:1|max:' . $reservation->room->capacity,
            'special_requests' => 'nullable|string|max:1000',
        ]);

        $room = $reservation->room;

        if (! $room->isAvailableBetween($request->check_in, $request->check_out, $reservation->id)) {
            return back()->withErrors(['check_in' => 'The room is not available for these dates.']);
        }

        $checkIn = \Carbon\Carbon::parse($request->check_in);
        $checkOut = \Carbon\Carbon::parse($request->check_out);
        $nights = $checkIn->diffInDays($checkOut);

        $reservation->update([
            'check_in' => $request->check_in,
            'check_out' => $request->check_out,
            'guests' => $request->guests,
            'total_price' => $nights * $room->price_per_night,
            'special_requests' => $request->special_requests,
        ]);

        return redirect()
            ->route('reservations.show', $reservation)
            ->with('success', 'Reservation updated successfully.');
    }

    /**
     * Cancel reservation.
     */
    public function destroy(Reservation $reservation)
    {
        $this->authorizeAccess($reservation);

        if (! $reservation->canBeCancelled()) {
            return back()->with('error', 'This reservation cannot be cancelled.');
        }

        $reservation->update(['status' => 'cancelled']);

        return redirect()
            ->route('reservations.index')
            ->with('success', 'Reservation cancelled successfully.');
    }

    /**
     * Ensure user can access this reservation.
     */
    private function authorizeAccess(Reservation $reservation): void
    {
        if (! Auth::user()->isStaff() && $reservation->user_id !== Auth::id()) {
            abort(403);
        }
    }
}
