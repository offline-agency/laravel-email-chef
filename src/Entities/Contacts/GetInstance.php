<?php

declare(strict_types=1);

namespace OfflineAgency\LaravelEmailChef\Entities\Contacts;

use Carbon\Carbon;
use OfflineAgency\LaravelEmailChef\Entities\Hydratable;

final readonly class GetInstance
{
    use Hydratable;

    /**
     * @param array<mixed> $customFields
     */
    public function __construct(
        public string $status = '',
        public string $email = '',
        public string $firstname = '',
        public string $lastname = '',
        public string $ip = '',
        public string $country = '',
        public string $city = '',
        public string $added_by = '',
        public string $addition_time = '',
        public ?string $removed_by = null,
        public bool $privacy_accepted = false,
        public ?Carbon $privacy_accepted_date = null,
        public bool $terms_accepted = false,
        public ?Carbon $terms_accepted_date = null,
        public bool $newsletter_accepted = false,
        public ?Carbon $newsletter_accepted_date = null,
        public bool $blacklisted = false,
        public array $customFields = [],
        public int $rating = 0,
    ) {}
}
