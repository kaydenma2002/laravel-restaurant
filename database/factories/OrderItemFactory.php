<?php

namespace Database\Factories;

use App\Models\Item;
use App\Models\Order;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\OrderItem>
 */
class OrderItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'order_id' => function () {
                return Order::factory()->create()->id;
            },
            'item_id' => Item::inRandomOrder()->first()->id,
            'price' => $this->faker->randomFloat(2, 1, 100),
            'quantity' => 2,
        ];
    }
}
