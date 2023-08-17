<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use App\Models\Restaurant;
use App\Models\OrderItem;
use App\Models\Order;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $startDate = $this->faker->dateTimeBetween('2023-01-01', 'now');
        $endDate = time();
        return [
            
            'user_id' => User::inRandomOrder()->first()->id,
            'restaurant_id' => Restaurant::inRandomOrder()->first()->restaurant_id,
            'created_at' => $this->faker->dateTimeBetween($startDate, $endDate, 'UTC')->format('Y-m-d H:i:s'),
        ];
    }
    public function configure()
    {
        return $this->afterCreating(function (Order $order) {
            // Calculate the total based on the associated order items
            $total = $order->orderItems->sum(function (OrderItem $item) {
                return $item->quantity * $item->price;
            });

            // Update the 'total' attribute for the order
            $order->total = $total;
            $order->save();
        });
    }
}
