<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Location;
use App\Event;
use App\TimeSlot;
use App\User;
use Faker\Generator as Faker;

$factory->define(TimeSlot::class, function (Faker $faker) {
    $event = factory(Event::class)->create();
    $startSlot = $faker->dateTimeBetween($event->start_date, $event->end_date);
    
    return [
        'user_id' => factory(User::class),
        'event_id' => $event->id,
        'location_id' => factory(Location::class),
        'start' => $startSlot->format('c'),
        'end' => $faker->dateTimeBetween($startSlot, $startSlot->format('Y-m-d 23:59:59'))->format('c'),
    ];
});
