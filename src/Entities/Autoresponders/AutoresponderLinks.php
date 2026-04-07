<?php

declare(strict_types=1);

namespace OfflineAgency\LaravelEmailChef\Entities\Autoresponders;

use OfflineAgency\LaravelEmailChef\Entities\Hydratable;

final readonly class AutoresponderLinks
{
    use Hydratable;

    public function __construct(
        public string $url = '',
        public string $name = '',
        public string $id = '',
    ) {}
}
