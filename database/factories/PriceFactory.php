<?php

namespace Database\Factories;

use App\Models\Price;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class PriceFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Price::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'date' => $this->faker->date(),
            'price' => $this->faker->randomNumber(2),
            'crop_id' => \App\Models\Crop::factory(),
        ];
    }
}
