<?php

use Illuminate\Database\Seeder;

class InformationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('informations')->insert([
        	'comments_en' 		=> 'Comment1',
        	'open_date' 	=> '2016-05-01',
        	'close_date'  	=> '2016-05-29'
        ]);
        DB::table('informations')->insert([
        	'comments_en' 		=> 'Comment2',
        	'open_date' 	=> '2016-05-01',
        	'close_date'  	=> '2016-05-29'
        ]);
        DB::table('informations')->insert([
        	'comments_en' 		=> 'Comment3',
        	'open_date' 	=> '2016-04-01',
        	'close_date'  	=> '2016-04-29'
        ]);
        DB::table('informations')->insert([
        	'comments_en' 		=> 'Comment4',
        	'open_date' 	=> '2016-04-01',
        	'close_date'  	=> '2016-04-25'
        ]);
    }
}
