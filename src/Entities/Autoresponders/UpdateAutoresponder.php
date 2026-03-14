<?php

declare(strict_types=1);

namespace OfflineAgency\LaravelEmailChef\Entities\Autoresponders;

use OfflineAgency\LaravelEmailChef\Entities\AbstractEntity;

class UpdateAutoresponder extends AbstractEntity
{
    public object $body;
}
