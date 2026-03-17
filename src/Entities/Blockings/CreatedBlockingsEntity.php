<?php

declare(strict_types=1);

namespace OfflineAgency\LaravelEmailChef\Entities\Blockings;

use OfflineAgency\LaravelEmailChef\Entities\AbstractEntity;

class CreatedBlockingsEntity extends AbstractEntity
{
    public string $address;
}
