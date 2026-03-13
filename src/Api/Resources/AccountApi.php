<?php

namespace OfflineAgency\LaravelEmailChef\Api\Resources;

use OfflineAgency\LaravelEmailChef\Api\Api;
use OfflineAgency\LaravelEmailChef\Entities\Account\AccountEntity;
use OfflineAgency\LaravelEmailChef\Entities\Error;

class AccountApi extends Api
{
    public function getCollection()
    {
        $response = $this->get('accounts/current');

        if (! $response->success) {
            return new Error($response->data);
        }

        return new AccountEntity($response->data);
    }
}
