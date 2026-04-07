<?php

declare(strict_types=1);

namespace OfflineAgency\LaravelEmailChef\Entities\Contacts;

use OfflineAgency\LaravelEmailChef\Entities\Hydratable;

final readonly class ContactsEntity
{
    use Hydratable;

    /**
     * @param array<mixed> $options
     */
    public function __construct(
        public string $id = '',
        public string $list_id = '',
        public string $name = '',
        public string $type_id = '',
        public string $place_holder = '',
        public array $options = [],
        public string $text = '',
        public string $default_value = '',
    ) {}
}
