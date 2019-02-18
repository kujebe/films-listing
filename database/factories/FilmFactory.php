<?php

use Faker\Generator as Faker;

$factory->define(App\Film::class, function (Faker $faker) {
    return [
        'name' => $faker -> text(15),
        'description' => $faker -> text(1500),
        'slug' => $faker -> slug($nbWords = 3, $variableNbWords = true),
        'release_date' => $faker -> date($format = 'Y-m-d', $max = 'now'),
        'rating' => $faker -> biasedNumberBetween($min = 0, $max = 5),
        'ticket_price' => $faker -> randomFloat($nbMaxDecimals = null, $min = 0, $max = 100),
        'country' => $faker -> country(), 
        'genre' => $faker -> text(10),
    ];
});