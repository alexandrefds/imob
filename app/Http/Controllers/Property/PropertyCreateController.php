<?php

namespace App\Http\Controllers\Property;

use App\Enums\HttpStatusEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\PropertyCreateRequest;
use App\Services\Property\PropertyServiceInterface;
use Exception;

class PropertyCreateController extends Controller
{
public function __construct(readonly private PropertyServiceInterface $propertyService)
    {
    }

    public function __invoke(PropertyCreateRequest $request)
    {
        try {
            $userId = 1;
            $data = $request->validated();

            // $this->propertyService->propertyCreate($userId, $data);

            return response()->json([
                'message' => 'Property created successfully.',
            ], HttpStatusEnum::CREATED);

        } catch (Exception $e) {
            return response()->json([
                'error' => 'Related record not found.',
                'details' => $e->getMessage(),
            ], HttpStatusEnum::NOT_FOUND);
        }
    }
}
