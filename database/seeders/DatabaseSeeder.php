<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\ExpenseItem;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        $this->call([
            AgencyTypeSeeder::class,
            AgencySeeder::class,
            AgencyUserSeeder::class,
            AgencyRoleSeeder::class,
            AgencyStationSeeder::class,
            RoleRightSeeder::class,
            SettingSeeder::class,
            UserSeeder::class,
        ]);
    }
}
