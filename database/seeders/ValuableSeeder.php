<?php

namespace Database\Seeders;

use App\Models\asset;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ValuableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $valuables = json_decode(file_get_contents(
            database_path('data/json/valuables.json')
        ));

        //  Loop through all the assets
        foreach ($valuables as $valuable) {
            Asset::create([
                'name' => $valuable->name,
                'code' => $valuable ->code,
                'description' => $valuable->description,
                'quantity' => $valuable->quantity,
                'purchase_cost' => $valuable->purchase_cost,
                'purchase_date' => $valuable->purchase_date
            ]);
        }
    }
}
