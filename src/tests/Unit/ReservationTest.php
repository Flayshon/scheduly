<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use App\Reservation;
use App\Location;
use App\TimeSlot;
use App\User;

class ReservationTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /** @test */
    public function it_has_a_path()
    {
        $reservation = factory(Reservation::class)->create();

        $this->assertEquals("/reservations/{$reservation->id}", $reservation->path());
    }

    /** @test */
    public function it_belongs_to_an_owner()
    {
        $reservation = factory(Reservation::class)->create();

        $this->assertInstanceOf(User::class, $reservation->owner);
    }

    /** @test */
    public function it_has_many_time_slots()
    {
        $reservation = factory(Reservation::class)->create();

        $this->assertInstanceOf(Collection::class, $reservation->timeSlots);
    }

    /** @test */
    public function time_slots_can_be_added()
    {
        $reservation = factory(TimeSlot::class)->create()->reservation;

        $timeSlot = $reservation->addTimeSlot([
            'reservation_id' => $reservation->id,
            'location_id' => factory(Location::class)->create()->id,
            'start' => $startSlot = $this->faker->dateTimeBetween($reservation->start_date, $reservation->end_date),
            'end' => $this->faker->dateTimeBetween($startSlot, $reservation->end_date),
        ]);

        $this->assertTrue($reservation->timeSlots->contains($timeSlot));
    }
}
