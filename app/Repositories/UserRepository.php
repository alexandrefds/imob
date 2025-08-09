<?php

namespace App\Repositories;

use App\Interfaces\Repositories\UserRepositoryInterface;
use App\Models\User;

class UserRepository implements UserRepositoryInterface
{
    public function __construct(readonly private User $userModel)
    {
    }

    public function store(array $userData):void
    {
        $this->userModel->create($userData);
    }
}
