<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Reservation extends Model
{
    public const STATUSES = ['pending', 'confirmed', 'cancelled'];

    public const STATUS_LABELS = [
        'pending' => 'Pending',
        'confirmed' => 'Confirmed',
        'cancelled' => 'Cancelled',
    ];

    protected $fillable = [
        'user_id',
        'chambre_id',
        'date_debut',
        'date_fin',
        'nombre_personnes',
        'status',
        'prix_total',
    ];

    protected function casts(): array
    {
        return [
            'date_debut' => 'date',
            'date_fin' => 'date',
            'prix_total' => 'decimal:2',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function chambre(): BelongsTo
    {
        return $this->belongsTo(Chambre::class);
    }

    public function payment(): HasOne
    {
        return $this->hasOne(Payment::class);
    }

    public static function conflictsForRoom(int $chambreId, string $start, string $end, ?int $ignoreReservationId = null): bool
    {
        return static::query()
            ->where('chambre_id', $chambreId)
            ->whereIn('status', ['pending', 'confirmed'])
            ->when($ignoreReservationId, fn (Builder $query) => $query->whereKeyNot($ignoreReservationId))
            ->whereDate('date_debut', '<', $end)
            ->whereDate('date_fin', '>', $start)
            ->exists();
    }

    public function nights(): int
    {
        return max(1, (int) $this->date_debut->diffInDays($this->date_fin));
    }

    public function canBePaid(): bool
    {
        return $this->status !== 'cancelled' && ($this->payment?->status ?? 'pending') !== 'paid';
    }

    public function canBeChangedByClient(): bool
    {
        return $this->status !== 'cancelled' && $this->date_debut->isFuture();
    }

    public function statusLabel(): string
    {
        return self::STATUS_LABELS[$this->status] ?? ucfirst($this->status);
    }
}
