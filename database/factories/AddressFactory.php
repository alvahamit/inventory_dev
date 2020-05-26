<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Address;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(Address::class, function (Faker $faker) {
    
     
    return [
        'label'=> $faker->randomElement(['Work', 'Residence', 'Factory', 'Club']),
        'country_code'=> $faker->countryCode,
        'address'=> $faker->address,
        'area'=> $faker->streetName,
        'state'=> $faker->state,
        'city'=> $faker->city,
        'postal_code'=> $faker->postcode,
        'latitude'=> $faker->latitude,
        'longitude'=> $faker->longitude,
    ];
});

