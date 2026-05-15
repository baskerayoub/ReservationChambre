<?php

namespace App\Services;

use App\Models\Payment;
use App\Models\Reservation;
use Illuminate\Support\Facades\Log;
use Srmklive\PayPal\Services\PayPal as PayPalClient;

class PayPalService
{
    private PayPalClient $provider;

    public function __construct()
    {
        $this->provider = new PayPalClient;
        $this->provider->setApiCredentials(config('paypal'));
        $this->provider->getAccessToken();
    }

    /**
     * Create a PayPal order for a reservation.
     */
    public function createOrder(Reservation $reservation): ?string
    {
        try {
            $order = $this->provider->createOrder([
                'intent' => 'CAPTURE',
                'purchase_units' => [[
                    'reference_id' => 'reservation_' . $reservation->id,
                    'description' => "Reservation #{$reservation->id} — {$reservation->room->name}",
                    'amount' => [
                        'currency_code' => 'USD',
                        'value' => number_format($reservation->total_price, 2, '.', ''),
                    ],
                ]],
                'application_context' => [
                    'return_url' => route('payment.paypal.success', ['reservation' => $reservation->id]),
                    'cancel_url' => route('payment.cancel', ['reservation' => $reservation->id]),
                    'brand_name' => 'Hotelia',
                ],
            ]);

            if (isset($order['id'])) {
                Payment::create([
                    'reservation_id' => $reservation->id,
                    'user_id' => $reservation->user_id,
                    'amount' => $reservation->total_price,
                    'method' => 'paypal',
                    'status' => 'pending',
                    'transaction_id' => $order['id'],
                ]);

                $approvalLink = collect($order['links'])->firstWhere('rel', 'approve');
                return $approvalLink['href'] ?? null;
            }

            return null;
        } catch (\Exception $e) {
            Log::error('PayPal create order error', ['error' => $e->getMessage()]);
            return null;
        }
    }

    /**
     * Capture a PayPal payment after user approval.
     */
    public function capturePayment(string $orderId): bool
    {
        try {
            $result = $this->provider->capturePaymentOrder($orderId);

            if (isset($result['status']) && $result['status'] === 'COMPLETED') {
                $payment = Payment::where('transaction_id', $orderId)->first();
                if ($payment) {
                    $payment->update(['status' => 'completed']);
                    $payment->reservation->update(['status' => 'confirmed']);
                    return true;
                }
            }
            return false;
        } catch (\Exception $e) {
            Log::error('PayPal capture error', ['error' => $e->getMessage()]);
            return false;
        }
    }
}
