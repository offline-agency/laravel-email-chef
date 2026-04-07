<?php

declare(strict_types=1);

namespace OfflineAgency\LaravelEmailChef\Entities\CustomFields;

use OfflineAgency\LaravelEmailChef\Entities\Hydratable;

final readonly class CountCustomFieldsEntity
{
    use Hydratable;

    public function __construct(
        public string $totalcount = '',
    ) {}
}
