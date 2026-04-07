<?php

declare(strict_types=1);

namespace OfflineAgency\LaravelEmailChef\Entities\Autoresponders;

use OfflineAgency\LaravelEmailChef\Entities\Hydratable;

final readonly class AutoresponderCollection
{
    use Hydratable;

    public function __construct(
        public string $id = '',
        public string $name = '',
        public string $trigger_id = '',
        public string $active = '',
        public string $hours_delay = '',
        public mixed $sent = null,
        public string $open = '',
        public string $click = '',
        public mixed $lists = null,
    ) {}
}
