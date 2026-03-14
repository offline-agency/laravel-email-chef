<?php

declare(strict_types=1);

namespace OfflineAgency\LaravelEmailChef\Entities\CustomFields;

use OfflineAgency\LaravelEmailChef\Entities\AbstractEntity;

class UpdatedCustomFieldsEntity extends AbstractEntity
{
    public string $custom_field_id;
}
