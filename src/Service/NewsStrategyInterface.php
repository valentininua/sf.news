<?php

declare(strict_types=1);

namespace App\Service;

interface NewsStrategyInterface
{
    public function handle(): void;
}
