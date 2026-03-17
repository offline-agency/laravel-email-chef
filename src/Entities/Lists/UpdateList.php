<?php

declare(strict_types=1);

namespace OfflineAgency\LaravelEmailChef\Entities\Lists;

use OfflineAgency\LaravelEmailChef\Entities\AbstractEntity;

class UpdateList extends AbstractEntity
{
    public string $list_id;
}
