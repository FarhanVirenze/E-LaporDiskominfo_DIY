<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Agenda;
use App\Models\Ruangan;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AgendaControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_view_agenda_list()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $this->actingAs($admin);

        $response = $this->get(route('agendas.index'));
        $response->assertStatus(200);
    }

    public function test_admin_can_create_agenda()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $ruangan = Ruangan::factory()->create();

        $this->actingAs($admin);
        $response = $this->post(route('agendas.store'), [
            'nm_agenda' => 'Rapat A',
            'tanggal' => now()->toDateString(),
            'waktu' => '10:00',
            'id_ruangan' => $ruangan->id_ruangan,
        ]);

        $response->assertRedirect(route('agendas.index'));
        $this->assertDatabaseHas('agendas', ['nm_agenda' => 'Rapat A']);
    }

    public function test_pimpinan_can_approve_agenda()
    {
        $pimpinan = User::factory()->create(['role' => 'pimpinan']);
        $agenda = Agenda::factory()->create(['status' => 'diajukan']);

        $this->actingAs($pimpinan);
        $response = $this->post(route('agendas.approve', $agenda));
        $response->assertRedirect();
        $this->assertDatabaseHas('agendas', ['status' => 'disetujui']);
    }

    public function test_pimpinan_can_reject_agenda()
    {
        $pimpinan = User::factory()->create(['role' => 'pimpinan']);
        $agenda = Agenda::factory()->create(['status' => 'diajukan']);

        $this->actingAs($pimpinan);
        $response = $this->post(route('agendas.reject', $agenda));
        $response->assertRedirect();
        $this->assertDatabaseHas('agendas', ['status' => 'ditolak']);
    }
}
