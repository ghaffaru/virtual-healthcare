<?php

use App\User;
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
        //
        App\User::create(['name' => 'sammy', 'email' => 'sammy@gmail.com', 'password' => Hash::make('12345678'), 'region' => 'accra', 'residence' => 'accra', 'phone' => '52154126523', 'date_of_birth' => '2019-11-10']);

    }
}
