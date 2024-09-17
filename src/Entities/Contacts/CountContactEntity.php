<?php

namespace OfflineAgency\LaravelEmailChef\Entities\Contacts;

use OfflineAgency\LaravelEmailChef\Entities\AbstractEntity;

class CountContactEntity extends AbstractEntity
{
    public string $active;
    public string $unsubscribed;
    public string $bounced;
    public string $reported;
}
