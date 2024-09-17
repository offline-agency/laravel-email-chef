<?php

namespace OfflineAgency\LaravelEmailChef\Entities\Subscription;

use OfflineAgency\LaravelEmailChef\Entities\AbstractEntity;

class SubscriptionEntity extends AbstractEntity
{
    public string $account_id;
    public string $type;
    public string $simple_send_count;
    public ?string $send_count;
    public string $credits_count;
    public string $credits_count_ref;
    public string $id;
    public ?string $plan_id;
    public string $plan_expiration;
    public string $c_date;
    public string $expired;
    public ?string $last_used;
    public string $active;
    public string $license_code;
    public string $pending_payment;
    public ?string $pending_payment_last_update;
    public ?string $prod_ref;
    public ?string $send_limit;
    public ?string $max_contacts;
    public ?string $plan_name;
    public ?string $limit_interval;
    public ?string $plan_ord;
}
