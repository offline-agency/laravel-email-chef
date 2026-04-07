<?php

declare(strict_types=1);

namespace OfflineAgency\LaravelEmailChef\Entities\ImportTasks;

use OfflineAgency\LaravelEmailChef\Entities\Hydratable;

final readonly class ImportTasksEntity
{
    use Hydratable;

    public function __construct(
        public string $id = '',
        public string $list_id = '',
        public string $creation_time = '',
        public ?string $error_message = null,
        public string $imported_success = '',
        public string $imported_fail = '',
        public string $imported_updated = '',
        public string $last_updated = '',
        public string $progress = '',
        public string $uploaded_file_name = '',
        public string $list_name = '',
        public ?string $notification_link = null,
    ) {}
}
