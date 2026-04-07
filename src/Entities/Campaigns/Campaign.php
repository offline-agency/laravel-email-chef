<?php

declare(strict_types=1);

namespace OfflineAgency\LaravelEmailChef\Entities\Campaigns;

use OfflineAgency\LaravelEmailChef\Entities\Hydratable;

final readonly class Campaign
{
    use Hydratable;

    /**
     * @param array<mixed> $lists
     */
    public function __construct(
        public string $id = '',
        public string $account_id = '',
        public string $name = '',
        public string $type = '',
        public mixed $subject = null,
        public string $html_body = '',
        public string $text_body = '',
        public string $sender_id = '',
        public mixed $template_id = null,
        public string $reply_to_id = '',
        public string $sent_count_cache = '',
        public string $open_count_cache = '',
        public string $click_count_cache = '',
        public mixed $ga_enabled = null,
        public mixed $ga_campaign_title = null,
        public ?object $campaign = null,
        public array $lists = [],
    ) {}
}
