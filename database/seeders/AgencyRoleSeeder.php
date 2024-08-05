<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class AgencyRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $types = array(
            ['agency_id' => 1,'title' => 'Admin','description' => 'Admin','status' => 1,'created_by' => 1,'updated_by' => 1 ]
            // ['agency_id' => 2,'title' => 'Admin','description' => 'Admin','status' => 1,'created_by' => 1,'updated_by' => 1 ]
        );
        foreach ($types as $type) {
            \App\Models\AgencyRole::create($type);
        }

    }
}
