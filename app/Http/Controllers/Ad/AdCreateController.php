<?php

namespace App\Http\Controllers\Ad;

use App\Http\Controllers\Controller;
use App\Http\Requests\AdCreateRequest;
use App\Interfaces\Interfaces\Ad\AdRepositoryInterface;
use App\StatusEnum;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

class AdCreateController extends Controller
{
    public function __construct(readonly private AdRepositoryInterface $adRepository)
    {
    }

    public function __invoke(AdCreateRequest $request): JsonResponse
    {
        try {
            $data = $request->validated();

            $this->adRepository->store($data);

            return response()->json([
                'success' => true,
                'message' => 'Ad created successfully',
            ], StatusEnum::CREATED);

        } catch (Exception $e) {
            Log::error('Ad creation failed: ' . $e->getMessage(), [
                'exception' => $e,
                'request' => $request->all()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to create ad',
                'error' => config('app.debug') ? $e->getMessage() : 'Internal server error'
            ], StatusEnum::SERVER_ERROR);
        }
    }
}
