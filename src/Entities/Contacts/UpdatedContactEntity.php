<?php

declare(strict_types=1);

namespace OfflineAgency\LaravelEmailChef\Entities\Contacts;

use OfflineAgency\LaravelEmailChef\Entities\Hydratable;

final readonly class UpdatedContactEntity
{
    use Hydratable;

    public function __construct(
        public bool $updated = false,
    ) {}
}
