<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Location;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LocationTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_belongs_to_a_user()
    {
        $location = factory(Location::class)->create();

        $this->assertInstanceOf(User::class, $location->owner);
    }
}
