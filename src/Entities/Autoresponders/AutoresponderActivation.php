<?php

declare(strict_types=1);

namespace OfflineAgency\LaravelEmailChef\Entities\Autoresponders;

use OfflineAgency\LaravelEmailChef\Entities\Hydratable;

final readonly class AutoresponderActivation
{
    use Hydratable;

    public function __construct(
        public string $status = '',
        public string $autoresponder_id = '',
    ) {}
}
