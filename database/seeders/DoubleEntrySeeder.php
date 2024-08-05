<?php

namespace Database\Seeders;

use App\Models\DoubleEntryAccount;
use App\Models\DoubleEntryClass;
use App\Models\DoubleEntryType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DoubleEntrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get the classes.
        $classes = json_decode(file_get_contents(
            database_path('data/json/accounting/classes.json')
        ));

        // Get the types.
        $types = json_decode(file_get_contents(
            database_path('data/json/accounting/types.json')
        ));

        // Get the accounts.
        $accounts = json_decode(file_get_contents(
            database_path('data/json/accounting/accounts.json')
        ));

        foreach ($classes as $class) {
            DoubleEntryClass::create([
                'name' => $class->name,
            ]);
        }

        foreach ($types as $type) {
            DoubleEntryType::create([
                'name' => $type->name,
                'class_id' => $type->class_id,
            ]);
        }

        foreach ($accounts as $account) {
            DoubleEntryAccount::create([
                'company_id' => 1,
                'name' => $account->name,
                'code' => $account->code,
                'type_id' => $account->type_id,
            ]);
        }
    }
}
