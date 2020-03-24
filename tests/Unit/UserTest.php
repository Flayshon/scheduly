<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Database\Eloquent\Collection;
use Tests\TestCase;
use App\User;

class UserTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_has_events()
    {
        $user = factory(User::class)->create();

        $this->assertInstanceOf(Collection::class, $user->events);
    }

    /** @test */
    public function it_has_locations()
    {
        $user = factory(User::class)->create();

        $this->assertInstanceOf(Collection::class, $user->locations);
    }
    
}
