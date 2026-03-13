<?php

namespace OfflineAgency\LaravelEmailChef\Entities\Segments;

use OfflineAgency\LaravelEmailChef\Entities\AbstractEntity;

class ContactsCount extends AbstractEntity
{
    public string $match_count;

    public string $total_count;
}
