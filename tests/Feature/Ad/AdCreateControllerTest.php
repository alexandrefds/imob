<?php

namespace Tests\Feature\Ad;

use App\Http\Controllers\Ad\AdCreateController;
use App\Http\Requests\AdCreateRequest;
use App\Interfaces\Interfaces\Ad\AdRepositoryInterface;
use App\StatusEnum;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Mockery;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use RuntimeException;
use Tests\TestCase;

class AdCreateControllerTest extends TestCase
{
    use RefreshDatabase;
    use MockeryPHPUnitIntegration;

    private $adRepositoryMock;

    private $controller;

    public function setUp(): void
    {
        parent::setUp();

        $this->adRepositoryMock = Mockery::mock(AdRepositoryInterface::class);

        $this->controller = new AdCreateController(
           $this->adRepositoryMock
        );
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    public function test_can_create_ad()
    {
        $requestData = [
            'title' => 'Test Ad',
            'description' => 'Test Description',
            'place_type' => 'house',
            'business_type' => 'purchase',
        ];

        $request = $this->mockValidatedRequest($requestData);

        $this->adRepositoryMock
            ->shouldReceive('store')
            ->once()
            ->with($requestData);

        $response = $this->controller->__invoke($request);

        $this->assertEquals(StatusEnum::CREATED, $response->getStatusCode());
        $this->assertJsonStringEqualsJsonString(
            json_encode([
                'success' => true,
                'message' => 'Ad created successfully',
            ]),
            $response->getContent()
        );
    }

    public function test_returns_error_when_repository_fails()
    {
        $requestData = [
            'title' => 'Test Ad',
            'description' => 'Test Description',
            'place_type' => 'apartment',
            'business_type' => 'rent'
        ];

        $request = $this->mockValidatedRequest($requestData);

        $exception = new RuntimeException('Database error');

        $this->adRepositoryMock
            ->shouldReceive('store')
            ->once()
            ->andThrow($exception);

        $response = $this->controller->__invoke($request);

        $this->assertEquals(StatusEnum::SERVER_ERROR, $response->getStatusCode());
        $this->assertJsonStringEqualsJsonString(
            json_encode([
                'success' => false,
                'message' => 'Failed to create ad',
                'error' => 'Database error'
            ]),
            $response->getContent()
        );
    }

    private function mockValidatedRequest(array $data): AdCreateRequest
    {
        $request = new AdCreateRequest();
        $request->initialize(
            server: ['REQUEST_URI' => 'ad/'],
            content: json_encode($data)
        );

        $request->setValidator(
            validator(
                $data,
                $request->rules()
            )
        );

        return $request;
    }
}
