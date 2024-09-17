<?php

namespace OfflineAgency\LaravelEmailChef\Entities\ImportTasks;

use OfflineAgency\LaravelEmailChef\Entities\AbstractEntity;

class GetInstance extends AbstractEntity
{
    public string $id;
    public string $list_id;
    public ?string $error_message;
    public string $progress;
    public string $imported;
    public string $failed;
    public string $updated;
    public string $uploaded_file_name;
    public ?string $notification_link;
    public string $list_name;
}
