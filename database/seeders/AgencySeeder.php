<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class AgencySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $types = array(
            ['name' => 'Admin Team','agency_code' => 'ADM','description' => 'Admin Team','agency_type' => 1,'status' => 1,'created_by' => 1,'updated_by' => 1 ]
            // ['name' => 'Corporate Partners','agency_code' => 'CS','description' => 'Corporate Partners','agency_type' => 2,'status' => 1,'created_by' => 1,'updated_by' => 1 ]
        );
        foreach ($types as $type) {
            \App\Models\Agency::create($type);
        }

    }

}
