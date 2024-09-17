<?php

namespace OfflineAgency\LaravelEmailChef\Entities\CustomFields;

use OfflineAgency\LaravelEmailChef\Entities\AbstractEntity;

class CreatedCustomFieldsEntity extends AbstractEntity
{
    public string $status = '';
    public string $custom_field_id = '';
}
