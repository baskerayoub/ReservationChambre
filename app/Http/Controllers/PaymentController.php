<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Services\StripeService;
use App\Services\PayPalService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    /**
     * Initiate Stripe payment.
     */
    public function stripeCheckout(Reservation $reservation, StripeService $stripe)
    {
        $this->authorize($reservation);

        $url = $stripe->createCheckoutSession($reservation);

        if (! $url) {
            return back()->with('error', 'Unable to initiate payment. Please try again.');
        }

        return redirect()->away($url);
    }

    /**
     * Stripe success callback.
     */
    public function stripeSuccess(Request $request, Reservation $reservation, StripeService $stripe)
    {
        $sessionId = $request->query('session_id');

        if ($sessionId && $stripe->verifyPayment($sessionId)) {
            return redirect()
                ->route('reservations.show', $reservation)
                ->with('success', 'Payment successful! Your reservation is confirmed.');
        }

        return redirect()
            ->route('reservations.show', $reservation)
            ->with('error', 'Payment verification failed. Please contact support.');
    }

    /**
     * Initiate PayPal payment.
     */
    public function paypalCheckout(Reservation $reservation, PayPalService $paypal)
    {
        $this->authorize($reservation);

        $url = $paypal->createOrder($reservation);

        if (! $url) {
            return back()->with('error', 'Unable to initiate PayPal payment. Please try again.');
        }

        return redirect()->away($url);
    }

    /**
     * PayPal success callback.
     */
    public function paypalSuccess(Request $request, Reservation $reservation, PayPalService $paypal)
    {
        $orderId = $request->query('token');

        if ($orderId && $paypal->capturePayment($orderId)) {
            return redirect()
                ->route('reservations.show', $reservation)
                ->with('success', 'PayPal payment successful! Your reservation is confirmed.');
        }

        return redirect()
            ->route('reservations.show', $reservation)
            ->with('error', 'PayPal payment verification failed.');
    }

    /**
     * Payment cancelled.
     */
    public function cancel(Reservation $reservation)
    {
        return redirect()
            ->route('reservations.show', $reservation)
            ->with('info', 'Payment was cancelled.');
    }

    /**
     * Authorization check.
     */
    private function authorize(Reservation $reservation): void
    {
        if ($reservation->user_id !== Auth::id() && ! Auth::user()->isStaff()) {
            abort(403);
        }

        if ($reservation->isPaid()) {
            abort(400, 'This reservation is already paid.');
        }
    }
}
