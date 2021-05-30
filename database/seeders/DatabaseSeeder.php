<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        //\App\Models\User::factory(3)->create();
        \App\Models\Product::factory(15)->create();
        // \App\Models\Category::factory(5)->create();
       // $this->call([CategoriesTableSeeder::class]);
        $products = Product::all();
        foreach ($products as $product) {
            $product->categories()
                ->attach([
                    rand(1, 10)
                ]);
        }
    }
}
