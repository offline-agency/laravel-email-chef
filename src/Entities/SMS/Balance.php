<?php

namespace OfflineAgency\LaravelEmailChef\Entities\SMS;

use OfflineAgency\LaravelEmailChef\Entities\AbstractEntity;

class Balance extends AbstractEntity
{
    public float $balance;

    public string $currency;
}
