<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Payment extends Model
{
    public const METHODS = ['stripe', 'paypal', 'cash'];

    public const METHOD_LABELS = [
        'stripe' => 'Stripe',
        'paypal' => 'PayPal',
        'cash' => 'On-site Payment',
    ];

    public const STATUSES = ['pending', 'paid'];

    protected $fillable = [
        'reservation_id',
        'montant',
        'method',
        'status',
        'transaction_id',
    ];

    protected function casts(): array
    {
        return [
            'montant' => 'decimal:2',
        ];
    }

    public function reservation(): BelongsTo
    {
        return $this->belongsTo(Reservation::class);
    }
}
