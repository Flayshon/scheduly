<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Location;
use App\Reservation;
use App\TimeSlot;
use Faker\Generator as Faker;

$factory->define(TimeSlot::class, function (Faker $faker) {
    $reservation = factory(Reservation::class)->create();

    return [
        'reservation_id' => $reservation->id,
        'location_id' => factory(Location::class),
        'start' => $startSlot = $faker->dateTimeBetween($reservation->start_date, $reservation->end_date),
        'end' => $faker->dateTimeBetween($startSlot, $reservation->end_date),
    ];
});
