<?php

use Illuminate\Database\Seeder;
use App\Reservation;
use Carbon\Carbon;

class ReservationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Reservation::truncate();

        $faker = \Faker\Factory::create();
    	$starts_at = Carbon::createFromTimestamp($faker->dateTimeBetween($startDate = '+2 days', $endDate = '+1 week')->getTimeStamp());
		$ends_at= Carbon::createFromFormat('Y-m-d H:i:s', $starts_at)->addDays( $faker->numberBetween( 1, 8 ) );

        for ($i = 0; $i < 50; $i++) {
            Reservation::create([
                'first_name' => $faker->firstName,
                'last_name' => $faker->lastName,
                'email' => $faker->email,
                'phone_number' => $faker->tollFreePhoneNumber,
                'start_date' => $starts_at,
                'end_date' => $ends_at,
                'property_id' => rand(1,50),
            ]);
        }
    }
}
