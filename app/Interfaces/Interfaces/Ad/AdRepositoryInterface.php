<?php

namespace App\Interfaces\Interfaces\Ad;

interface AdRepositoryInterface
{
    public function store(array $adData): void;
}
