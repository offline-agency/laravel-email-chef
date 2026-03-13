<?php

namespace OfflineAgency\LaravelEmailChef\Entities\SMS;

use OfflineAgency\LaravelEmailChef\Entities\AbstractEntity;

class BulkMessageStatus extends AbstractEntity
{
    public string $bulk_id;
    public string $message_id;

    public string $to;

    public string $from;

    public string $text;

    public string $sent_at;

    public string $done_at;

    public int $sms_count;

    public object $price;

    public string $status;

    public string $error;
}
