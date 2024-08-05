<?php

namespace Database\Seeders;

use App\Models\Job;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;

class JobSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();
        
        for ($i = 0; $i < 100; $i++) {
            Job::create([
                'title' => $faker->jobTitle,
                'country' => $faker->country,
                'city' => $faker->city,
                'description' => $faker->paragraph,
                'reference_number' => sprintf('REFNO-%03d', $i),
                'responsibilities' => $faker->paragraph,
                'qualifications' => $faker->paragraph,
                'available_openings' => $faker->numberBetween(1, 10),
                'gender' => $faker->randomElement(['MALE', 'FEMALE', 'BOTH']),
                'offered_salary' => $faker->numberBetween(500, 5000) . ' USD',
                'career_level' => $faker->randomElement(['Entry Level', 'Mid Level', 'Senior Level']),
                'experience_length' => $faker->randomElement(['0-1 years', '1-3 years', '3-5 years', '5+ years']),
                'academic_qualification' => $faker->randomElement(['High School', 'Bachelor Degree', 'Master Degree', 'PhD']),
                'status' => $faker->numberBetween(0, 1),
                'application_deadline' => $faker->dateTimeBetween('+1 week', '+2 months')->format('Y-m-d H:i:s')
            ]);
        }
    }
}
