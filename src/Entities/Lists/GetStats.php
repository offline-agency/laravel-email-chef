<?php

declare(strict_types=1);

namespace OfflineAgency\LaravelEmailChef\Entities\Lists;

use OfflineAgency\LaravelEmailChef\Entities\Hydratable;

final readonly class GetStats
{
    use Hydratable;

    public function __construct(
        /** @var array<mixed> */
        public array $total_list = [],
        /** @var array<mixed> */
        public array $daily_delta_list = [],
        public string $start_date = '',
        public string $last_date = '',
    ) {}
}
