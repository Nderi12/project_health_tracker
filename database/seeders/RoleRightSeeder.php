<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class RoleRightSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $accesses = explode(",",env("AGENCY_USER_RIGHTS").",".env("AGENCY_ROLE_RIGHTS"));
        foreach ($accesses as $access) {
            \App\Models\RoleRight::create(['agency_id' => 1, 'agency_role_id' => 1, 'access' => $access, 'status' => 1, 'created_by' => 1, 'updated_by' => 1]);
        }

    }

}
