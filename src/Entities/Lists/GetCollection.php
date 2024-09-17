<?php

namespace OfflineAgency\LaravelEmailChef\Entities\Lists;

use Carbon\Carbon;
use OfflineAgency\LaravelEmailChef\Entities\AbstractEntity;

class GetCollection extends AbstractEntity
{
    public string $name;
    public string $id;
    public ?string $description;
    public Carbon $date;
    public $demo;
    public string $active;
    public string $subscribed;
    public string $unsubscribed;
    public string $bounced;
    public string $reported;
    public string $segments;
    public int $forms;
}
