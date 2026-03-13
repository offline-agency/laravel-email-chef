<?php

namespace OfflineAgency\LaravelEmailChef\Entities\Campaigns;

use OfflineAgency\LaravelEmailChef\Entities\AbstractEntity;

class CampaignCount extends AbstractEntity
{
    public string $saved_draft_counter;

    public string $sent_counter;

    public string $scheduled_counter;

    public string $archived_counter;

    public string $failed_counter;
}
