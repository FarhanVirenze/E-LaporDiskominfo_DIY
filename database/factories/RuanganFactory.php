<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class RuanganFactory extends Factory
{
    public function definition(): array
    {
        return [
            'nm_ruangan' => $this->faker->word(),
            'lokasi' => $this->faker->address(),
            'kapasitas' => $this->faker->numberBetween(5, 50),
        ];
    }
}
