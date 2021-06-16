<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\Store;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::statement("SET foreign_key_checks=0");
        DB::table('category_product')->truncate();
        Category::truncate();
        Store::truncate();
        Product::truncate();
        DB::statement("SET foreign_key_checks=1");

        $this->call([CategoriesTableSeeder::class]);
        \App\Models\Store::factory(10)->create();
        \App\Models\Product::factory(30)->create();

        $products = Product::all();
        foreach ($products as $product) {
            $product->categories()
                ->attach(
                    [
                        rand(1, 10)
                    ]
                );
        }
    }
}
