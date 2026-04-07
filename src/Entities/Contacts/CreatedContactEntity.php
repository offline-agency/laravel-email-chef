<?php

declare(strict_types=1);

namespace OfflineAgency\LaravelEmailChef\Entities\Contacts;

use OfflineAgency\LaravelEmailChef\Entities\Hydratable;

final readonly class CreatedContactEntity
{
    use Hydratable;

    public function __construct(
        public bool $contact_added_to_list = false,
        public string $contact_id = '',
        public string $contact_status = '',
        public bool $updated = false,
    ) {}
}
