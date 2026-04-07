<?php

declare(strict_types=1);

namespace OfflineAgency\LaravelEmailChef\Entities\CustomFields;

use OfflineAgency\LaravelEmailChef\Entities\Hydratable;

final readonly class GetCollection
{
    use Hydratable;

    /**
     * @param array<mixed>|null $options
     * @param array<mixed>|null $ord
     */
    public function __construct(
        public string $id = '',
        public string $list_id = '',
        public string $name = '',
        public string $type_id = '',
        public string $place_holder = '',
        public ?array $options = null,
        public string $default_value = '',
        public string $admin_only = '',
        public ?array $ord = null,
        public string $data_type = '',
    ) {}
}
