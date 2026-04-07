<?php

declare(strict_types=1);

namespace OfflineAgency\LaravelEmailChef\Entities\Campaigns;

use OfflineAgency\LaravelEmailChef\Entities\Hydratable;

final readonly class Cloning
{
    use Hydratable;

    public function __construct(
        public ?object $body = null,
    ) {}
}
