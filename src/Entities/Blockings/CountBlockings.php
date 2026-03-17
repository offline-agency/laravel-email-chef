<?php

declare(strict_types=1);

namespace OfflineAgency\LaraEmail\Entities\Blockings;

use OfflineAgency\LaravelEmailChef\Entities\AbstractEntity;

class CountBlockings extends AbstractEntity
{
    public string $totalcount;
}
