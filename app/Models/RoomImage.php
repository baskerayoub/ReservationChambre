<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RoomImage extends Model
{
    protected $fillable = ['room_id', 'path', 'is_primary', 'sort_order'];

    protected $casts = [
        'is_primary' => 'boolean',
    ];

    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    public function getUrlAttribute(): string
    {
        return asset('storage/' . $this->path);
    }
}
