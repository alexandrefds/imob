<?php

namespace App\Services\Property;

interface PropertyServiceInterface
{
    public function propertyCreate(int $userId, array $data);
}
