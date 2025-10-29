<?php

namespace Tests\Feature\User;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class UserCreateCommandTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_create_new_user_successfully()
    {
        $userData = [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => 'Senha@123'
        ];

        $this->artisan('user:create', $userData)
            ->assertExitCode(0);

        $this->assertDatabaseHas('users', [
            'name' => 'John Doe',
            'email' => 'john@example.com'
        ]);

        $user = User::where('email', 'john@example.com')->first();
        $this->assertTrue(Hash::check('Senha@123', $user->password));
    }

    public function test_fails_with_invalid_password()
    {
        $userData = [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => '123'
        ];

        $this->artisan('user:create', $userData)
            ->assertExitCode(1)
            ->expectsOutputToContain('Error to create user');

        $this->assertDatabaseMissing('users', [
            'email' => 'john@example.com'
        ]);
    }

    public function test_fails_with_duplicate_email()
    {
        User::factory()->create([
            'email' => 'john@example.com'
        ]);

        $userData = [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => 'Senha@123'
        ];

        $this->artisan('user:create', $userData)
            ->assertExitCode(1)
            ->expectsOutputToContain('Error to create user');

        $this->assertDatabaseCount('users', 1);
    }

    public function test_fails_with_invalid_name()
    {
        $userData = [
            'name' => '',
            'email' => 'john@example.com',
            'password' => 'Senha@123'
        ];

        $this->artisan('user:create', $userData)
            ->assertExitCode(1)
            ->expectsOutputToContain('Error to create user');

        $this->assertDatabaseMissing('users', [
            'email' => 'john@example.com'
        ]);
    }

    public function test_fails_with_invalid_email_format()
    {
        $userData = [
            'name' => 'John Doe',
            'email' => 'invalid-email',
            'password' => 'Senha@123'
        ];

        $this->artisan('user:create', $userData)
            ->assertExitCode(1)
            ->expectsOutputToContain('Error to create user');

        $this->assertDatabaseMissing('users', [
            'name' => 'John Doe'
        ]);
    }

    public function test_can_create_user_with_special_characters_in_name()
    {
        $userData = [
            'name' => 'João Silva São Paulo',
            'email' => 'joao.silva@example.com',
            'password' => 'Senha@123'
        ];

        $this->artisan('user:create', $userData)
            ->assertExitCode(0);

        $this->assertDatabaseHas('users', [
            'name' => 'João Silva São Paulo',
            'email' => 'joao.silva@example.com'
        ]);
    }

    public function test_can_create_user_with_complex_password()
    {
        $userData = [
            'name' => 'Complex User',
            'email' => 'complex@example.com',
            'password' => 'P@ssw0rd!123'
        ];

        $this->artisan('user:create', $userData)
            ->assertExitCode(0);

        $this->assertDatabaseHas('users', [
            'name' => 'Complex User',
            'email' => 'complex@example.com'
        ]);

        $user = User::where('email', 'complex@example.com')->first();
        $this->assertTrue(Hash::check('P@ssw0rd!123', $user->password));
    }
}
