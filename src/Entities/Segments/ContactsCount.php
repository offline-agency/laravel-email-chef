<?php

declare(strict_types=1);

namespace OfflineAgency\LaravelEmailChef\Entities\Segments;

use OfflineAgency\LaravelEmailChef\Entities\Hydratable;

final readonly class ContactsCount
{
    use Hydratable;

    public function __construct(
        public string $match_count = '',
        public string $total_count = '',
    ) {}
}
