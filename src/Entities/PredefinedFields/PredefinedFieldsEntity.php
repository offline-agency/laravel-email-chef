<?php

declare(strict_types=1);

namespace OfflineAgency\LaravelEmailChef\Entities\PredefinedFields;

use OfflineAgency\LaravelEmailChef\Entities\Hydratable;

final readonly class PredefinedFieldsEntity
{
    use Hydratable;

    public function __construct(
        public string $id = '',
        public string $name = '',
        public string $type_id = '',
        public string $place_holder = '',
        public string $reference = '',
        public string $mandatory = '',
        public string $data_type = '',
    ) {}
}
