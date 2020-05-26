<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\MoneyReceipt;
use Faker\Generator as Faker;

$factory->define(MoneyReceipt::class, function (Faker $faker) {
    return [
        'mr_date' => $faker->date(),
        'mr_no' => $faker->unique()->ean8,
        'customer_id' => $faker->numberBetween(4,10),
        'customer_name' => $faker->name,
        'customer_company' => $faker->company,
        'customer_address' => $faker->address,
        'customer_phone' => $faker->phoneNumber,
        'customer_email' => $faker->email,
        'amount' => $faker->numberBetween(1500, 25000),
        'pay_mode' => 'cheque',
        'cheque_no' => $faker->unique()->randomNumber(6),
        'bank_name' => $faker->company,
    ];
});
