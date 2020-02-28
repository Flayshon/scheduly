<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Location;
use App\User;
use Faker\Generator as Faker;

$factory->define(Location::class, function (Faker $faker) {
    return [
        'user_id' => factory(User::class),
        'title' => $faker->state,
    ];
});
