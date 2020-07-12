<?php
use Faker\Generator as Faker;
use App\Contact as Contact;
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

$factory->define(Contact::class, function (Faker $faker) {
    $token=str_random(60);
    return [
        'name'=>$faker->firstNameMale,
        'surname'=>$faker->lastName,
        'city' => $faker->city,
        'phone_p' => $faker->e164PhoneNumber,
        'phone_s' => $faker->e164PhoneNumber,
        'sex' => 'H',
        'mail'=>$faker->email,
        'institution'=>$faker->company,
        'office_id'=>$faker->numberBetween($min=1,$max=7),
        'user_id' => $faker->unique()->numberBetween($min=1,$max=7),  
    ];
});
