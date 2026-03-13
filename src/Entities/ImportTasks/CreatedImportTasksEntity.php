<?php

namespace OfflineAgency\LaravelEmailChef\Entities\ImportTasks;

use OfflineAgency\LaravelEmailChef\Entities\AbstractEntity;

class CreatedImportTasksEntity extends AbstractEntity
{
    public string $id;
    public array $validation_errors;
    public array $validation_warnings;
}
