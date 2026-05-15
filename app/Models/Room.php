<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class Room extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'slug', 'description', 'type', 'price_per_night',
        'capacity', 'beds', 'bathrooms', 'area', 'floor',
        'status', 'is_featured',
    ];

    protected $casts = [
        'price_per_night' => 'decimal:2',
        'is_featured' => 'boolean',
    ];

    protected static function booted(): void
    {
        static::creating(function (Room $room) {
            if (empty($room->slug)) {
                $room->slug = Str::slug($room->name) . '-' . Str::random(4);
            }
        });
    }

    /* ── Relationships ────────────────────────────── */

    public function images()
    {
        return $this->hasMany(RoomImage::class)->orderBy('sort_order');
    }

    public function primaryImage()
    {
        return $this->hasOne(RoomImage::class)->where('is_primary', true);
    }

    public function amenities()
    {
        return $this->belongsToMany(Amenity::class, 'room_amenity');
    }

    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    /* ── Scopes ───────────────────────────────────── */

    public function scopeAvailable($query)
    {
        return $query->where('status', 'available');
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopeOfType($query, string $type)
    {
        return $query->where('type', $type);
    }

    public function scopeMaxPrice($query, float $price)
    {
        return $query->where('price_per_night', '<=', $price);
    }

    public function scopeMinCapacity($query, int $capacity)
    {
        return $query->where('capacity', '>=', $capacity);
    }

    /**
     * Check if room is available between two dates.
     */
    public function isAvailableBetween(string $checkIn, string $checkOut, ?int $excludeReservationId = null): bool
    {
        $query = $this->reservations()
            ->whereIn('status', ['pending', 'confirmed'])
            ->where(function ($q) use ($checkIn, $checkOut) {
                $q->where(function ($q2) use ($checkIn, $checkOut) {
                    $q2->where('check_in', '<', $checkOut)
                        ->where('check_out', '>', $checkIn);
                });
            });

        if ($excludeReservationId) {
            $query->where('id', '!=', $excludeReservationId);
        }

        return $query->doesntExist();
    }

    /* ── Accessors ────────────────────────────────── */

    public function getAverageRatingAttribute(): float
    {
        return round($this->reviews()->where('is_approved', true)->avg('rating') ?? 0, 1);
    }

    public function getReviewCountAttribute(): int
    {
        return $this->reviews()->where('is_approved', true)->count();
    }

    public function getPrimaryImageUrlAttribute(): string
    {
        $img = $this->primaryImage;
        return $img ? asset('storage/' . $img->path) : asset('images/room-placeholder.jpg');
    }
}
