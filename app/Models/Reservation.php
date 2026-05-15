<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Reservation extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'room_id', 'check_in', 'check_out',
        'guests', 'total_price', 'status', 'special_requests',
    ];

    protected $casts = [
        'check_in' => 'date',
        'check_out' => 'date',
        'total_price' => 'decimal:2',
    ];

    /* ── Relationships ────────────────────────────── */

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    public function payment()
    {
        return $this->hasOne(Payment::class);
    }

    public function review()
    {
        return $this->hasOne(Review::class);
    }

    /* ── Scopes ───────────────────────────────────── */

    public function scopeStatus($query, string $status)
    {
        return $query->where('status', $status);
    }

    public function scopeUpcoming($query)
    {
        return $query->where('check_in', '>=', now()->toDateString())
                     ->whereIn('status', ['pending', 'confirmed']);
    }

    public function scopeActive($query)
    {
        return $query->where('check_in', '<=', now()->toDateString())
                     ->where('check_out', '>=', now()->toDateString())
                     ->where('status', 'confirmed');
    }

    /* ── Computed ─────────────────────────────────── */

    public function getNightsAttribute(): int
    {
        return $this->check_in->diffInDays($this->check_out);
    }

    public function isPaid(): bool
    {
        return $this->payment && $this->payment->status === 'completed';
    }

    public function canBeCancelled(): bool
    {
        return in_array($this->status, ['pending', 'confirmed'])
            && $this->check_in->isFuture();
    }
}
