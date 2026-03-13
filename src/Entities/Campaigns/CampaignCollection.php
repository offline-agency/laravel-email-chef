<?php

namespace OfflineAgency\LaravelEmailChef\Entities\Campaigns;

use OfflineAgency\LaravelEmailChef\Entities\AbstractEntity;

class CampaignCollection extends AbstractEntity
{
    public string $id;

    public string $sender_id;

    public string $name;

    public string $date;

    public string $status;

    public $scheduled_time;

    public $send_time;

    public string $recipients;

    public string $queue_num;

    public string $success_num;

    public int $delivered;

    public int $unique_opened;

    public int $unique_clicked;

    public int $attempted;
}
