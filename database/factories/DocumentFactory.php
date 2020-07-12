<?php
use Faker\Generator as Faker;
use App\Document as Document;
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

$factory->define(Document::class, function (Faker $faker) {
    $token=str_random(60);
    return [
        
        'subject'=>$faker->text($maxNbChars = 50) ,
        'control'=>$faker->text($maxNbChars = 30) ,
        'url'=>$faker->url,
        'expiration'=>$faker->dateTime($max = 'now', $timezone = 'America/Mexico_City'),

        'conclution_id'=>$faker->numberBetween($min=1,$max=2),
        'preference_id'=>$faker->numberBetween($min=1,$max=3),
        'office_id'=>$faker->numberBetween($min=1,$max=7),
        'user_id' => $faker->numberBetween($min=1,$max=7)  
    ];
});
