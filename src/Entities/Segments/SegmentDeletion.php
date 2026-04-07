<?php

declare(strict_types=1);

namespace OfflineAgency\LaravelEmailChef\Entities\Segments;

use OfflineAgency\LaravelEmailChef\Entities\Hydratable;

final readonly class SegmentDeletion
{
    use Hydratable;

    public function __construct(
        public string $status = '',
        public string $id = '',
    ) {}
}
