<?php

declare(strict_types=1);

namespace OfflineAgency\LaravelEmailChef\Entities\Segments;

use OfflineAgency\LaravelEmailChef\Entities\AbstractEntity;

class Segment extends AbstractEntity
{
    public string $id;

    public string $list_id;

    public string $logic;

    /** @var array<mixed> */
    public array $condition_groups;

    public string $name;

    public string $description;
}
