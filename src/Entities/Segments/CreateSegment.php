<?php

declare(strict_types=1);

namespace OfflineAgency\LaravelEmailChef\Entities\Segments;

use OfflineAgency\LaravelEmailChef\Entities\AbstractEntity;

class CreateSegment extends AbstractEntity
{
    public object $body;
}
