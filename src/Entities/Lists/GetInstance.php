<?php

declare(strict_types=1);

namespace OfflineAgency\LaravelEmailChef\Entities\Lists;

use OfflineAgency\LaravelEmailChef\Entities\Hydratable;

final readonly class GetInstance
{
    use Hydratable;

    public function __construct(
        public string $name = '',
        public string $description = '',
    ) {}
}
