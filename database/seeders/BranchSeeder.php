<?php

namespace Database\Seeders;

use App\Models\Branch;
use App\Models\BranchWarehouse;
use App\Models\Warehouse;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BranchSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $branches = json_decode(file_get_contents(
            database_path('data/json/branches.json')
        ));

        //  Loop through all the branches
        foreach ($branches as $branch) {
            $branch = Branch::create([
                'name' => $branch->name,
                'phone_number' => $branch->phone_number
            ]);

            // create a new warehouse to the new branch
            $warehouse = Warehouse::create([
                'name' => $branch->name.' '.'warehouse',
                'phone_number' => $branch->phone_number
            ]);

            BranchWarehouse::create([
                'branch_id' => $branch->id,
                'warehouse_id' => $warehouse->id
            ]);
        }

        // Create a solo main warehouse
        Warehouse::create([
            'name' => 'Kikuyu Main Warehouse',
            'phone_number' => '254788991100'
        ]);
    }
}
