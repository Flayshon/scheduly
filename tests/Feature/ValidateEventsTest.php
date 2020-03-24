<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

use App\Event;
use App\User;

class ValidateEventsTest extends TestCase
{
    use RefreshDatabase;
    
    /** @test */
    public function a_event_have_required_attributes()
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
            $event = $this->setupInvalidEvent($attribute, $user->id);

            $this->post('/events', $event)
                ->assertSessionHasErrors($attribute);

            $this->assertDatabaseMissing('events', ['user_id' => $event['user_id']]);
        }
    }

    /**
     * Returns a event attributes array with one of the attributes initialized as blank.
     *
     * @param string $attribute
     * @param int $user_id
     * @return array
     */
    private function setupInvalidEvent(string $attribute, int $user_id)
    {
        return factory(Event::class)->raw([$attribute => '', 'user_id' => $user_id]);
    }
}
