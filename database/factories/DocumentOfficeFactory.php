<?php
use Faker\Generator as Faker;
use App\DocumentOffice as DocumentOffice;
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

$factory->define(DocumentOffice::class, function (Faker $faker) {
    $token=str_random(60);
    return [
        
        'document_id'=>$faker->numberBetween($min=1,$max=2),
        'office_id'=>$faker->numberBetween($min=1,$max=7)
        
    ];
});
