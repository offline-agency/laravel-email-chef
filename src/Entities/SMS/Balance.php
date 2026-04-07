<?php

declare(strict_types=1);

namespace OfflineAgency\LaravelEmailChef\Entities\SMS;

use OfflineAgency\LaravelEmailChef\Entities\Hydratable;

final readonly class Balance
{
    use Hydratable;

    public function __construct(
        public float $balance = 0.0,
        public string $currency = '',
    ) {}
}
