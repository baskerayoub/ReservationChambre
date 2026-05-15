<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $fillable = [
        'user_id', 'room_id', 'reservation_id', 'rating', 'comment', 'is_approved',
    ];

    protected $casts = [
        'is_approved' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    public function reservation()
    {
        return $this->belongsTo(Reservation::class);
    }
}
