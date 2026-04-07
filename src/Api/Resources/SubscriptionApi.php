<?php

declare(strict_types=1);

namespace OfflineAgency\LaravelEmailChef\Api\Resources;

use OfflineAgency\LaravelEmailChef\Api\Api;
use OfflineAgency\LaravelEmailChef\Entities\Error;
use OfflineAgency\LaravelEmailChef\Entities\Subscription\SubscriptionEntity;

final class SubscriptionApi extends Api
{
    public function getCollection(): mixed {
        $response = $this->get('/subscriptions/current');

        if (! $response->success) {
            return Error::fromResponse($response->data);
        }

        return SubscriptionEntity::fromResponse($response->data);
    }
}
