<?php

namespace OfflineAgency\LaravelEmailChef\Entities\Blockings;

use OfflineAgency\LaravelEmailChef\Entities\AbstractEntity;

class GetCollection extends AbstractEntity
{
    public string $email;
    public string $type;
}
