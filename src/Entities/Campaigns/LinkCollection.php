<?php

declare(strict_types=1);

namespace OfflineAgency\LaravelEmailChef\Entities\Campaigns;

use OfflineAgency\LaravelEmailChef\Entities\Hydratable;

final readonly class LinkCollection
{
    use Hydratable;

    public function __construct(
        public string $url = '',
        public string $name = '',
        public string $id = '',
    ) {}
}
