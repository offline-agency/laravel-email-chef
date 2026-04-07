<?php

declare(strict_types=1);

namespace OfflineAgency\LaravelEmailChef\Entities\Campaigns;

use OfflineAgency\LaravelEmailChef\Entities\Hydratable;

final readonly class CampaignCollection
{
    use Hydratable;

    public function __construct(
        public string $id = '',
        public string $sender_id = '',
        public string $name = '',
        public string $date = '',
        public string $status = '',
        public mixed $scheduled_time = null,
        public mixed $send_time = null,
        public string $recipients = '',
        public string $queue_num = '',
        public string $success_num = '',
        public int $delivered = 0,
        public int $unique_opened = 0,
        public int $unique_clicked = 0,
        public int $attempted = 0,
    ) {}
}
