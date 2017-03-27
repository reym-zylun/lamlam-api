<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UserTableSeeder::class);
        $this->call(ApiClientSeeder::class);
        $this->call(TicketSeeder::class);
        $this->call(InformationSeeder::class);
        $this->call(DestinationSeeder::class);
        // $this->call(BusRouteSeeder::class);
        $this->call(BusCourseSeeder::class);
        $this->call(BusStopSeeder::class);
    }
}
