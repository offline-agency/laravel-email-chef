<?php

declare(strict_types=1);

namespace OfflineAgency\LaravelEmailChef\Entities\SendEmail;

use OfflineAgency\LaravelEmailChef\Entities\Hydratable;

final readonly class SendMail
{
    use Hydratable;

    public function __construct(
        public ?object $body = null,
    ) {}
}
