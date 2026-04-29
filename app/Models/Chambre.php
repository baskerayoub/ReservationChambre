<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Chambre extends Model
{
    public const TYPES = ['Single', 'Double', 'Family', 'Suite'];

    public const CONFORTS = ['Standard', 'Deluxe', 'Luxury'];

    public const EQUIPEMENTS = [
        'WiFi',
        'TV',
        'Smart TV',
        'Air Conditioning',
        'Private Bathroom',
        'Balcony',
        'Mini Bar',
        'Living Area',
        'Desk',
        'Parking',
        'Breakfast',
    ];

    public const STATUSES = ['disponible', 'occupee', 'maintenance'];

    public const STATUS_LABELS = [
        'disponible' => 'Available',
        'occupee' => 'Occupied',
        'maintenance' => 'Maintenance',
    ];

    protected $fillable = [
        'numero',
        'type',
        'prix',
        'confort',
        'equipements',
        'description',
        'image',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'equipements' => 'array',
            'prix' => 'decimal:2',
        ];
    }

    public function reservations(): HasMany
    {
        return $this->hasMany(Reservation::class);
    }

    public function scopeAvailableBetween(Builder $query, ?string $start, ?string $end, ?int $ignoreReservationId = null): Builder
    {
        if (! $start || ! $end) {
            return $query;
        }

        return $query
            ->where('status', 'disponible')
            ->whereDoesntHave('reservations', function (Builder $reservationQuery) use ($start, $end, $ignoreReservationId): void {
                $reservationQuery
                    ->whereIn('status', ['pending', 'confirmed'])
                    ->when($ignoreReservationId, fn (Builder $query) => $query->whereKeyNot($ignoreReservationId))
                    ->whereDate('date_debut', '<', $end)
                    ->whereDate('date_fin', '>', $start);
            });
    }

    public function scopeFilter(Builder $query, array $filters): Builder
    {
        return $query
            ->when($filters['type'] ?? null, fn (Builder $query, string $type) => $query->where('type', $type))
            ->when($filters['confort'] ?? null, fn (Builder $query, string $confort) => $query->where('confort', $confort))
            ->when($filters['prix_min'] ?? null, fn (Builder $query, string $price) => $query->where('prix', '>=', $price))
            ->when($filters['prix_max'] ?? null, fn (Builder $query, string $price) => $query->where('prix', '<=', $price))
            ->when($filters['equipements'] ?? null, function (Builder $query, array $equipements): void {
                foreach ($equipements as $equipement) {
                    $query->whereJsonContains('equipements', $equipement);
                }
            })
            ->availableBetween($filters['date_debut'] ?? null, $filters['date_fin'] ?? null);
    }

    public function getEquipementsListAttribute(): array
    {
        return is_array($this->equipements) ? $this->equipements : [];
    }

    public function statusLabel(): string
    {
        return self::STATUS_LABELS[$this->status] ?? ucfirst($this->status);
    }
}
