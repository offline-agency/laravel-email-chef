<?php

declare(strict_types=1);

namespace OfflineAgency\LaravelEmailChef\Entities\Campaigns;

use OfflineAgency\LaravelEmailChef\Entities\Hydratable;

final readonly class CampaignDeletion
{
    use Hydratable;

    public function __construct(
        public string $status = '',
        public string $id = '',
    ) {}
}
