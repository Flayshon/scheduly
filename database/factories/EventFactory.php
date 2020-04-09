<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Event;
use App\User;
use Faker\Generator as Faker;

$factory->define(Event::class, function (Faker $faker) {
    $start = $faker->dateTimeBetween('-2 days', '+20 days');

    return [
        'title' => $faker->name,
        'description' => $faker->text(140),
        'start' => $start->format('Y-m-d'),
        'end' => $faker->dateTimeBetween($start, $start->format('Y-m-d').' +4 days')->format('Y-m-d'),
        'user_id' => factory(User::class),
    ];
});
