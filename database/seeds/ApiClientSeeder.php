<?php

use Illuminate\Database\Seeder;

class ApiClientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('api_clients')->insert([
            'name'              => 'client_web',
            'platform_type'     => 'web',
            'secret'            => 'secret_web',
            'valid'             => true
        ]);
        DB::table('api_clients')->insert([
            'name'              => 'client_ios',
            'platform_type'     => 'ios',
            'secret'            => 'secret_ios',
            'valid'             => true
        ]);
        DB::table('api_clients')->insert([
            'name'              => 'client_android',
            'platform_type'     => 'android',
            'secret'            => 'secret_android',
            'valid'             => true
        ]);
    }
}
