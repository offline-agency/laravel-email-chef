<?php

namespace OfflineAgency\LaravelEmailChef\Entities\Autoresponders;

use OfflineAgency\LaravelEmailChef\Entities\AbstractEntity;

class AutoresponderDeletion extends AbstractEntity
{
    public string $status;

    public string $id;
}
