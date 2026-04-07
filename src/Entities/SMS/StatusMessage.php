<?php

declare(strict_types=1);

namespace OfflineAgency\LaravelEmailChef\Entities\SMS;

use OfflineAgency\LaravelEmailChef\Entities\Hydratable;

final readonly class StatusMessage
{
    use Hydratable;

    public function __construct(
        public mixed $bulk_id = null,
        public string $message_id = '',
        public string $to = '',
        public string $from = '',
        public string $text = '',
        public string $sent_at = '',
        public string $done_at = '',
        public int $sms_count = 0,
        public ?object $price = null,
        public string $status = '',
        public string $error = '',
    ) {}
}
