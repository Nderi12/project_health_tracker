<?php

namespace Database\Seeders;

use App\Models\CarModel;
use App\Models\Make;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MakeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $makes = json_decode(file_get_contents(
            database_path('data/json/car-models.json')
        ));

        //  Loop through all the makes
        foreach ($makes as $make) {
            $newMake = Make::create([
                'company_id' => 1,
                'name' => $make->brand,
                'status' => 1
            ]);

            foreach ($make->models as $model) {
                CarModel::create([
                    'company_id' => 1,
                    'name' => $model,
                    'year' => '2000',
                    'make_id' => $newMake->id,
                    'status' => 1
                ]);
            }
        }
    }
}
