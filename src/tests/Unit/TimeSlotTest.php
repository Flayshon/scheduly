<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

use App\Reservation;
use App\TimeSlot;
use App\Location;

class TimeSlotTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_belongs_to_a_reservation()
    {
        $timeSlot = factory(TimeSlot::class)->create();
        
        $this->assertInstanceOf(Reservation::class, $timeSlot->reservation);
    }
    
    /** @test */
    public function it_has_one_location()
    {
        $timeSlot = factory(TimeSlot::class)->create();
        
        $this->assertInstanceOf(Location::class, $timeSlot->location);
    }
}
