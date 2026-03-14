<?php

declare(strict_types=1);

namespace OfflineAgency\LaravelEmailChef\Entities\Campaigns;

use OfflineAgency\LaravelEmailChef\Entities\AbstractEntity;

class Campaign extends AbstractEntity
{
    public string $id;

    public string $account_id;

    public string $name;

    public string $type;

    public mixed $subject;

    public string $html_body;

    public string $text_body;

    public string $sender_id;

    public mixed $template_id;

    public string $reply_to_id;

    public string $sent_count_cache;

    public string $open_count_cache;

    public string $click_count_cache;

    public mixed $ga_enabled;

    public mixed $ga_campaign_title;

    public object $campaign;

    /** @var array<mixed> */
    public array $lists;
}
