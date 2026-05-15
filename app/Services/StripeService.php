<?php

namespace App\Services;

use App\Models\Payment;
use App\Models\Reservation;
use Illuminate\Support\Facades\Log;
use Stripe\Stripe;
use Stripe\Checkout\Session as StripeSession;

class StripeService
{
    public function __construct()
    {
        Stripe::setApiKey(config('services.stripe.secret'));
    }

    /**
     * Create a Stripe Checkout session for a reservation.
     */
    public function createCheckoutSession(Reservation $reservation): ?string
    {
        try {
            $session = StripeSession::create([
                'payment_method_types' => ['card'],
                'line_items' => [[
                    'price_data' => [
                        'currency' => 'usd',
                        'product_data' => [
                            'name' => "Reservation #{$reservation->id} — {$reservation->room->name}",
                            'description' => sprintf(
                                '%s to %s (%d nights)',
                                $reservation->check_in->format('M d, Y'),
                                $reservation->check_out->format('M d, Y'),
                                $reservation->nights
                            ),
                        ],
                        'unit_amount' => (int) ($reservation->total_price * 100),
                    ],
                    'quantity' => 1,
                ]],
                'mode' => 'payment',
                'success_url' => route('payment.success', ['reservation' => $reservation->id]) . '?session_id={CHECKOUT_SESSION_ID}',
                'cancel_url' => route('payment.cancel', ['reservation' => $reservation->id]),
                'metadata' => [
                    'reservation_id' => $reservation->id,
                    'user_id' => $reservation->user_id,
                ],
            ]);

            // Create a pending payment record
            Payment::create([
                'reservation_id' => $reservation->id,
                'user_id' => $reservation->user_id,
                'amount' => $reservation->total_price,
                'method' => 'stripe',
                'status' => 'pending',
                'transaction_id' => $session->id,
            ]);

            return $session->url;
        } catch (\Exception $e) {
            Log::error('Stripe checkout error', ['error' => $e->getMessage()]);
            return null;
        }
    }

    /**
     * Verify and complete a Stripe payment.
     */
    public function verifyPayment(string $sessionId): bool
    {
        try {
            $session = StripeSession::retrieve($sessionId);

            if ($session->payment_status === 'paid') {
                $payment = Payment::where('transaction_id', $sessionId)->first();
                if ($payment) {
                    $payment->update(['status' => 'completed']);
                    $payment->reservation->update(['status' => 'confirmed']);
                    return true;
                }
            }
            return false;
        } catch (\Exception $e) {
            Log::error('Stripe verify error', ['error' => $e->getMessage()]);
            return false;
        }
    }
}
