<?php

namespace Database\Seeders;

use App\Models\Item;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ExpenseItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = json_decode(file_get_contents(
            database_path('data/json/expenses.json')
        ));

        //  Loop through all the products
        foreach ($products as $product) {
            Item::create([
                'name' => $product->name,
                'purchase_price' => $product->purchase_price,
                'sale_price' => $product->sale_price,
                'category_id' => $product->category_id,
                'type' => $product->type,
            ]);
        }
    }
}
