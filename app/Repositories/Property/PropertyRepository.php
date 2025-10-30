<?php

namespace App\Repositories\Property;

use App\Models\Property;

class PropertyRepository implements PropertyRepositoryInterface
{
    public function __construct(readonly private Property $propertyModel)
    {
    }

    public function store(array $data): void
    {
        $this->propertyModel
            ->create($data);
    }
}
