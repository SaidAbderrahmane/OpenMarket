<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Product::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->unique()->sentence(1),
            'slug' => $this->faker->slug,    
            'subtitle' => $this->faker->sentence(2),    
            'description' => $this->faker->text,
            'price' => $this->faker->numberBetween(15,300)*100,    
            'stock' => $this->faker->numberBetween(1,20),    
            'image' => 'products/'.$this->faker->image('public/storage/products',640,480, null, false),
            
        ];
        
    }
}
