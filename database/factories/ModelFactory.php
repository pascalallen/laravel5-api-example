<?php
use Faker\Provider\Address;
use Illuminate\Support\Carbon;
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

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\User::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
    ];
});

$starts_at = Carbon::createFromTimestamp($faker->dateTimeBetween($startDate = '+2 days', $endDate = '+1 week')->getTimeStamp()) ;
$ends_at= Carbon::createFromFormat('Y-m-d H:i:s', $starts_at)->addDays( $faker->numberBetween( 1, 8 ) );
$factory->define(App\Property::class, function (Faker\Generator $faker) {

    return [
        'name' => $faker->company,
        'address' => $faker->streetAddress,
        'city' => $faker->city,
        'state' => $faker->state,
        'zipcode' => Address::postcode(),
        'start_date' => $starts_at,
        'end_date' => $ends_at,
    ];
});