<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Reservation;
use App\User;
use Tests\TestCase;

class ReservationTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_has_a_path()
    {
        $reservation = factory(Reservation::class)->create();

        $this->assertEquals("/reservations/{$reservation->id}", $reservation->path());
    }

    /** @test */
    public function a_reservation_belongs_to_an_owner()
    {
        $reservation = factory(Reservation::class)->create();

        $this->assertInstanceOf(User::class, $reservation->owner);
    }

}
