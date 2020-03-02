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
    public function it_belongs_to_a_user()
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

        $startSlot = $this->faker->dateTimeBetween($reservation->start_date, $reservation->end_date);
        $timeSlot = $reservation->addTimeSlot([
            'reservation_id' => $reservation->id,
            'location_id' => factory(Location::class)->create()->id,
            'start' => $startSlot->format('Y-m-d H:i'),
            'end' => $this->faker->dateTimeBetween($startSlot, $startSlot->format('Y-m-d 23:59'))->format('Y-m-d H:i'),
        ]);

        $this->assertTrue($reservation->timeSlots->contains($timeSlot));
    }
}
