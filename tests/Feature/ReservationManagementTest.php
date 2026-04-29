<?php

namespace Tests\Feature;

use App\Models\Chambre;
use App\Models\Reservation;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ReservationManagementTest extends TestCase
{
    use RefreshDatabase;

    public function test_client_cannot_double_book_same_room_for_overlapping_dates(): void
    {
        $client = User::factory()->create();
        $room = $this->createRoom();
        $start = now()->addDays(5)->toDateString();
        $end = now()->addDays(8)->toDateString();

        Reservation::create([
            'user_id' => $client->id,
            'chambre_id' => $room->id,
            'date_debut' => $start,
            'date_fin' => $end,
            'nombre_personnes' => 2,
            'status' => 'confirmed',
            'prix_total' => 1500,
        ]);

        $response = $this->actingAs($client)->post(route('reservations.store'), [
            'chambre_id' => $room->id,
            'date_debut' => now()->addDays(6)->toDateString(),
            'date_fin' => now()->addDays(9)->toDateString(),
            'nombre_personnes' => 2,
        ]);

        $response->assertSessionHasErrors('date_debut');
    }

    public function test_payment_simulation_marks_reservation_paid_and_confirmed(): void
    {
        $client = User::factory()->create();
        $room = $this->createRoom();

        $reservation = Reservation::create([
            'user_id' => $client->id,
            'chambre_id' => $room->id,
            'date_debut' => now()->addDays(10)->toDateString(),
            'date_fin' => now()->addDays(12)->toDateString(),
            'nombre_personnes' => 2,
            'status' => 'pending',
            'prix_total' => 1000,
        ]);

        $response = $this->actingAs($client)->post(route('payments.store', $reservation), [
            'method' => 'cash',
        ]);

        $response->assertRedirect(route('reservations.show', $reservation));
        $this->assertDatabaseHas('reservations', [
            'id' => $reservation->id,
            'status' => 'confirmed',
        ]);
        $this->assertDatabaseHas('payments', [
            'reservation_id' => $reservation->id,
            'montant' => 1000,
            'method' => 'cash',
            'status' => 'paid',
        ]);
    }

    private function createRoom(): Chambre
    {
        return Chambre::create([
            'numero' => 'T-101',
            'type' => 'Double',
            'prix' => 500,
            'confort' => 'Standard',
            'equipements' => ['WiFi', 'TV'],
            'description' => 'Test room',
            'status' => 'disponible',
        ]);
    }
}
