<?php

namespace OfflineAgency\LaravelEmailChef\Entities\Autoresponders;

use OfflineAgency\LaravelEmailChef\Entities\AbstractEntity;

class LinksCollection extends AbstractEntity
{
    public string $url;
    public string $name;
    public string $id;
}
