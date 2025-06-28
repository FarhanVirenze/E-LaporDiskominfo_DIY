<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Notif;
use Illuminate\Foundation\Testing\RefreshDatabase;

class NotifControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_create_notif()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $user = User::factory()->create(['role' => 'user']);

        $this->actingAs($admin);
        $response = $this->post(route('notifs.store'), [
            'id_user' => $user->id_user,
            'jenis_notif' => 'Info',
            'keterangan' => 'Tes Notif',
            'status' => 'belum terbaca',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('notifs', ['keterangan' => 'Tes Notif']);
    }

    public function test_user_can_view_their_notif()
    {
        $user = User::factory()->create(['role' => 'user']);
        $notif = Notif::factory()->create(['id_user' => $user->id_user]);

        $this->actingAs($user);
        $this->get(route('notifs.show', $notif))
            ->assertStatus(200);
    }
}
