<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Agenda;
use App\Models\IsiRapat;
use Illuminate\Foundation\Testing\RefreshDatabase;

class IsiRapatControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_create_isi_rapat()
    {
        $user = User::factory()->create(['role' => 'user']);
        $agenda = Agenda::factory()->create(['status' => 'disetujui', 'id_pic' => $user->id_user]);

        $this->actingAs($user);
        $response = $this->post(route('isi_rapats.store'), [
            'id_agenda' => $agenda->id_agenda,
            'pembahasan' => 'Pembahasan penting',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('isi_rapats', ['pembahasan' => 'Pembahasan penting']);
    }

    public function test_admin_can_close_isi_rapat()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $isi = IsiRapat::factory()->create(['status' => 'open']);

        $this->actingAs($admin);
        $this->post(route('isi_rapats.close', $isi))
            ->assertRedirect();

        $this->assertDatabaseHas('isi_rapats', ['status' => 'close']);
    }
}
