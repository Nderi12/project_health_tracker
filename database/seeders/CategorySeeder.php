<?php

namespace Database\Seeders;

use App\Models\Category;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        $categories = json_decode(file_get_contents(
            database_path('data/json/product_categories.json')
        ));

        foreach ($categories as $category) {
            Category::create([
                'name' => $category->name,
                'type' => $category->type,
                'color' => $faker->unique()->colorName()
            ]);
        }
    }
}
