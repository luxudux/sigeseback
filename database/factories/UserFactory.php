<?php

use App\User as User;
use Faker\Generator as Faker;
use Illuminate\Support\Facades\Hash as Hash;
/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

$factory->define(User::class, function (Faker $faker) {

    return [
        'name' => $faker->name,
        'password' => Hash::make('lumen'),
        'remember_token' => str_random(60),
        'api_token' => str_random(60),
        'active' => 'S',
        'level_id' => $faker->numberBetween($min=1,$max=2),
        'worker_id' => $faker->numberBetween($min=1,$max=7),
        
    ];
});
