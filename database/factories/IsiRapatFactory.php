<?php

namespace Database\Factories;

use App\Models\IsiRapat;
use App\Models\Agenda;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class IsiRapatFactory extends Factory
{
    protected $model = IsiRapat::class;

    public function definition()
    {
        return [
            'id_user' => User::factory(),      // Buat user baru
            'id_agenda' => Agenda::factory(), // Buat agenda baru
            'pembahasan' => $this->faker->paragraph(),
            'status' => 'open',                // Default status open
        ];
    }
}
