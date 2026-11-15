<?php

namespace Tests\Feature;

use App\Models\OrangTua;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthAndRbacTest extends TestCase
{
    use RefreshDatabase;

    public function test_login_page_can_be_rendered(): void
    {
        $response = $this->get('/login');

        $response->assertStatus(200);
        $response->assertSee('TPQ ANNUR BOGOR');
    }

    public function test_root_redirects_to_login(): void
    {
        $response = $this->get('/');

        $response->assertRedirect('/login');
    }

    public function test_admin_can_authenticate_and_redirect_to_admin_dashboard(): void
    {
        $admin = User::factory()->create([
            'email' => 'admin@tpqannur.com',
            'role' => 'admin',
        ]);

        $response = $this->post('/login', [
            'email' => 'admin@tpqannur.com',
            'password' => 'password',
        ]);

        $this->assertAuthenticatedAs($admin);
        $response->assertRedirect(route('admin.dashboard'));
    }

    public function test_parent_can_authenticate_and_redirect_to_parent_dashboard(): void
    {
        $parent = User::factory()->create([
            'email' => 'wali@gmail.com',
            'role' => 'parent',
        ]);

        $response = $this->post('/login', [
            'email' => 'wali@gmail.com',
            'password' => 'password',
        ]);

        $this->assertAuthenticatedAs($parent);
        $response->assertRedirect(route('parent.dashboard'));
    }

    public function test_parent_cannot_access_admin_dashboard(): void
    {
        $parent = User::factory()->create([
            'role' => 'parent',
        ]);

        $response = $this->actingAs($parent)->get('/admin/dashboard');

        $response->assertStatus(403);
    }

    public function test_unauthenticated_user_cannot_access_admin_dashboard(): void
    {
        $response = $this->get('/admin/dashboard');

        $response->assertRedirect('/login');
    }

    public function test_user_can_logout(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('/logout');

        $this->assertGuest();
        $response->assertRedirect('/login');
    }
}

