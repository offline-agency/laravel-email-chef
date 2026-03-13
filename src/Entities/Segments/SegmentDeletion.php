<?php

namespace OfflineAgency\LaravelEmailChef\Entities\Segments;

use OfflineAgency\LaravelEmailChef\Entities\AbstractEntity;

class SegmentDeletion extends AbstractEntity
{
    public string $status;

    public string $id;
}
