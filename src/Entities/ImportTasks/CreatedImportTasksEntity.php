<?php

declare(strict_types=1);

namespace OfflineAgency\LaravelEmailChef\Entities\ImportTasks;

use OfflineAgency\LaravelEmailChef\Entities\Hydratable;

final readonly class CreatedImportTasksEntity
{
    use Hydratable;

    /**
     * @param array<mixed> $validation_errors
     * @param array<mixed> $validation_warnings
     */
    public function __construct(
        public string $id = '',
        public array $validation_errors = [],
        public array $validation_warnings = [],
    ) {}
}
