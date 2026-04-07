<?php

declare(strict_types=1);

namespace OfflineAgency\LaravelEmailChef\Entities\Subscription;

use OfflineAgency\LaravelEmailChef\Entities\Hydratable;

final readonly class SubscriptionEntity
{
    use Hydratable;

    public function __construct(
        public string $account_id = '',
        public string $type = '',
        public string $simple_send_count = '',
        public ?string $send_count = null,
        public string $credits_count = '',
        public string $credits_count_ref = '',
        public string $id = '',
        public ?string $plan_id = null,
        public string $plan_expiration = '',
        public string $c_date = '',
        public string $expired = '',
        public ?string $last_used = null,
        public string $active = '',
        public string $license_code = '',
        public string $pending_payment = '',
        public ?string $pending_payment_last_update = null,
        public ?string $prod_ref = null,
        public ?string $send_limit = null,
        public ?string $max_contacts = null,
        public ?string $plan_name = null,
        public ?string $limit_interval = null,
        public ?string $plan_ord = null,
    ) {}
}
