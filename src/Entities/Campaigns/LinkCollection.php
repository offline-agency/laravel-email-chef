<?php

namespace OfflineAgency\LaravelEmailChef\Entities\Campaigns;

use OfflineAgency\LaravelEmailChef\Entities\AbstractEntity;

class LinkCollection extends AbstractEntity
{
    public string $url;

    public string $name;

    public string $id;
}
