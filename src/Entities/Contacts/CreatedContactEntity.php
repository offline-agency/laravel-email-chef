<?php

declare(strict_types=1);

namespace OfflineAgency\LaravelEmailChef\Entities\Contacts;

use OfflineAgency\LaravelEmailChef\Entities\AbstractEntity;

class CreatedContactEntity extends AbstractEntity
{
    public bool $contact_added_to_list;

    public string $contact_id;

    public string $contact_status;

    public bool $updated;
}
