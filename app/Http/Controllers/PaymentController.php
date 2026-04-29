<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Reservation;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class PaymentController extends Controller
{
    public function store(Request $request, Reservation $reservation): RedirectResponse
    {
        abort_unless(
            $request->user()?->isAdmin() || $reservation->user_id === $request->user()?->id,
            403
        );

        if (! $reservation->canBePaid()) {
            throw ValidationException::withMessages([
                'payment' => 'Cette reservation ne peut pas etre payee.',
            ]);
        }

        $data = $request->validate([
            'method' => ['required', Rule::in(Payment::METHODS)],
        ]);

        $reservation->payment()->updateOrCreate(
            ['reservation_id' => $reservation->id],
            [
                'montant' => $reservation->prix_total,
                'method' => $data['method'],
                'status' => 'paid',
                'transaction_id' => Str::upper($data['method']).'-SIM-'.Str::upper(Str::random(10)),
            ]
        );

        $reservation->update(['status' => 'confirmed']);

        return redirect()
            ->route($request->user()->isAdmin() ? 'admin.reservations.show' : 'reservations.show', $reservation)
            ->with('success', 'Paiement simule avec succes. La reservation est confirmee.');
    }
}
