<?php

declare(strict_types=1);

namespace OfflineAgency\LaravelEmailChef\Entities\Account;

use OfflineAgency\LaravelEmailChef\Entities\Hydratable;

final readonly class AccountEntity
{
    use Hydratable;

    public function __construct(
        public string $id = '',
        public string $email = '',
        public string $lang = '',
        public string $status = '',
        public string $whiteLabeled = '',
        public string $relayBounces = '',
        public ?string $billing_clientid = null,
        public ?string $parentid = null,
        public string $bounceSuppress = '',
        public ?string $domain = null,
        public string $allowWebsiteAccess = '',
        public string $total = '',
        public string $bounce = '',
        public string $complaints = '',
        public ?string $last_update = null,
        public string $mode = '',
        public string $logo_url = '',
        public string $dummy = '',
        public string $beta_tester = '',
        public string $subscribers = '',
        public string $s_token = '',
    ) {}
}
