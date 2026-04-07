<?php

declare(strict_types=1);

namespace OfflineAgency\LaravelEmailChef\Entities\ImportTasks;

use OfflineAgency\LaravelEmailChef\Entities\Hydratable;

final readonly class GetInstance
{
    use Hydratable;

    public function __construct(
        public string $id = '',
        public string $list_id = '',
        public ?string $error_message = null,
        public string $progress = '',
        public string $imported = '',
        public string $failed = '',
        public string $updated = '',
        public string $uploaded_file_name = '',
        public ?string $notification_link = null,
        public string $list_name = '',
    ) {}
}
