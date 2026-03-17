<?php

declare(strict_types=1);

namespace OfflineAgency\LaravelEmailChef\Entities\SendEmail;

use OfflineAgency\LaravelEmailChef\Entities\AbstractEntity;

class SendMail extends AbstractEntity
{
    public object $body;
}
