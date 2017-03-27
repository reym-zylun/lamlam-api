<?php

use Illuminate\Database\Seeder;

class TicketSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        \DB::table('tickets')->insert([
            'name_ja'           => '$B#1F|%A%1%C%H(B',
            'name_en'           => '1 day ticket',
            'description_ja'    => '$B#1F|4VM-8z$J%A%1%C%H$G$9!#(B',
            'description_en'    => 'This ticket is available for 1 day.',
            'image_url'         => env('WEB_URL').'/images/tickets/oneday.png',
            'adult_price'       => '10.00',
            'child_price'       => null,
            'type'              => 'day',
            'duration'          => 1,
            'color'             => 'green',
            'recommended'       => 0,
            'valid'             => true
        ]);
        \DB::table('tickets')->insert([
            'name_ja'           => '$B#2F|%A%1%C%H(B',
            'name_en'           => '2 days ticket',
            'description_ja'    => '$B#2F|4VM-8z$J%A%1%C%H$G$9!#(B',
            'description_en'    => 'This ticket is available for 2 days.',
            'image_url'         => env('WEB_URL').'/images/tickets/twodays.png',
            'adult_price'       => '15.00',
            'child_price'       => null,
            'type'              => 'day',
            'duration'          => 2,
            'color'             => 'yellow',
            'recommended'       => 0,
            'valid'             => true
        ]);
        \DB::table('tickets')->insert([
            'name_ja'           => '$B#5F|%A%1%C%H(B',
            'name_en'           => '5 days ticket',
            'description_ja'    => '$B#5F|4VM-8z$J%A%1%C%H$G$9!#(B',
            'description_en'    => 'This ticket is available for 5 days.',
            'image_url'         => env('WEB_URL').'/images/tickets/fivedays.png',
            'adult_price'       => '25.00',
            'child_price'       => '13.00',
            'type'              => 'day',
            'duration'          => 5,
            'color'             => 'yellow',
            'recommended'       => 0,
            'valid'             => true
        ]);
        \DB::table('tickets')->insert([
            'name_ja'           => '$B#1;~4V%A%1%C%H(B',
            'name_en'           => '1 hour ticket',
            'description_ja'    => '$B#1;~4VM-8z$J%A%1%C%H$G$9!#(B',
            'description_en'    => 'This ticket is available for 1 hour.',
            'image_url'         => env('WEB_URL').'/images/tickets/timepass.png',
            'adult_price'       => null,
            'child_price'       => null,
            'type'              => 'time',
            'duration'          => 1,
            'color'             => 'green',
            'recommended'       => 0,
            'valid'             => true
        ]);
        \DB::table('tickets')->insert([
            'name_ja'           => '$B#3;~4V%A%1%C%H(B',
            'name_en'           => '3 hours ticket',
            'description_ja'    => '$B#3;~4VM-8z$J%A%1%C%H$G$9!#(B',
            'description_en'    => 'This ticket is available for 3 hours.',
            'image_url'         => env('WEB_URL').'/images/tickets/timepass.png',
            'adult_price'       => 3,
            'child_price'       => null,
            'type'              => 'time',
            'duration'          => 3,
            'color'             => 'yellow',
            'recommended'       => 0,
            'valid'             => true
        ]);
        \DB::table('tickets')->insert([
            'name_ja'           => '$B#6;~4V%A%1%C%H(B',
            'name_en'           => '6 hours ticket',
            'description_ja'    => '$B#6;~4VM-8z$J%A%1%C%H$G$9!#(B',
            'description_en'    => 'This ticket is available for 6 hours.',
            'image_url'         => env('WEB_URL').'/images/tickets/timepass.png',
            'adult_price'       => 6,
            'child_price'       => null,
            'type'              => 'time',
            'duration'          => 6,
            'color'             => 'blue',
            'recommended'       => 1,
            'valid'             => true
        ]);
    }
}
