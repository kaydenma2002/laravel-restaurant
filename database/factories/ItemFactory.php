<?php

namespace Database\Factories;
use Illuminate\Support\Arr;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Item;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Item>
 */
class ItemFactory extends Factory
{
    protected $model = Item::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $productSuffixes = ['Pho','Hu tieu','Banh canh','Banh bot loc','Bun bo Hue','Chao','Soup cua','Mi Y'];
        return [
            'name' => Arr::random($productSuffixes),
            'description' => fake()->realText(320),
            'price' => fake()->numberBetween(5,50),
        ];
    }
}
