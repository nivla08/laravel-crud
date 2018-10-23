<?php

use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(App\Models\User::class, function (Faker $faker) {

    return [
        'username'        => $faker->username,
        'first_name'      => $faker->firstname,
        'last_name'       => $faker->lastname,
        'email'           => $faker->unique()->safeEmail,
        'password'        => bcrypt('secret'), // secret
        'remember_token'  => str_random(10),
        'activated'       => $faker->boolean($chanceOfGettingTrue = 90),
        'created_at'      => $faker->dateTimeBetween(
                                    $startDate = '-1 years', $endDate = 'now'),
        'updated_at'      => $faker->dateTimeBetween(
                                    $startDate = '-1 years', $endDate = 'now'),
    ];

});
