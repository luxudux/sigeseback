<?php
use Faker\Generator as Faker;
use App\Event as Event;
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

$factory->define(Event::class, function (Faker $faker) {
     return [
        'title'=>$faker->text($maxNbChars = 50),
        'description'=>$faker->text($maxNbChars = 100),
        'start'=>$faker->dateTime($max = 'now', $timezone = 'America/Mexico_City'),
        'end'=>$faker->dateTime($max = 'now', $timezone = 'America/Mexico_City'),
        'preference_id' => $faker->numberBetween($min=1,$max=3),  
        'office_id' => $faker->numberBetween($min=1,$max=7),  
        'user_id' => $faker->numberBetween($min=1,$max=7)
     ];
});

