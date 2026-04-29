<?php

namespace Database\Seeders;

use App\Models\Chambre;
use App\Models\Payment;
use App\Models\Reservation;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // ── Users ──
        $admin = User::updateOrCreate(
            ['email' => 'admin@familyhotel.test'],
            [
                'name' => 'Hotel Admin',
                'role' => 'admin',
                'password' => Hash::make('password'),
            ]
        );

        $staff = User::updateOrCreate(
            ['email' => 'staff@familyhotel.test'],
            [
                'name' => 'Sarah Staff',
                'role' => 'staff',
                'password' => Hash::make('password'),
            ]
        );

        $client = User::updateOrCreate(
            ['email' => 'client@familyhotel.test'],
            [
                'name' => 'John Doe',
                'role' => 'client',
                'password' => Hash::make('password'),
            ]
        );

        $client2 = User::updateOrCreate(
            ['email' => 'jane@familyhotel.test'],
            [
                'name' => 'Jane Smith',
                'role' => 'client',
                'password' => Hash::make('password'),
            ]
        );

        // ── Rooms ──
        $rooms = [
            [
                'numero' => '101',
                'type' => 'Single',
                'prix' => 350,
                'confort' => 'Standard',
                'equipements' => ['WiFi', 'TV', 'Desk'],
                'description' => 'A cozy single room perfect for solo travelers and business trips. Features a comfortable queen bed, work desk, and modern amenities for a relaxing stay.',
                'image' => 'https://images.unsplash.com/photo-1566665797739-1674de7a421a?auto=format&fit=crop&w=1200&q=80',
                'status' => 'disponible',
            ],
            [
                'numero' => '102',
                'type' => 'Single',
                'prix' => 420,
                'confort' => 'Deluxe',
                'equipements' => ['WiFi', 'Smart TV', 'Desk', 'Air Conditioning', 'Private Bathroom'],
                'description' => 'An upgraded single room with premium bedding, smart TV, and a dedicated workspace. Ideal for extended business stays.',
                'image' => 'https://images.unsplash.com/photo-1631049307264-da0ec9d70304?auto=format&fit=crop&w=1200&q=80',
                'status' => 'disponible',
            ],
            [
                'numero' => '201',
                'type' => 'Double',
                'prix' => 520,
                'confort' => 'Standard',
                'equipements' => ['WiFi', 'TV', 'Private Bathroom', 'Air Conditioning'],
                'description' => 'A spacious double room for couples or friends. Features two comfortable beds, private bathroom, and all essential amenities.',
                'image' => 'https://images.unsplash.com/photo-1590490360182-c33d57733427?auto=format&fit=crop&w=1200&q=80',
                'status' => 'disponible',
            ],
            [
                'numero' => '202',
                'type' => 'Double',
                'prix' => 690,
                'confort' => 'Deluxe',
                'equipements' => ['WiFi', 'Smart TV', 'Air Conditioning', 'Balcony', 'Mini Bar'],
                'description' => 'A bright deluxe double room with balcony views and premium touches. Perfect for a romantic getaway or a comfortable family trip.',
                'image' => 'https://images.unsplash.com/photo-1595576508898-0ad5c879a061?auto=format&fit=crop&w=1200&q=80',
                'status' => 'disponible',
            ],
            [
                'numero' => '301',
                'type' => 'Family',
                'prix' => 850,
                'confort' => 'Deluxe',
                'equipements' => ['WiFi', 'Smart TV', 'Air Conditioning', 'Private Bathroom', 'Living Area', 'Breakfast'],
                'description' => 'A generous family room designed for parents and children. Includes a separate living area, breakfast included, and everything your family needs.',
                'image' => 'https://images.unsplash.com/photo-1596394516093-501ba68a0ba6?auto=format&fit=crop&w=1200&q=80',
                'status' => 'disponible',
            ],
            [
                'numero' => '302',
                'type' => 'Family',
                'prix' => 980,
                'confort' => 'Luxury',
                'equipements' => ['WiFi', 'Smart TV', 'Air Conditioning', 'Balcony', 'Mini Bar', 'Living Area', 'Parking', 'Breakfast'],
                'description' => 'Our premium family suite with breathtaking views, spacious living area, complimentary breakfast, and free parking. The ultimate family experience.',
                'image' => 'https://images.unsplash.com/photo-1611892440504-42a792e24d32?auto=format&fit=crop&w=1200&q=80',
                'status' => 'disponible',
            ],
            [
                'numero' => '401',
                'type' => 'Suite',
                'prix' => 1250,
                'confort' => 'Luxury',
                'equipements' => ['WiFi', 'Smart TV', 'Air Conditioning', 'Balcony', 'Mini Bar', 'Living Area', 'Desk', 'Parking', 'Breakfast'],
                'description' => 'An exquisite luxury suite featuring separate living and sleeping areas, panoramic balcony, full minibar, and VIP amenities.',
                'image' => 'https://images.unsplash.com/photo-1578683010236-d716f9a3f461?auto=format&fit=crop&w=1200&q=80',
                'status' => 'disponible',
            ],
            [
                'numero' => '402',
                'type' => 'Suite',
                'prix' => 1100,
                'confort' => 'Luxury',
                'equipements' => ['WiFi', 'TV', 'Air Conditioning'],
                'description' => 'Currently undergoing renovation to provide an even better luxury experience. Expected to reopen soon with upgraded furnishings.',
                'image' => 'https://images.unsplash.com/photo-1582719478250-c89cae4dc85b?auto=format&fit=crop&w=1200&q=80',
                'status' => 'maintenance',
            ],
        ];

        foreach ($rooms as $room) {
            Chambre::updateOrCreate(['numero' => $room['numero']], $room);
        }

        // ── Reservations ──

        // Confirmed + paid reservation
        $room201 = Chambre::where('numero', '201')->firstOrFail();
        $start1 = now()->addDays(7)->toDateString();
        $end1 = now()->addDays(10)->toDateString();
        $total1 = (float) $room201->prix * 3;

        $res1 = Reservation::updateOrCreate(
            ['user_id' => $client->id, 'chambre_id' => $room201->id, 'date_debut' => $start1],
            [
                'date_fin' => $end1,
                'nombre_personnes' => 2,
                'status' => 'confirmed',
                'prix_total' => $total1,
            ]
        );

        Payment::updateOrCreate(
            ['reservation_id' => $res1->id],
            [
                'montant' => $total1,
                'method' => 'stripe',
                'status' => 'paid',
                'transaction_id' => 'STRIPE-SIM-ABC123DEFG',
            ]
        );

        // Pending reservation
        $room302 = Chambre::where('numero', '302')->firstOrFail();
        $start2 = now()->addDays(14)->toDateString();
        $end2 = now()->addDays(18)->toDateString();
        $total2 = (float) $room302->prix * 4;

        $res2 = Reservation::updateOrCreate(
            ['user_id' => $client2->id, 'chambre_id' => $room302->id, 'date_debut' => $start2],
            [
                'date_fin' => $end2,
                'nombre_personnes' => 4,
                'status' => 'pending',
                'prix_total' => $total2,
            ]
        );

        // Confirmed reservation (PayPal)
        $room202 = Chambre::where('numero', '202')->firstOrFail();
        $start3 = now()->addDays(3)->toDateString();
        $end3 = now()->addDays(5)->toDateString();
        $total3 = (float) $room202->prix * 2;

        $res3 = Reservation::updateOrCreate(
            ['user_id' => $client->id, 'chambre_id' => $room202->id, 'date_debut' => $start3],
            [
                'date_fin' => $end3,
                'nombre_personnes' => 2,
                'status' => 'confirmed',
                'prix_total' => $total3,
            ]
        );

        Payment::updateOrCreate(
            ['reservation_id' => $res3->id],
            [
                'montant' => $total3,
                'method' => 'paypal',
                'status' => 'paid',
                'transaction_id' => 'PAYPAL-SIM-XYZ789MNOP',
            ]
        );

        // Cancelled reservation
        $room101 = Chambre::where('numero', '101')->firstOrFail();
        $start4 = now()->subDays(5)->toDateString();
        $end4 = now()->subDays(2)->toDateString();
        $total4 = (float) $room101->prix * 3;

        Reservation::updateOrCreate(
            ['user_id' => $client2->id, 'chambre_id' => $room101->id, 'date_debut' => $start4],
            [
                'date_fin' => $end4,
                'nombre_personnes' => 1,
                'status' => 'cancelled',
                'prix_total' => $total4,
            ]
        );

        // Cash payment reservation
        $room301 = Chambre::where('numero', '301')->firstOrFail();
        $start5 = now()->addDays(1)->toDateString();
        $end5 = now()->addDays(4)->toDateString();
        $total5 = (float) $room301->prix * 3;

        $res5 = Reservation::updateOrCreate(
            ['user_id' => $client2->id, 'chambre_id' => $room301->id, 'date_debut' => $start5],
            [
                'date_fin' => $end5,
                'nombre_personnes' => 3,
                'status' => 'confirmed',
                'prix_total' => $total5,
            ]
        );

        Payment::updateOrCreate(
            ['reservation_id' => $res5->id],
            [
                'montant' => $total5,
                'method' => 'cash',
                'status' => 'paid',
                'transaction_id' => 'CASH-SIM-ONSITE001',
            ]
        );
    }
}
