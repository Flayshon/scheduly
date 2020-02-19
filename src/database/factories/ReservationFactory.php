<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Reservation;
use Faker\Generator as Faker;

$factory->define(Reservation::class, function (Faker $faker) {
    return [
        'title' => $faker->title,
        'description' => $faker->text(140),
        'start_date' => $start = $faker->dateTimeBetween('-2 days', '+20 days'),
        'end_date' => $faker->dateTimeBetween($start, $start->format('Y-m-d').' +4 days')
    ];
});
