<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

use App\Reservation;
use App\User;

class ValidateReservationsTest extends TestCase
{
    use RefreshDatabase;
    
    /** @test */
    public function a_reservation_have_required_attributes()
    {
        $attributes = [
            'title',
            'description',
            'start_date',
            'end_date',
        ];

        $user = factory(User::class)->create();
        $this->actingAs($user);

        foreach ($attributes as $attribute) {
            $reservation = $this->setupInvalidReservation($attribute, $user->id);

            $this->post('/reservations', $reservation)
                ->assertSessionHasErrors($attribute);

            $this->assertDatabaseMissing('reservations', ['user_id' => $reservation['user_id']]);
        }
    }

    /**
     * Returns a reservation attributes array with one of the attributes initialized as blank.
     *
     * @param string $attribute
     * @param int $user_id
     * @return array
     */
    private function setupInvalidReservation(string $attribute, int $user_id)
    {
        return factory(Reservation::class)->raw([$attribute => '', 'user_id' => $user_id]);
    }
}
