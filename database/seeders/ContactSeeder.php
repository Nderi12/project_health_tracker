<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Customer;
use Faker\Factory as Faker;

class ContactSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        // An array of possible contact types
        $contactTypes = ['customer', 'business', 'supplier'];

        // Generate 200 contacts
        for ($i = 0; $i < 70; $i++) {
            // Randomly select a contact type
            $type = $contactTypes[array_rand($contactTypes)];

            // Create a customer record with the selected type
            Customer::create([
                'uuid' => $faker->uuid,
                'company_id' => $faker->randomNumber(5),
                'type' => $type,
                'name' => $faker->name,
                'email' => $faker->unique()->safeEmail,
                'tax_number' => $faker->randomNumber(6),
                'phone' => $faker->phoneNumber,
                'address' => $faker->address,
                'website' => $faker->url,
                'currency_code' => $faker->currencyCode,
                'created_by' => $faker->randomNumber(5),
                // 'isBusiness' => $type === 'business',
            ]);
        }
    }
}
