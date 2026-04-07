<?php

declare(strict_types=1);

namespace OfflineAgency\LaravelEmailChef\Entities\Blockings;

use OfflineAgency\LaravelEmailChef\Entities\Hydratable;

final readonly class BlockingsEntity
{
    use Hydratable;

    public function __construct(
        public string $email = '',
        public string $type = '',
    ) {}
}
