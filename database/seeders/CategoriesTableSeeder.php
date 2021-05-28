<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Category::create([
            'name' => 'High tech',
            'slug' => 'high-tech'
        ]);
        Category::create([
            'name' => 'Books',
            'slug' => 'books'
        ]);
        Category::create([
            'name' => 'Fashion',
            'slug' => 'fashion'
        ]);
    }
}
