<?php

namespace Database\Seeders;

use App\Models\Amenity;
use App\Models\Payment;
use App\Models\Reservation;
use App\Models\Review;
use App\Models\Room;
use App\Models\RoomImage;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        /* ── Users ──────────────────────────────────── */

        $admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@hotelia.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'email_verified_at' => now(),
        ]);

        $receptionist = User::create([
            'name' => 'Sarah Martin',
            'email' => 'reception@hotelia.com',
            'password' => Hash::make('password'),
            'role' => 'receptionist',
            'email_verified_at' => now(),
        ]);

        $clients = collect([
            ['name' => 'John Doe', 'email' => 'john@example.com'],
            ['name' => 'Jane Smith', 'email' => 'jane@example.com'],
            ['name' => 'Mike Johnson', 'email' => 'mike@example.com'],
            ['name' => 'Emily Davis', 'email' => 'emily@example.com'],
            ['name' => 'David Wilson', 'email' => 'david@example.com'],
        ])->map(fn ($c) => User::create([
            ...$c,
            'password' => Hash::make('password'),
            'role' => 'client',
            'email_verified_at' => now(),
        ]));

        /* ── Amenities ──────────────────────────────── */

        $amenities = collect([
            ['name' => 'Free Wi-Fi', 'icon' => 'wifi'],
            ['name' => 'Air Conditioning', 'icon' => 'snowflake'],
            ['name' => 'Mini Bar', 'icon' => 'glass-water'],
            ['name' => 'Room Service', 'icon' => 'bell-concierge'],
            ['name' => 'TV', 'icon' => 'tv'],
            ['name' => 'Safe', 'icon' => 'vault'],
            ['name' => 'Balcony', 'icon' => 'mountain-sun'],
            ['name' => 'Sea View', 'icon' => 'water'],
            ['name' => 'Bathtub', 'icon' => 'bath'],
            ['name' => 'King Size Bed', 'icon' => 'bed'],
            ['name' => 'Breakfast Included', 'icon' => 'mug-saucer'],
            ['name' => 'Swimming Pool Access', 'icon' => 'person-swimming'],
        ])->map(fn ($a) => Amenity::create($a));

        /* ── Rooms ──────────────────────────────────── */

        $roomsData = [
            [
                'name' => 'Comfort Single Room',
                'type' => 'single',
                'description' => 'A cozy and elegant single room, perfect for solo travelers. Features modern amenities and a peaceful atmosphere for a restful stay.',
                'price_per_night' => 89.00,
                'capacity' => 1,
                'beds' => 1,
                'bathrooms' => 1,
                'area' => 22,
                'floor' => 1,
                'is_featured' => false,
                'amenity_ids' => [1, 2, 5, 6],
            ],
            [
                'name' => 'Superior Double Room',
                'type' => 'double',
                'description' => 'Spacious double room with elegant décor, ideal for couples. Enjoy premium bedding and a relaxing ambiance throughout your stay.',
                'price_per_night' => 129.00,
                'capacity' => 2,
                'beds' => 1,
                'bathrooms' => 1,
                'area' => 30,
                'floor' => 2,
                'is_featured' => true,
                'amenity_ids' => [1, 2, 3, 5, 6, 10],
            ],
            [
                'name' => 'Deluxe Room with Sea View',
                'type' => 'deluxe',
                'description' => 'Luxurious deluxe room offering breathtaking sea views from your private balcony. Indulge in premium comfort with top-tier amenities.',
                'price_per_night' => 199.00,
                'capacity' => 2,
                'beds' => 1,
                'bathrooms' => 1,
                'area' => 38,
                'floor' => 4,
                'is_featured' => true,
                'amenity_ids' => [1, 2, 3, 4, 5, 6, 7, 8, 10],
            ],
            [
                'name' => 'Family Suite',
                'type' => 'family',
                'description' => 'A generously designed family suite with separate living and sleeping areas. Perfect for families seeking comfort and convenience.',
                'price_per_night' => 259.00,
                'capacity' => 4,
                'beds' => 2,
                'bathrooms' => 2,
                'area' => 55,
                'floor' => 3,
                'is_featured' => true,
                'amenity_ids' => [1, 2, 3, 4, 5, 6, 9, 11],
            ],
            [
                'name' => 'Royal Presidential Suite',
                'type' => 'suite',
                'description' => 'The crown jewel of Hotelia. An expansive suite with panoramic views, a private jacuzzi, and the finest furnishings for an unforgettable experience.',
                'price_per_night' => 449.00,
                'capacity' => 3,
                'beds' => 1,
                'bathrooms' => 2,
                'area' => 75,
                'floor' => 5,
                'is_featured' => true,
                'amenity_ids' => [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12],
            ],
            [
                'name' => 'Economy Twin Room',
                'type' => 'double',
                'description' => 'A budget-friendly twin room offering all essential amenities. Great value for travelers who want comfort without the premium price tag.',
                'price_per_night' => 99.00,
                'capacity' => 2,
                'beds' => 2,
                'bathrooms' => 1,
                'area' => 26,
                'floor' => 1,
                'is_featured' => false,
                'amenity_ids' => [1, 2, 5, 6],
            ],
            [
                'name' => 'Garden View Double',
                'type' => 'double',
                'description' => 'A charming double room overlooking our lush Mediterranean garden. Wake up to birdsong and the scent of fresh flowers every morning.',
                'price_per_night' => 149.00,
                'capacity' => 2,
                'beds' => 1,
                'bathrooms' => 1,
                'area' => 32,
                'floor' => 2,
                'is_featured' => true,
                'amenity_ids' => [1, 2, 3, 5, 6, 7, 10, 11],
            ],
            [
                'name' => 'Honeymoon Suite',
                'type' => 'suite',
                'description' => 'Romantic suite designed for newlyweds and couples celebrating special occasions. Features a private terrace, champagne service, and spa access.',
                'price_per_night' => 349.00,
                'capacity' => 2,
                'beds' => 1,
                'bathrooms' => 1,
                'area' => 50,
                'floor' => 5,
                'is_featured' => true,
                'amenity_ids' => [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12],
            ],
        ];

        foreach ($roomsData as $roomData) {
            $amenityIds = $roomData['amenity_ids'];
            unset($roomData['amenity_ids']);

            $room = Room::create([
                ...$roomData,
                'slug' => Str::slug($roomData['name']) . '-' . Str::random(4),
                'status' => 'available',
            ]);

            $room->amenities()->sync($amenityIds);

            // Create a placeholder primary image
            RoomImage::create([
                'room_id' => $room->id,
                'path' => 'rooms/placeholder.jpg',
                'is_primary' => true,
                'sort_order' => 0,
            ]);
        }

        /* ── Demo Reservations ──────────────────────── */

        $rooms = Room::all();

        // Past completed reservations
        foreach ($clients->take(3) as $i => $client) {
            $reservation = Reservation::create([
                'user_id' => $client->id,
                'room_id' => $rooms[$i + 1]->id,
                'check_in' => now()->subDays(10 + $i * 5),
                'check_out' => now()->subDays(7 + $i * 5),
                'guests' => rand(1, 2),
                'total_price' => $rooms[$i + 1]->price_per_night * 3,
                'status' => 'completed',
            ]);

            Payment::create([
                'reservation_id' => $reservation->id,
                'user_id' => $client->id,
                'amount' => $reservation->total_price,
                'method' => $i % 2 === 0 ? 'stripe' : 'paypal',
                'status' => 'completed',
                'transaction_id' => 'demo_' . Str::random(16),
            ]);

            Review::create([
                'user_id' => $client->id,
                'room_id' => $reservation->room_id,
                'reservation_id' => $reservation->id,
                'rating' => rand(4, 5),
                'comment' => collect([
                    'Amazing stay! The room was spotless and the staff was incredibly friendly.',
                    'We had a wonderful time. The views from our room were absolutely stunning.',
                    'Perfect hotel for families. Our kids loved the pool and the breakfast was excellent.',
                    'Exceeded our expectations! Will definitely be coming back next year.',
                    'The spa was heavenly and the room service was top-notch. Highly recommended!',
                ])->random(),
                'is_approved' => true,
            ]);
        }

        // Upcoming confirmed reservations
        foreach ($clients->slice(2, 2) as $i => $client) {
            $reservation = Reservation::create([
                'user_id' => $client->id,
                'room_id' => $rooms[$i + 3]->id,
                'check_in' => now()->addDays(3 + $i * 2),
                'check_out' => now()->addDays(6 + $i * 2),
                'guests' => rand(1, 3),
                'total_price' => $rooms[$i + 3]->price_per_night * 3,
                'status' => 'confirmed',
            ]);

            Payment::create([
                'reservation_id' => $reservation->id,
                'user_id' => $client->id,
                'amount' => $reservation->total_price,
                'method' => 'stripe',
                'status' => 'completed',
                'transaction_id' => 'demo_' . Str::random(16),
            ]);
        }

        // Pending reservation
        $pendingRes = Reservation::create([
            'user_id' => $clients->last()->id,
            'room_id' => $rooms[0]->id,
            'check_in' => now()->addDays(7),
            'check_out' => now()->addDays(10),
            'guests' => 1,
            'total_price' => $rooms[0]->price_per_night * 3,
            'status' => 'pending',
            'special_requests' => 'Late check-in around 10 PM please.',
        ]);
    }
}
