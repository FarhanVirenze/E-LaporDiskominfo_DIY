<?php

namespace Database\Factories;

use App\Models\Notif;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class NotifFactory extends Factory
{
    protected $model = Notif::class;

    public function definition()
    {
        return [
            'id_user' => User::factory(),
            'jenis_notif' => $this->faker->randomElement(['info', 'peringatan', 'pengingat']),
            'keterangan' => $this->faker->sentence(),
            'status' => 'belum terbaca',
            'tanggal' => $this->faker->date(),
            'waktu' => $this->faker->time(),
        ];
    }
}
