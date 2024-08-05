<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class AgencyTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $types = array(
            ['name' => 'Admins Group','description' => 'Admins Group','status' => 1 ]
            // ['name' => 'Users Group','description' => 'Users Group','status' => 1 ]
        );
        foreach ($types as $type) {
            \App\Models\AgencyType::create($type);
        }

    }

}
