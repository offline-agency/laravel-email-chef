<?php

declare(strict_types=1);

namespace OfflineAgency\LaravelEmailChef\Entities\Blockings;

use OfflineAgency\LaravelEmailChef\Entities\AbstractEntity;

class CountBlockingsEntity extends AbstractEntity
{
    public string $totalcount;
}
