<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Reservation;
use App\User;
use Faker\Generator as Faker;

$factory->define(Reservation::class, function (Faker $faker) {
    $start = $faker->dateTimeBetween('-2 days', '+20 days');

    return [
        'title' => $faker->name,
        'description' => $faker->text(140),
        'start_date' => $start->format('Y-m-d'),
        'end_date' => $faker->dateTimeBetween($start, $start->format('Y-m-d').' +4 days')->format('Y-m-d'),
        'user_id' => factory(User::class)
    ];
});
