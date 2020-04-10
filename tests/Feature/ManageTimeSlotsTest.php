<?php

namespace Tests\Feature;

use App\Event;
use App\Location;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\Setup\AttributeFactory;
use Tests\TestCase;

class ManageTimeSlotsTest extends TestCase
{
    use RefreshDatabase, WithFaker, AttributeFactory;

    /** @test */
    public function a_user_can_create_time_slots()
    {
        $user = factory(User::class)->create();
        $this->actingAs($user);

        $event = factory(Event::class)->create(['user_id' => $user->id]);
        $location = factory(Location::class)->create(['user_id' => $user->id]);

        $attributes = $this->generateTimeSlotAttributes($event->start, $event->end, $location->id, $event->id, $user->id);
        //$attributes['start'] = str_replace('2020', '2019', $attributes['start']);
        //dd($event->start, $attributes['start'],substr($attributes['end'], 0, strpos($attributes['end'], 'T')), $event->end);

        $this->post('/time-slots', $attributes)
            ->assertSessionHasNoErrors()
            ->assertRedirect('/events');

        $this->assertDatabaseHas('time_slots', $attributes);
    }
}
