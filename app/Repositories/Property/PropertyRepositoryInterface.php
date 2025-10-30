<?php

namespace App\Repositories\Property;

interface PropertyRepositoryInterface
{
    public function store(array $data): void;
}
