<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class AgencyStationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $types = array(
            ['agency_id' => 1,'name' => 'Head Office', 'type'=>'HQ', 'code' => 'ADM','town'=>'Nairobi' ,'lat'=>'-1.0','long'=>'1.0', 'status' =>1]
            // ['agency_id' => 2,'name' => 'Customer Support Office', 'type'=>'HQ', 'code' => 'CSO','town'=>'Nairobi' ,'lat'=>'-1.0','long'=>'1.0', 'status' =>1]
        );

        foreach ($types as $type) {
            \App\Models\AgencyStation::create($type);
        }
        
    }

}
