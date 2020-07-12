<?php
use Faker\Generator as Faker;
use App\Call as Call;
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

$factory->define(Call::class, function (Faker $faker) {
    $token=str_random(60);
    return [
        
        'note'=>$faker->text($maxNbChars = 200) ,
        'day'=>$faker->dateTime($max = 'now', $timezone = 'America/Mexico_City'),
        'contact_id'=>$faker->numberBetween($min=1,$max=7),
        'user_id' => $faker->numberBetween($min=1,$max=3),  
        'office_id' => $faker->numberBetween($min=1,$max=7) 
        
    ];
});
