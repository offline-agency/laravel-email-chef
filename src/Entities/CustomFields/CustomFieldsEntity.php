<?php

declare(strict_types=1);

namespace OfflineAgency\LaravelEmailChef\Entities\CustomFields;

use OfflineAgency\LaravelEmailChef\Entities\AbstractEntity;

class CustomFieldsEntity extends AbstractEntity
{
    public string $id;

    public string $list_id;

    public string $name;

    public string $type_id;

    public string $place_holder;

    /** @var array<mixed>|null */
    public ?array $options;

    public string $default_value;

    public string $admin_only;

    /** @var array<mixed>|null */
    public ?array $ord;

    public string $data_type;
}
