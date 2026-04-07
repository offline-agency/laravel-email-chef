<?php

declare(strict_types=1);

namespace OfflineAgency\LaravelEmailChef\Entities\Blockings;

use OfflineAgency\LaravelEmailChef\Entities\Hydratable;

final readonly class CreatedBlockingsEntity
{
    use Hydratable;

    public function __construct(
        public string $address = '',
    ) {}
}
