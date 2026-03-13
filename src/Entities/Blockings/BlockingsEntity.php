<?php

namespace OfflineAgency\LaravelEmailChef\Entities\Blockings;

use OfflineAgency\LaravelEmailChef\Entities\AbstractEntity;

class BlockingsEntity extends AbstractEntity //todo: check the variables
{
    public string $email;
    public string $type;
}
