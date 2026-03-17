<?php

declare(strict_types=1);

namespace OfflineAgency\LaravelEmailChef\Entities\Autoresponders;

use OfflineAgency\LaravelEmailChef\Entities\AbstractEntity;

class AutoresponderCollection extends AbstractEntity
{
    public string $id;

    public string $name;

    public string $trigger_id;

    public string $active;

    public string $hours_delay;

    public mixed $sent;

    public string $open;

    public string $click;

    public mixed $lists;
}
