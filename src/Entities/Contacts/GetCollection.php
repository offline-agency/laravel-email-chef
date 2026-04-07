<?php

declare(strict_types=1);

namespace OfflineAgency\LaravelEmailChef\Entities\Contacts;

use OfflineAgency\LaravelEmailChef\Entities\Hydratable;

final readonly class GetCollection
{
    use Hydratable;

    public function __construct(
        public string $status = '',
        public string $email = '',
        public string $firstname = '',
        public string $lastname = '',
        public ?string $ip = null,
    ) {}
}
