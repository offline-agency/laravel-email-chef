<?php

declare(strict_types=1);

namespace OfflineAgency\LaravelEmailChef\Api\Resources;

use OfflineAgency\LaravelEmailChef\Api\Api;
use OfflineAgency\LaravelEmailChef\Entities\Account\AccountEntity;
use OfflineAgency\LaravelEmailChef\Entities\Error;

final class AccountApi extends Api
{
    public function getCollection(): mixed {
        $response = $this->get('accounts/current');

        if (! $response->success) {
            return Error::fromResponse($response->data);
        }

        return AccountEntity::fromResponse($response->data);
    }
}
