<?php

namespace Database\Factories;

use App\Models\Crop;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class CropFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Crop::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->text(255),
            'description' => $this->faker->text(),
            'market_id' => \App\Models\Market::factory(),
        ];
    }
}
