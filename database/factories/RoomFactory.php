<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class RoomFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'description' => $this->faker->text(500),
            'x' => $this->faker->randomDigit(),
            'y' => $this->faker->randomDigit(),
        ];
    }
}
