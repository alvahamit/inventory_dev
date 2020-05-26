<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Store;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(Store::class, function (Faker $faker) {
    return [
        //
        'name' => $faker->unique()->randomElement(['Safe And Fresh', 'Paramount', 'Office', 'Well Gazipur', 'Well Chittagong']),
        'address' => $faker->address,
        'location' => $faker->city,
        'contact_no' => $faker->phoneNumber
    ];
});
