<?php

use Faker\Generator as Faker;

$factory->define(App\Comment::class, function (Faker $faker) {
    return [
        'comment' => $faker->sentence,
        'owner_id' => $faker->biasedNumberBetween($min = 1, $max = 18),
        'film_id' => $faker->biasedNumberBetween($min = 1, $max = 40),
    ];
});
