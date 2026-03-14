<?php

declare(strict_types=1);

namespace OfflineAgency\LaravelEmailChef\Entities\Autoresponders;

use OfflineAgency\LaravelEmailChef\Entities\AbstractEntity;

class AutoresponderActivation extends AbstractEntity
{
    public string $status;

    public string $autoresponder_id;
}
