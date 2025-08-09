<?php

namespace App\Interfaces\Repositories;

interface UserRepositoryInterface
{
    public function store(array $userData): void;
}
