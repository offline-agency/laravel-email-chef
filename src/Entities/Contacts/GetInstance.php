<?php

declare(strict_types=1);

namespace OfflineAgency\LaravelEmailChef\Entities\Contacts;

use Carbon\Carbon;
use OfflineAgency\LaravelEmailChef\Entities\AbstractEntity;

class GetInstance extends AbstractEntity
{
    public string $status;

    public string $email;

    public string $firstname;

    public string $lastname;

    public string $ip;

    public string $country;

    public string $city;

    public string $added_by;

    public string $addition_time;

    public ?string $removed_by;

    public bool $privacy_accepted;

    public ?Carbon $privacy_accepted_date;

    public bool $terms_accepted;

    public ?Carbon $terms_accepted_date;

    public bool $newsletter_accepted;

    public ?Carbon $newsletter_accepted_date;

    public bool $blacklisted;

    public array $customFields;

    public int $rating;
}
