<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;   // <== Import model User di sini
use App\Models\Ruangan; // opsional, kalau pakai factory Ruangan

class RuanganControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_create_ruangan()
    {
        $admin = User::factory()->create(['role' => 'admin']); // sekarang User dikenali
        $this->actingAs($admin);

        $response = $this->post(route('ruangans.store'), [
            'nm_ruangan' => 'Aula 1',
            'lokasi' => 'Gedung A',
            'kapasitas' => 20,
        ]);

        $response->assertRedirect(route('ruangans.index'));
        $this->assertDatabaseHas('ruangans', ['nm_ruangan' => 'Aula 1']);
    }
}
