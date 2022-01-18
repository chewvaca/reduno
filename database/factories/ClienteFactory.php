<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ClienteFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'dni'=>$this->faker->unique()->numberBetween(1000000,99999999),
            'nombre'=>$this->faker->name(),
            //
        ];
    }
}
