<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class AgencyUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $types = array(
            ['user_id' => 1,'agency_id' => 1,'agency_role_id' => 1,'agency_station_id' => 1,'status' => 1,'created_by' => 1,'updated_by' => 1 ]
            // ['user_id' => 1,'agency_id' => 2,'agency_role_id' => 2,'agency_station_id' => 2,'status' => 1,'created_by' => 1,'updated_by' => 1 ]
        );
        foreach ($types as $type) {
            \App\Models\AgencyUser::create($type);
        }
        
    }
}
