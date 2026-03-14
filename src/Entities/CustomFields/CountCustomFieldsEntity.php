<?php

declare(strict_types=1);

namespace OfflineAgency\LaravelEmailChef\Entities\CustomFields;

use OfflineAgency\LaravelEmailChef\Entities\AbstractEntity;

class CountCustomFieldsEntity extends AbstractEntity
{
    public string $totalcount;
}
