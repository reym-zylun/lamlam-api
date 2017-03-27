<?php

use Illuminate\Database\Seeder;

class BusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('busses')->insert([
            'id'     => 1,
            'color'  => 'Blue',
            'name'   => 'TUMON SHUTTLE NORTH BOUND',
        ]);
        DB::table('busses')->insert([
            'id'     => 2,
            'color'  => 'Green',
            'name'   => 'TUMON SHUTTLE SOUTH BOUND',
        ]);
        DB::table('busses')->insert([
            'id'     => 3,
            'color'  => 'Red',
            'name'   => 'SHOPPING MALL SHUTTLE',
        ]);
        DB::table('busses')->insert([
            'id'     => 4,
            'color'  => 'DeepGreen',
            'name'   => 'T Galleria K-Mart Shuttle',
        ]);
        DB::table('busses')->insert([
            'id'     => 5,
            'color'  => 'DeepBlue',
            'name'   => 'GPO Leo Palace Shuttle',
        ]);
        DB::table('busses')->insert([
            'id'     => 6,
            'color'  => 'Pink',
            'name'   => 'Two Lovers Point Shuttle',
        ]);
        DB::table('busses')->insert([
            'id'     => 7,
            'color'  => 'Yellow',
            'name'   => 'Hagatna Shuttle Bus',
        ]);
        DB::table('busses')->insert([
            'id'     => 8,
            'color'  => 'Purple',
            'name'   => 'Chamorro Village Night Shuttle',
        ]);
        DB::table('busses')->insert([
            'id'     => 9,
            'color'  => 'LightBlue',
            'name'   => 'Flea Market Shuttle',
        ]);
    }

}
