<?php

namespace Database\Seeders;

use App\Models\ServiceType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ServiceTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::transaction(function () {

            //  Get the services from the included .json file
            $types = json_decode(file_get_contents(
                database_path('data/json/service_types.json')
            ));

            //  Loop through all the service types
            foreach ($types as $type) {
                ServiceType::create([
                    'name' => $type->name,
                ]);
            }
        });
    }
}
