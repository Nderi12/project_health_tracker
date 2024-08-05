<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Carbon\Carbon;
use Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = array(
            [
                'first_name' => 'Admin',
                'last_name' => 'User',
                'email' => env('INITIAL_ADMIN_EMAIL'),
                'phone_number' => '070000000',
                'password' => Hash::make(env('INITIAL_ADMIN_PASSWORD')),
                'email_verified_at' => Carbon::now(),
                'status' => 1 
            ]
        );
        foreach ($users as $user) {
            \App\Models\User::create($user);
        }

    }

}
