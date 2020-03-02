<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Location;
use App\Reservation;
use App\TimeSlot;
use Faker\Generator as Faker;

$factory->define(TimeSlot::class, function (Faker $faker) {
    $reservation = factory(Reservation::class)->create();
    $startSlot = $faker->dateTimeBetween($reservation->start_date, $reservation->end_date);
    
    return [
        'reservation_id' => $reservation->id,
        'location_id' => factory(Location::class),
        'start' => $startSlot->format('Y-m-d H:i'),
        'end' => $faker->dateTimeBetween($startSlot, $startSlot->format('Y-m-d 23:59:59'))->format('Y-m-d H:i'),
    ];
});
