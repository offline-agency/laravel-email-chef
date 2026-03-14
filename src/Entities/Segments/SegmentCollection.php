<?php

declare(strict_types=1);

namespace OfflineAgency\LaravelEmailChef\Entities\Segments;

use OfflineAgency\LaravelEmailChef\Entities\AbstractEntity;

class SegmentCollection extends AbstractEntity
{
    public string $id;

    public string $name;

    public string $description;

    public string $match_count;

    public string $total_count;

    public mixed $last_refresh_time;
}
