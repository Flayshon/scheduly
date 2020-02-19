<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Reservation;
use App\User;

class ManageReservationsTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /** @test **/
    public function guest_users_cannot_manage_reservations()
    {
        $reservation = factory(Reservation::class)->create();

        $this->get('/reservations')
            ->assertRedirect('login');

        $this->post('/reservations', $reservation->toArray())
            ->assertRedirect('login');

        $this->get('/reservations/create')
            ->assertRedirect('login');

        $this->get($reservation->path())
            ->assertRedirect('login');

        $this->patch($reservation->path(), $reservation->toArray())
            ->assertRedirect('login');

        $this->delete($reservation->path())
            ->assertRedirect('login');

        $this->get($reservation->path() . '/edit')
            ->assertRedirect('login');
    }

    /** @test **/
    public function an_authenticated_user_cannot_manage_the_reservations_of_others()
    {
        $this->actingAs(factory(User::class)->create());

        $reservation = factory(Reservation::class)->create();

        $this->get($reservation->path())
            ->assertStatus(403);

        $this->patch($reservation->path(), $reservation->toArray())
            ->assertStatus(403);

        $this->delete($reservation->path())
            ->assertStatus(403);

        $this->get($reservation->path() . '/edit')
            ->assertStatus(403);
    }
}
