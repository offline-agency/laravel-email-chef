<?php

declare(strict_types=1);

namespace OfflineAgency\LaravelEmailChef\Entities\Autoresponders;

use OfflineAgency\LaravelEmailChef\Entities\Hydratable;

final readonly class Autoresponder
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
        public string $subject = '',
        public string $html_body = '',
        public string $text_body = '',
        public string $sender_id = '',
        public mixed $template_id = null,
        public string $reply_to_id = '',
        public string $sent_count_cache = '',
        public string $open_count_cache = '',
        public string $click_count_cache = '',
        public string $ga_enabled = '',
        public string $ga_campaign_title = '',
        public ?object $autoresponder = null,
        public array $lists = [],
    ) {}
}
