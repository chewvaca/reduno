<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class LocalizacionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            //
            'email' =>$this->faker->safeEmail(),
            'telefono'=>$this->faker->phoneNumber(),
            'direccion'=>$this->faker->address()
        ];
    }
}
