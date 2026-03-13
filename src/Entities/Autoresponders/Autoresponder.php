<?php

namespace OfflineAgency\LaravelEmailChef\Entities\Autoresponders;

use OfflineAgency\LaravelEmailChef\Entities\AbstractEntity;

class Autoresponder extends AbstractEntity
{
    public string $id;

    public string $account_id;

    public string $name;

    public string $type;

    public string $subject;

    public string $html_body;

    public string $text_body;

    public string $sender_id;

    public $template_id;

    public string $reply_to_id;

    public string $sent_count_cache;

    public string $open_count_cache;

    public string $click_count_cache;

    public string $ga_enabled;

    public string $ga_campaign_title;

    public object $autoresponder;

    public array $lists;
}
