<?php

namespace Tests\Feature;

use App\Models\Mahasiswa;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;
use Illuminate\Support\Facades\Auth;

class ProfileTest extends TestCase
{
    use RefreshDatabase;

    public function test_profile_page_is_displayed(): void
    {
        $user = User::factory()->create();

        $response = $this
            ->actingAs(Auth::$user)
            ->get('/profile');

        $response->assertOk();
    }

    public function test_profile_information_can_be_updated(): void
    {
        $user = User::factory()->create();

        $response = $this
            ->actingAs(Auth::$user)
            ->patch('/profile', [
                'nama' => 'Test User',
                'username' => 'testuser',
                'email' => 'test@example.com',
            ]);

        $response
            ->assertSessionHasNoErrors()
            ->assertRedirect('/profile');

        $user->refresh();

        $this->assertSame('Test User', $user->nama);
        $this->assertSame('testuser', $user->username);
        $this->assertSame('test@example.com', $user->email);
        $this->assertNull($user->email_verified_at);
    }

    public function test_profile_photo_can_be_uploaded_with_a_larger_file_size(): void
    {
        Storage::fake('public');

        $user = User::factory()->create([
            'nama' => 'Old Name',
            'username' => 'olduser',
            'email' => 'old@example.com',
        ]);

        $photo = UploadedFile::fake()->image('profile.jpg', 400, 400)->size(3072);

        $response = $this
            ->actingAs(Auth::$user)
            ->patch('/profile', [
                'nama' => 'Updated Name',
                'username' => 'updateduser',
                'email' => 'updated@example.com',
                'foto' => $photo,
            ]);

        $response
            ->assertSessionHasNoErrors()
            ->assertRedirect('/profile');

        $user->refresh();

        $this->assertNotNull($user->foto);
        Storage::disk('public')->assertExists($user->foto);
    }

    public function test_student_profile_update_preserves_existing_mahasiswa_identity_fields(): void
    {
        $user = User::factory()->create([
            'role' => 'mahasiswa',
            'nama' => 'Old Name',
            'username' => 'olduser',
            'email' => 'old@example.com',
        ]);

        $mahasiswa = Mahasiswa::create([
            'user_id' => $user->id,
            'nim' => '20240001',
            'nama' => 'Old Name',
            'program_studi' => 'Teknik Informatika',
            'semester' => 4,
            'kelas' => 'A',
            'status_voting' => 'Belum',
        ]);

        $response = $this
            ->actingAs(Auth::$user)
            ->patch('/profile', [
                'nama' => 'Updated Name',
                'username' => 'updateduser',
                'email' => 'updated@example.com',
                'no_hp' => '08123456789',
            ]);

        $response
            ->assertSessionHasNoErrors()
            ->assertRedirect('/profile');

        $mahasiswa->refresh();

        $this->assertSame('20240001', $mahasiswa->nim);
        $this->assertSame('Teknik Informatika', $mahasiswa->program_studi);
        $this->assertSame(4, $mahasiswa->semester);
        $this->assertSame('A', $mahasiswa->kelas);
    }

    public function test_email_verification_status_is_unchanged_when_the_email_address_is_unchanged(): void
    {
        $user = User::factory()->create();

        $response = $this
            ->actingAs(Auth::$user)
            ->patch('/profile', [
                'nama' => 'Test User',
                'username' => $user->username,
                'email' => $user->email,
            ]);

        $response
            ->assertSessionHasNoErrors()
            ->assertRedirect('/profile');

        $this->assertNotNull($user->refresh()->email_verified_at);
    }

    public function test_user_can_delete_their_account(): void
    {
        $user = User::factory()->create();

        $response = $this
            ->actingAs(Auth::$user)
            ->delete('/profile', [
                'password' => 'password',
            ]);

        $response
            ->assertSessionHasNoErrors()
            ->assertRedirect('/');

        $this->assertGuest();
        $this->assertNull($user->fresh());
    }

    public function test_correct_password_must_be_provided_to_delete_account(): void
    {
        $user = User::factory()->create();

        $response = $this
            ->actingAs(Auth::$user)
            ->from('/profile')
            ->delete('/profile', [
                'password' => 'wrong-password',
            ]);

        $response
            ->assertSessionHasErrorsIn('userDeletion', 'password')
            ->assertRedirect('/profile');

        $this->assertNotNull($user->fresh());
    }
}
