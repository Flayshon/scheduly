<?php

namespace Tests\Feature;

use App\Location;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ManageLocationsTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    /** @test */
    public function a_user_can_create_a_location()
    {
        $user = factory(User::class)->create();

        $attributes = ['title' => $this->faker->state];

        $this->actingAs($user)
            ->post('/locations', $attributes);
        
        $this->assertDatabaseHas('locations', $attributes);
    }

    /** @test */
    public function a_user_can_update_a_location()
    {
        $this->withoutExceptionHandling();

        $location = factory(Location::class)->create();

        $this->actingAs($location->owner)
            ->patch($location->path(), $updated = ['title' => 'New Location']);
        
        $this->assertDatabaseHas('locations', $updated);
    }
    
    /** @test */
    public function a_user_can_delete_a_location()
    {
        $location = factory(Location::class)->create();
        
        $attributes = $location->attributesToArray();

        $this->actingAs($location->owner)
            ->delete($location->path());
        
        $this->assertDatabaseMissing('locations', $attributes);
    }
    
}
