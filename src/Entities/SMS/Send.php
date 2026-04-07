<?php

declare(strict_types=1);

namespace OfflineAgency\LaravelEmailChef\Entities\SMS;

use OfflineAgency\LaravelEmailChef\Entities\Hydratable;

final readonly class Send
{
    use Hydratable;

    public function __construct(
        public ?object $body = null,
    ) {}
}
