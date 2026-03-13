<?php

namespace OfflineAgency\LaravelEmailChef\Entities\Autoresponders;

use OfflineAgency\LaravelEmailChef\Entities\AbstractEntity;

class AutoresponderCollection extends AbstractEntity
{
    public string $id;

    public string $name;

    public string $trigger_id;

    public string $active;

    public string $hours_delay;

    public $sent;

    public string $open;

    public string $click;

    public $lists;
}
