<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreReservationRequest;
use App\Http\Requests\UpdateReservationRequest;
use App\Models\Chambre;
use App\Models\Reservation;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class ReservationController extends Controller
{
    public function index(Request $request): View
    {
        $isAdminView = $this->isAdminRoute($request);

        $reservations = Reservation::query()
            ->with(['user', 'chambre', 'payment'])
            ->when(! $isAdminView, fn ($query) => $query->where('user_id', $request->user()->id))
            ->latest('id')
            ->paginate(12);

        return view('reservations.index', [
            'reservations' => $reservations,
            'isAdminView' => $isAdminView,
        ]);
    }

    public function create(Request $request): View
    {
        $selectedChambre = null;

        if ($request->filled('chambre_id')) {
            $selectedChambre = Chambre::findOrFail($request->integer('chambre_id'));
        }

        $start = $request->query('date_debut');
        $end = $request->query('date_fin');

        return view('reservations.create', [
            'reservation' => new Reservation([
                'chambre_id' => $selectedChambre?->id,
                'date_debut' => $start,
                'date_fin' => $end,
                'nombre_personnes' => 1,
            ]),
            'chambres' => Chambre::query()->where('status', 'disponible')->orderBy('numero')->get(),
            'selectedChambre' => $selectedChambre,
        ]);
    }

    public function store(StoreReservationRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $chambre = Chambre::findOrFail($data['chambre_id']);

        $this->ensureRoomCanBeBooked($chambre, $data['date_debut'], $data['date_fin']);

        $reservation = DB::transaction(function () use ($request, $data, $chambre): Reservation {
            return Reservation::create([
                'user_id' => $request->user()->id,
                'chambre_id' => $chambre->id,
                'date_debut' => $data['date_debut'],
                'date_fin' => $data['date_fin'],
                'nombre_personnes' => $data['nombre_personnes'],
                'status' => 'pending',
                'prix_total' => $this->calculateTotalPrice($chambre, $data['date_debut'], $data['date_fin']),
            ]);
        });

        return redirect()
            ->route('reservations.show', $reservation)
            ->with('success', 'Reservation creee. Vous pouvez maintenant choisir Stripe, PayPal ou paiement sur place.');
    }

    public function show(Request $request, Reservation $reservation): View
    {
        $this->authorizeReservationAccess($request, $reservation);

        return view('reservations.show', [
            'reservation' => $reservation->load(['user', 'chambre', 'payment']),
            'isAdminView' => $this->isAdminRoute($request),
        ]);
    }

    public function edit(Request $request, Reservation $reservation): View
    {
        $this->authorizeReservationAccess($request, $reservation);

        return view('reservations.edit', [
            'reservation' => $reservation->load('chambre'),
            'chambres' => Chambre::query()->orderBy('numero')->get(),
            'statuses' => Reservation::STATUSES,
            'isAdminView' => $this->isAdminRoute($request),
        ]);
    }

    public function update(UpdateReservationRequest $request, Reservation $reservation): RedirectResponse
    {
        $this->authorizeReservationAccess($request, $reservation);

        if ($reservation->status === 'cancelled' && ! $this->isAdminRoute($request)) {
            throw ValidationException::withMessages([
                'reservation' => 'Une reservation annulee ne peut pas etre modifiee.',
            ]);
        }

        $data = $request->validated();
        $chambre = Chambre::findOrFail($data['chambre_id']);

        $this->ensureRoomCanBeBooked($chambre, $data['date_debut'], $data['date_fin'], $reservation->id);

        DB::transaction(function () use ($request, $reservation, $data, $chambre): void {
            $reservation->update([
                'chambre_id' => $chambre->id,
                'date_debut' => $data['date_debut'],
                'date_fin' => $data['date_fin'],
                'nombre_personnes' => $data['nombre_personnes'],
                'status' => $this->isAdminRoute($request) ? ($data['status'] ?? $reservation->status) : $reservation->status,
                'prix_total' => $this->calculateTotalPrice($chambre, $data['date_debut'], $data['date_fin']),
            ]);

            if ($reservation->payment && $reservation->payment->status !== 'paid') {
                $reservation->payment->update(['montant' => $reservation->prix_total]);
            }
        });

        return redirect()
            ->route($this->isAdminRoute($request) ? 'admin.reservations.show' : 'reservations.show', $reservation)
            ->with('success', 'Reservation modifiee avec succes.');
    }

    public function destroy(Request $request, Reservation $reservation): RedirectResponse
    {
        $this->authorizeReservationAccess($request, $reservation);

        $reservation->update(['status' => 'cancelled']);

        return redirect()
            ->route($this->isAdminRoute($request) ? 'admin.reservations.index' : 'reservations.index')
            ->with('success', 'Reservation annulee avec succes.');
    }

    private function calculateTotalPrice(Chambre $chambre, string $start, string $end): float
    {
        $nights = max(1, Carbon::parse($start)->diffInDays(Carbon::parse($end)));

        return (float) $chambre->prix * $nights;
    }

    private function ensureRoomCanBeBooked(Chambre $chambre, string $start, string $end, ?int $ignoreReservationId = null): void
    {
        if ($chambre->status !== 'disponible') {
            throw ValidationException::withMessages([
                'chambre_id' => 'Cette chambre est actuellement indisponible.',
            ]);
        }

        if (Reservation::conflictsForRoom($chambre->id, $start, $end, $ignoreReservationId)) {
            throw ValidationException::withMessages([
                'date_debut' => 'Cette chambre est deja reservee pour ces dates.',
            ]);
        }
    }

    private function authorizeReservationAccess(Request $request, Reservation $reservation): void
    {
        abort_unless(
            $request->user()?->isAdmin() || $reservation->user_id === $request->user()?->id,
            403
        );
    }

    private function isAdminRoute(Request $request): bool
    {
        return str_starts_with((string) $request->route()?->getName(), 'admin.');
    }
}
