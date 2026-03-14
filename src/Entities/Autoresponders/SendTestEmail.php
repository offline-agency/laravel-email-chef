<?php

declare(strict_types=1);

namespace OfflineAgency\LaravelEmailChef\Entities\Autoresponders;

use OfflineAgency\LaravelEmailChef\Entities\AbstractEntity;

class SendTestEmail extends AbstractEntity
{
    public object $body;
}
