<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use App\Event;
use App\Location;
use App\TimeSlot;
use App\User;
use Tests\Setup\AttributeFactory;

class ManageEventsTest extends TestCase
{
    use RefreshDatabase, WithFaker, AttributeFactory;

    /** @test **/
    public function guest_users_cannot_manage_events()
    {
        $event = factory(Event::class)->create();

        $this->get('/events')
            ->assertRedirect('login');

        $this->post('/events', $event->toArray())
            ->assertRedirect('login');

        $this->get('/events/create')
            ->assertRedirect('login');

        $this->get($event->path())
            ->assertRedirect('login');

        $this->patch($event->path(), $event->toArray())
            ->assertRedirect('login');

        $this->delete($event->path())
            ->assertRedirect('login');

        $this->get($event->path() . '/edit')
            ->assertRedirect('login');
    }

    /** @test **/
    public function an_authenticated_user_cannot_manage_the_events_of_others()
    {
        $this->actingAs(factory(User::class)->create());

        $event = factory(Event::class)->create();

        $this->get($event->path())
            ->assertStatus(403);

        $this->patch($event->path(), $event->toArray())
            ->assertStatus(403);

        $this->delete($event->path())
            ->assertStatus(403);

        $this->get($event->path() . '/edit')
            ->assertStatus(403);
    }

    /** @test **/
    public function a_user_can_create_a_event()
    {
        $user = factory(User::class)->create();
        $this->actingAs($user);

        $location = factory(Location::class)->create(['user_id' => $user->id]);

        $eventAttributes = $this->generateEventAttributes($user->id);
        $timeSlotAttributes = $this->generateTimeSlotAttributes($eventAttributes['start'], $eventAttributes['end'], $location->id, null, 3);

        $attributes = $eventAttributes;
        $attributes['time_slots'] = $timeSlotAttributes;

        $this->get('/events/create')
            ->assertStatus(200);

        $this->post('/events', $attributes)
            ->assertRedirect('/events');

        $this->assertDatabaseHas('events', $eventAttributes);

        foreach ($timeSlotAttributes as $timeSlot) {
            $this->assertDatabaseHas('time_slots', $timeSlot);
        }
    }

    /** @test */
    public function a_user_can_view_all_their_events()
    {
        $event = factory(Event::class)->create();
        $timeSlot = factory(TimeSlot::class)->create(['event_id' => $event->id, 'user_id' => $event->user_id]);

        $this->actingAs($event->owner)
            ->get('/events')
            ->assertStatus(200)
            ->assertPropCount('events', 1)
            ->assertPropValue('events', function ($events) {
                $this->assertEquals(
                    ['id', 'event_id', 'slot_start', 'slot_end', 
                    'location_id', 'event_start', 'event_end', 
                    'event_title', 'event_description'],
                    array_keys($events[0])
                );
            });
    }

    /** @test */
    public function a_user_can_view_their_event()
    {
        $event = factory(Event::class)->create();

        $this->actingAs($event->owner)
            ->get($event->path())
            ->assertSee($event->title);
    }

    /** @test */
    public function a_user_can_update_a_event()
    {
        $event = factory(Event::class)->create();

        $newAttributes = [
            'title' => 'new title',
            'description' => 'new description',
            'start' => '2020-03-01',
            'end' => '2020-03-07',
        ];

        $this->actingAs($event->owner)
            ->get($event->path() . '/edit')
            ->assertOk();

        $this->actingAs($event->owner)
            ->patch($event->path(), $newAttributes)
            ->assertRedirect('/events');

        $this->assertDatabaseHas('events', $newAttributes);
    }

    /** @test */
    public function a_user_can_delete_a_event()
    {
        $event = factory(Event::class)->create();

        $this->actingAs($event->owner)
            ->delete($event->path())
            ->assertRedirect('/events');

        $this->assertDatabaseMissing('events', $event->toArray());
    }

    
}
