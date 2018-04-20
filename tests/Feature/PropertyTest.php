<?php

namespace Tests\Feature;

use App\Property;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Faker\Provider\Address;
use Illuminate\Support\Carbon;

class PropertyTest extends TestCase
{
    public function testsPropertiesAreCreatedCorrectly()
    {
    	$faker = \Faker\Factory::create();
    	$starts_at = Carbon::createFromTimestamp($faker->dateTimeBetween($startDate = '+2 days', $endDate = '+1 week')->getTimeStamp()) ;
		$ends_at = Carbon::createFromFormat('Y-m-d H:i:s', $starts_at)->addDays( $faker->numberBetween( 1, 8 ) );
        $user = factory(User::class)->create();
        $token = $user->generateToken();
        $headers = ['Authorization' => "Bearer $token"];
        $payload = [
            'name' => $faker->company,
            'address' => $faker->streetAddress,
            'city' => $faker->city,
            'state' => $faker->state,
            'zipcode' => Address::postcode(),
            'start_date' => $starts_at,
            'end_date' => $ends_at,
        ];

        $this->json('POST', '/api/properties', $payload, $headers)
            ->assertStatus(200)
            ->assertJson([ 
	        	'id' => 1, 
	        	'name' => $faker->company,
	            'address' => $faker->streetAddress,
	            'city' => $faker->city,
	            'state' => $faker->state,
	            'zipcode' => Address::postcode(),
	            'start_date' => $starts_at,
	            'end_date' => $ends_at, ]
        	);
    }
}
