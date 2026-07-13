<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase;

    public function test_login_screen_can_be_rendered(): void
    {
        $response = $this->get('/login');

        $response->assertStatus(200);
    }

    public function test_users_can_authenticate_using_the_login_screen(): void
    {
        $user = User::factory()->create([
            'role' => 'mahasiswa',
        ]);

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect(route('mahasiswa.dashboard', absolute: false));
    }

    public function test_users_can_not_authenticate_with_invalid_password(): void
    {
        $user = User::factory()->create();

        $this->post('/login', [
            'email' => $user->email,
            'password' => 'wrong-password',
        ]);

        $this->assertGuest();
    }

    public function test_users_are_redirected_to_their_role_dashboard_after_login(): void
    {
        foreach ([
            ['admin', 'admin.dashboard'],
            ['pimpinan', 'pimpinan.dashboard'],
            ['mahasiswa', 'mahasiswa.dashboard'],
        ] as [$role, $routeName]) {
            $user = User::create([
                'nama' => ucfirst($role) . ' Test',
                'username' => $role . uniqid(),
                'email' => $role . uniqid() . '@example.com',
                'password' => Hash::make('password'),
                'role' => $role,
            ]);

            $response = $this->post('/login', [
                'username' => $user->email,
                'password' => 'password',
            ]);

            $response->assertRedirect(route($routeName, absolute: false));
            $this->assertAuthenticatedAs($user);
            $this->post('/logout');
        }
    }

    public function test_users_can_logout(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs(Auth::user)->post('/logout');

        $this->assertGuest();
        $response->assertRedirect('/');
    }
}
