<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use App\Event;
use App\Location;
use App\TimeSlot;
use App\User;

class EventTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /** @test */
    public function it_has_a_path()
    {
        $event = factory(Event::class)->create();

        $this->assertEquals("/events/{$event->id}", $event->path());
    }

    /** @test */
    public function it_belongs_to_a_user()
    {
        $event = factory(Event::class)->create();

        $this->assertInstanceOf(User::class, $event->owner);
    }

    /** @test */
    public function it_has_many_time_slots()
    {
        $event = factory(Event::class)->create();

        $this->assertInstanceOf(Collection::class, $event->timeSlots);
    }

    /** @test */
    public function time_slots_can_be_added()
    {
        $event = factory(TimeSlot::class)->create()->event;

        $startSlot = $this->faker->dateTimeBetween($event->start_date, $event->end_date);
        $timeSlot = $event->addTimeSlot([
            'user_id' => $event->owner->id,
            'event_id' => $event->id,
            'location_id' => factory(Location::class)->create()->id,
            'start' => $startSlot->format('c'),
            'end' => $this->faker->dateTimeBetween($startSlot, $startSlot->format('Y-m-d 23:59'))->format('c'),
        ]);

        $this->assertTrue($event->timeSlots->contains($timeSlot));
    }
}
