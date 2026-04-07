<?php

declare(strict_types=1);

namespace OfflineAgency\LaravelEmailChef\Entities\Autoresponders;

use OfflineAgency\LaravelEmailChef\Entities\Hydratable;

final readonly class UpdateAutoresponder
{
    use Hydratable;

    public function __construct(
        public ?object $body = null,
    ) {}
}
