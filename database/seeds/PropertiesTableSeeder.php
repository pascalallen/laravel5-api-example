<?php

use Illuminate\Database\Seeder;
use App\Property;
use Faker\Provider\Address;
use Carbon\Carbon;

class PropertiesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        Property::truncate();

        $faker = \Faker\Factory::create();
    	$starts_at = Carbon::createFromTimestamp($faker->dateTimeBetween($startDate = '+2 days', $endDate = '+1 week')->getTimeStamp()) ;
		$ends_at= Carbon::createFromFormat('Y-m-d H:i:s', $starts_at)->addDays( $faker->numberBetween( 1, 8 ) );

        for ($i = 0; $i < 50; $i++) {
            Property::create([
                'name' => $faker->company,
                'address' => $faker->streetAddress,
                'city' => $faker->city,
                'state' => $faker->state,
                'zipcode' => Address::postcode(),
                'start_date' => $starts_at,
                'end_date' => $ends_at,
            ]);
        }
    }
}
