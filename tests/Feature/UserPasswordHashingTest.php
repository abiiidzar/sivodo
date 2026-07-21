<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Tests\TestCase;

class UserPasswordHashingTest extends TestCase
{
    use RefreshDatabase;

    public function test_password_created_from_pre_hashed_value_can_still_be_verified(): void
    {
        $user = User::create([
            'nama' => 'Test User',
            'username' => 'testuser' . Str::random(4),
            'email' => 'test' . Str::random(4) . '@example.com',
            'password' => Hash::make('password'),
            'role' => 'mahasiswa',
        ]);

        $this->assertTrue(Hash::check('password', $user->password));
    }
}
