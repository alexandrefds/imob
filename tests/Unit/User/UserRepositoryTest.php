<?php

namespace Tests\Unit\User;

use App\Models\User;
use App\Repositories\UserRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserRepositoryTest extends TestCase
{
    use RefreshDatabase;
    private User $userMock;

    private UserRepository $repository;

    public function setUp(): void
    {
        parent::setUp();

        $this->repository = new UserRepository(new User());
    }

    public function tearDown(): void
    {
        parent::tearDown();
    }

    public function test_can_create_a_user(): void
    {
        $userData = [
            'name' => 'John Doe',
            'email' => 'john_doe@mail.com',
            'password' => 'password',
        ];

        $this->repository->store($userData);

        $this->assertDatabaseHas('users', [
            'name' => $userData['name'],
            'email' => $userData['email'],
        ]);
    }
}
