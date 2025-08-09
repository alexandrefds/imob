<?php

namespace App\Providers;

use App\Interfaces\Interfaces\Ad\AdRepositoryInterface;
use App\Repositories\AdRepository;
use Illuminate\Support\ServiceProvider;

class AdRepositoryProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(
            AdRepositoryInterface::class,
            AdRepository::class,
        );
    }

    public function boot(): void
    {
    }
}
