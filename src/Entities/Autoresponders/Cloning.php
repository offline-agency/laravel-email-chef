<?php

declare(strict_types=1);

namespace OfflineAgency\LaravelEmailChef\Entities\Autoresponders;

use OfflineAgency\LaravelEmailChef\Entities\AbstractEntity;

class Cloning extends AbstractEntity
{
    public string $status;

    public string $id;
}
