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
            'title' => $this->faker->sentence(1),
            'slug' => $this->faker->slug,    
            'subtitle' => $this->faker->sentence(2),    
            'description' => $this->faker->text,
            'price' => $this->faker->numberBetween(15,300)*100,    
            'image' => "https://via.placeholder.com/350x150"
        ];
    }
}
