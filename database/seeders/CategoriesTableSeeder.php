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
        Category::create([
            'name' => 'Desktop Computers',
            'slug' => 'desktop-pc',
            'parent_id' =>   1
        ]);
        Category::create([
            'name' => 'Laptops',
            'slug' => 'laptops',
            'parent_id' => 1
        ]);
        Category::create([
            'name' => 'Smartphones',
            'slug' => 'smartphones',
            'parent_id' => 1
        ]);
        Category::create([
            'name' => 'Tablets',
            'slug' => 'tablets',
            'parent_id' => 1
        ]);

        Category::create([
            'name' => 'Science books',
            'slug' => 'science-books',
            'parent_id' => '2'
        ]);
        Category::create([
            'name' => 'Litterature',
            'slug' => 'litterature',
            'parent_id' => '2'
        ]);
        Category::create([
            'name' => 'Men\'s fashion',
            'slug' => 'men-fashion',
            'parent_id' => 3
        ]);
        Category::create([
            'name' => 'Women\'s fashion',
            'slug' => 'women-fashion',
            'parent_id' => 3
        ]);
    }
}
