<?php
use Faker\Generator as Faker;
use App\OfficeUser as OfficeUser;
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

$factory->define(OfficeUser::class, function (Faker $faker) {
    $token=str_random(60);
    return [
        
        'office_id'=>$faker->numberBetween($min=1,$max=5),
        'user_id'=>$faker->numberBetween($min=1,$max=7)
        
    ];
});
