<?php

declare(strict_types=1);

namespace OfflineAgency\LaravelEmailChef\Entities\Contacts;

use OfflineAgency\LaravelEmailChef\Entities\AbstractEntity;

class ContactsEntity extends AbstractEntity
{
    public string $id;

    public string $list_id;

    public string $name;

    public string $type_id;

    public string $place_holder;

    /** @var array<mixed> */
    public array $options;

    public string $text;

    public string $default_value;
}
