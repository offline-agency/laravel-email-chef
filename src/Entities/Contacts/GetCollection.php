<?php

declare(strict_types=1);

namespace OfflineAgency\LaravelEmailChef\Entities\Contacts;

use OfflineAgency\LaravelEmailChef\Entities\AbstractEntity;

class GetCollection extends AbstractEntity
{
    public string $status;

    public string $email;

    public string $firstname;

    public string $lastname;

    public ?string $ip;
}
