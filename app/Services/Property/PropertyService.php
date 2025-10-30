<?php

namespace App\Services\Property;

use App\Services\Property\PropertyServiceInterface;


class PropertyService implements PropertyServiceInterface
{
    public function __construct(readonly private PropertyRepositoryInterface $propertyRepository)
    {
    }

    public function propertyCreate(int $userId, array $data)
    {
        $data['created_by'] = $userId;

        dd($data);
    }
}
