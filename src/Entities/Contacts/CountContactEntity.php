<?php

declare(strict_types=1);

namespace OfflineAgency\LaravelEmailChef\Entities\Contacts;

use OfflineAgency\LaravelEmailChef\Entities\Hydratable;

final readonly class CountContactEntity
{
    use Hydratable;

    public function __construct(
        public string $active = '',
        public string $unsubscribed = '',
        public string $bounced = '',
        public string $reported = '',
    ) {}
}
