<?php

namespace Database\Seeders;

use App\Models\Country;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //  Get the countries.
        $countries = json_decode(file_get_contents(
            database_path('data/json/countries.json')
        ));

        //  Loop through each of the countries
        foreach ($countries as $country) {
            //  Get the counties
            $counties = $country->counties;
            $country = Country::create([
                'name' => $country->name,
            ]);

            //  Get the counties that belong to the county
            foreach ($counties as $county) {
                $country->counties()->create([
                    'name' => $county,
                ]);
            }
        }
    }
}
