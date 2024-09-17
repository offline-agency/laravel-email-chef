<?php

namespace OfflineAgency\LaravelEmailChef\Entities\Account;

use OfflineAgency\LaravelEmailChef\Entities\AbstractEntity;

class AccountEntity extends AbstractEntity
{
    public string $id;
    public string $email;
    public string $lang;
    public string $status;
    public string $whiteLabeled;
    public string $relayBounces;
    public ?string $billing_clientid;
    public ?string $parentid;
    public string $bounceSuppress;
    public ?string $domain;
    public string $allowWebsiteAccess;
    public string $total;
    public string $bounce;
    public string $complaints;
    public ?string $last_update;
    public string $mode;
    public string $logo_url;
    public string $dummy;
    public string $beta_tester;
    public string $subscribers;
    public string $s_token;
}
