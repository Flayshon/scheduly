<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Reservation;
use Tests\TestCase;

class TimeSlotTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_belongs_to_a_reservation()
    {
        $this->withoutExceptionHandling();
        $timeSlot = factory(Reservation::class)->create();

        $this->assertInstanceOf(Reservation::class, $timeSlot->reservation);
    }
}
