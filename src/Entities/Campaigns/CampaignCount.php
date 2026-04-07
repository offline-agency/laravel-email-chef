<?php

declare(strict_types=1);

namespace OfflineAgency\LaravelEmailChef\Entities\Campaigns;

use OfflineAgency\LaravelEmailChef\Entities\Hydratable;

final readonly class CampaignCount
{
    use Hydratable;

    public function __construct(
        public string $saved_draft_counter = '',
        public string $sent_counter = '',
        public string $scheduled_counter = '',
        public string $archived_counter = '',
        public string $failed_counter = '',
    ) {}
}
