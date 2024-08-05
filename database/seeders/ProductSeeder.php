<?php

namespace Database\Seeders;

use App\Models\Item;
use App\Models\ItemWarehouse;
use App\Models\SerialNumber;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $products = json_decode(file_get_contents(
            database_path('data/json/products.json')
        ));

        //  Loop through all the products
        foreach ($products as $product) {
            $item = Item::create([
                'name' => $product->name,
                'purchase_price' => $product->purchase_price,
                'sale_price' => $product->sale_price,
                'category_id' => $product->category_id,
                'type' => $product->type,
            ]);

            ItemWarehouse::create([
                'item_id' => $item->id,
                'warehouse_id' => 1,
                'quantity' => $product->quantity,
                'reorder_level' => 5
            ]);

            SerialNumber::factory()->count(10)->create([
                'item_id' => $item->id
            ]);
        }
    }
}
