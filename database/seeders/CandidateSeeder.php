<?php

namespace Database\Seeders;

use App\Models\Candidate;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;

class CandidateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();
        
        for ($i = 0; $i < 100; $i++) {
            Candidate::create([
                'first_name' => $faker->firstName(),
                'last_name' => $faker->lastName(),
                'email' => $faker->unique()->safeEmail(),
                'phone_number' => $faker->phoneNumber(),
                'id_number' => $faker->numerify('########'),
                'gender' => $faker->randomElement(['MALE', 'FEMALE']),
            ]);
        }
    }
}
