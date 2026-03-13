<?php

namespace OfflineAgency\LaravelEmailChef\Api\Resources;

use OfflineAgency\LaravelEmailChef\Api\Api;
use OfflineAgency\LaravelEmailChef\Entities\Error;
use OfflineAgency\LaravelEmailChef\Entities\Subscription\SubscriptionEntity;

class SubscriptionApi extends Api
{
    public function getCollection()
    {
        $response = $this->get('/subscriptions/current');

        if (! $response->success) {
            return new Error($response->data);
        }

        return new SubscriptionEntity($response->data);
    }
}
