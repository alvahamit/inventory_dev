<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Contact;
use Faker\Generator as Faker;

$factory->define(Contact::class, function (Faker $faker) {
    return [
        'label' => $faker->randomElement(['cell', 'land', 'work', 'res']),
        'country_code' => $faker->randomNumber(3),
        'city_code'=> $faker->randomNumber(2),
        'number' => $faker->randomNumber(8)
    ];
});
