<?php
use Faker\Generator as Faker;
use App\Worker as Worker;
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


$factory->define(Worker::class, function (Faker $faker) {
     return [
        'name'=>$faker->firstNameMale,
        'surname'=>$faker->lastName,
        'mail'=>$faker->email,
        'sex'=>'H',
        'active'=>'1',
        'office_id'=>$faker->numberBetween($min=1,$max=7)
     ];
});

