<?php

declare(strict_types=1);

namespace OfflineAgency\LaravelEmailChef\Entities\Segments;

use OfflineAgency\LaravelEmailChef\Entities\Hydratable;

final readonly class Segment
{
    use Hydratable;

    /**
     * @param array<mixed> $condition_groups
     */
    public function __construct(
        public string $id = '',
        public string $list_id = '',
        public string $logic = '',
        public array $condition_groups = [],
        public string $name = '',
        public string $description = '',
    ) {}
}
