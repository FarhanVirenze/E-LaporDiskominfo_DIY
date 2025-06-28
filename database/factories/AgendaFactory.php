<?php

namespace Database\Factories;

use App\Models\Agenda;
use App\Models\User;
use App\Models\Ruangan;
use Illuminate\Database\Eloquent\Factories\Factory;

class AgendaFactory extends Factory
{
    protected $model = Agenda::class;

    public function definition(): array
    {
        return [
            'id_user' => User::factory(),
            'id_ruangan' => Ruangan::factory(),
            'nm_agenda' => $this->faker->sentence(3),
            'tanggal' => $this->faker->date(),
            'waktu' => $this->faker->time(),
            'deskripsi' => $this->faker->paragraph(),
            'id_pic' => User::factory(),
            'status' => 'diajukan',
        ];
    }
}
