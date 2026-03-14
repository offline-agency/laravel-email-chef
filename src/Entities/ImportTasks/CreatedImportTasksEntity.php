<?php

declare(strict_types=1);

namespace OfflineAgency\LaravelEmailChef\Entities\ImportTasks;

use OfflineAgency\LaravelEmailChef\Entities\AbstractEntity;

class CreatedImportTasksEntity extends AbstractEntity
{
    public string $id;

    /** @var array<mixed> */
    public array $validation_errors;

    /** @var array<mixed> */
    public array $validation_warnings;
}
