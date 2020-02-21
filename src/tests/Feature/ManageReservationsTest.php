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

    /** @test **/
    public function a_user_can_create_a_reservation()
    {
        $user = factory(User::class)->create();
        $this->actingAs($user);

        $start = $this->faker->dateTimeBetween('-2 days', '+20 days');
        $end = $this->faker->dateTimeBetween($start, $start->format('Y-m-d') . ' +4 days');
        $startSlot = $this->faker->dateTimeBetween($start, $end);
        $endSlot = $this->faker->dateTimeBetween($startSlot, $end);

        $attributes = [
            'title' => $this->faker->title,
            'description' => $this->faker->text(140),
            'start_date' => $start->format('Y-m-d'),
            'end_date' => $end->format('Y-m-d'),
            'start_slot' => $startSlot->format('Y-m-d'),
            'end_slot' => $endSlot->format('Y-m-d'),
        ];

        $this->get('/reservations/create')
            ->assertStatus(200);

        $this->post('/reservations', $attributes)
            ->assertRedirect('/reservations');

        $this->assertDatabaseHas('reservations', $attributes);
    }

    /** @test */
    public function a_user_can_view_all_their_reservations()
    {
        $reservation = factory(Reservation::class)->create();

        $this->actingAs($reservation->owner)
            ->get('/reservations')
            ->assertSee(e($reservation->title));
    }

    /** @test */
    public function a_user_can_view_their_reservation()
    {
        $reservation = factory(Reservation::class)->create();

        $this->actingAs($reservation->owner)
            ->get($reservation->path())
            ->assertSee(e($reservation->title));
    }

    /** @test */
    public function a_user_can_update_a_reservation()
    {
        $reservation = factory(Reservation::class)->create();

        $newAttributes = [
            'title' => 'new title',
            'description' => 'new description',
            'start_date' => '2020-03-01',
            'end_date' => '2020-03-07',
        ];

        $this->actingAs($reservation->owner)
            ->get($reservation->path() . '/edit')
            ->assertOk();

        $this->actingAs($reservation->owner)
            ->patch($reservation->path(), $newAttributes)
            ->assertRedirect('/reservations');

        $this->assertDatabaseHas('reservations', $newAttributes);
    }

    /** @test */
    public function a_user_can_delete_a_reservation()
    {
        $reservation = factory(Reservation::class)->create();

        $this->actingAs($reservation->owner)
            ->delete($reservation->path())
            ->assertRedirect('/reservations');

        $this->assertDatabaseMissing('reservations', $reservation->toArray());
    }
}
