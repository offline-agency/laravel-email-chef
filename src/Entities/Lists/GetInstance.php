<?php

declare(strict_types=1);

namespace OfflineAgency\LaravelEmailChef\Entities\Lists;

use OfflineAgency\LaravelEmailChef\Entities\AbstractEntity;

class GetInstance extends AbstractEntity
{
    public string $name;

    public string $description;
}
