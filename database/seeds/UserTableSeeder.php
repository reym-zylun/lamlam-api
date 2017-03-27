<?php

use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name'     => 'rei',
            'email'    => 'rei@email.com',
            'password' => bcrypt('1234'),
            'valid'    => true
        ]);
        DB::table('users')->insert([
            'name'     => 'admin',
            'email'    => 'admin@email.com',
            'password' => bcrypt('1234'),
            'valid'    => true
        ]);
        // for ($i=1; $i < 30; $i++) { 
        //     DB::table('users')->insert([
        //         'name'      => 'user'.$i,
        //         'email'     => 'user'.$i.'@email.com',
        //         'password'  => bcrypt('1234'),
        //         'role'      => 'user',
        //         'valid'     => true
        //     ]);
        // }
    }
}
