<?php

namespace App\Repositories;

use App\Interfaces\Interfaces\Ad\AdRepositoryInterface;
use App\Models\Ad;

class AdRepository implements AdRepositoryInterface
{
    public function __construct(readonly private Ad $adModel)
    {
    }

    public function store(array $adData): void
    {
        $this->adModel->create($adData);
    }
}
