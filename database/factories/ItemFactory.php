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
        $this->faker->addProvider(new \FakerRestaurant\Provider\vi_VN\Restaurant($this->faker));
        $this->faker->addProvider(new \Xvladqt\Faker\LoremFlickrProvider($this->faker));

        $food_name = $this->faker->foodName();
        $beverage_name = $this->faker->beverageName();
        $vegetable_name = $this->faker->vegetableName();
        $meat_name = $this->faker->meatName();
        $random_arr = Arr::random([$food_name,$beverage_name,$vegetable_name,$meat_name]);
        if($random_arr == $food_name){
            if($food_name == 'Phở'){
                $image = $this->faker->imageUrl(640,480,['ricenoodle'],null);
            }else{
                $image = $this->faker->imageUrl($width = 640, $height = 480,['noodle']);
            }
            $food_type = '0';
        }elseif($random_arr == $beverage_name){
            $image = $this->faker->imageUrl($width = 640, $height = 480,['coke']);
            $food_type = '2';
        }else{
            $image = $this->faker->imageUrl($width = 640, $height = 480,['pudding']);
            $food_type = '1';
        }
        return [
            'name' => $random_arr,
            'food_type' => $food_type,
            'description' => fake()->realText(40),
            'price' => fake()->numberBetween(5,50),
            'image' => $image
        ];
    }
}
