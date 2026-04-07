<?php

declare(strict_types=1);

namespace OfflineAgency\LaravelEmailChef\Entities\Blockings;

use OfflineAgency\LaravelEmailChef\Entities\Hydratable;

final readonly class CountBlockings
{
    use Hydratable;

    public function __construct(
        public string $totalcount = '',
    ) {}
}
