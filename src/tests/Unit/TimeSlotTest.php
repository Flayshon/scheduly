<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

use App\Event;
use App\TimeSlot;
use App\Location;

class TimeSlotTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_belongs_to_a_event()
    {
        $timeSlot = factory(TimeSlot::class)->create();
        
        $this->assertInstanceOf(Event::class, $timeSlot->event);
    }
    
    /** @test */
    public function it_has_one_location()
    {
        $timeSlot = factory(TimeSlot::class)->create();
        
        $this->assertInstanceOf(Location::class, $timeSlot->location);
    }
}
