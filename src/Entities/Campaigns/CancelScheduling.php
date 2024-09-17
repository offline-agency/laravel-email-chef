<?php

namespace OfflineAgency\LaravelEmailChef\Entities\Campaigns;

use OfflineAgency\LaravelEmailChef\Entities\AbstractEntity;

class CancelScheduling extends AbstractEntity
{
    public string $status;

    public string $campaign_id;
}
