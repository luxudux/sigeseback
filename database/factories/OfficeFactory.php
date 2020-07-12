<?php
use Faker\Generator as Faker;
use App\Office as Office;
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

$factory->define(Office::class, function (Faker $faker) {
     return [
        'name'=>$faker->name,
        'acronym'=>strtoupper (str_random(6)),
        'code'=>$faker->text($maxNbChars = 10),
        'mail'=>$faker->email,
        'delegation_id'=>$faker->numberBetween($min=1,$max=5)
     ];
});

