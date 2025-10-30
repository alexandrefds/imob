<?php

namespace App\Providers;

use App\Repositories\Property\PropertyRepository;
use App\Repositories\Property\PropertyRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class PropertyRepositoryProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(
            PropertyRepositoryInterface::class,
            PropertyRepository::class
        );
    }

    public function boot(): void
    {
    }
}
