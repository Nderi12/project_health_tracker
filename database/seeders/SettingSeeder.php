<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::transaction(function () {

            //  Get the services from the included .json file
            $settings = json_decode(file_get_contents(
                database_path('data/json/settings.json')
            ));

            //  Loop through all the setting keys
            foreach ($settings as $settingKey) {
                //  Create a service
                $data = Arr::except((array) $settingKey, ['values']);
                $setting = Setting::create( (array) $data);

                //  Create setting value
                foreach ($settingKey->values as $settingValue) {
                    $value = $setting->values()->create([
                        'name' => $settingValue->name,
                    ]);
                }
            }
        });
    }
}
