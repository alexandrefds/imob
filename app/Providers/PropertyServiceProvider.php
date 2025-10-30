<?php

namespace App\Providers;

use App\Services\Property\PropertyService;
use App\Services\Property\PropertyServiceInterface;
use Illuminate\Support\ServiceProvider;

class PropertyServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(
            PropertyServiceInterface::class,
            PropertyService::class
        );
    }

    public function boot(): void
    {
    }
}
