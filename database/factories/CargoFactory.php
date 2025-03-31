<?php

namespace Database\Factories;

use App\Models\Cargo;
use Illuminate\Database\Eloquent\Factories\Factory;

class CargoFactory extends Factory
{
    protected $model = Cargo::class;

    public function definition()
    {
        return [
            'nombre' => $this->faker->jobTitle,
        ];
    }
}
