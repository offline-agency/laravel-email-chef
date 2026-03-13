<?php

namespace OfflineAgency\LaravelEmailChef\Tests\Feature\Resources;

use OfflineAgency\LaravelEmailChef\Api\Resources\SubscriptionApi;
use OfflineAgency\LaravelEmailChef\Entities\Subscription\SubscriptionEntity;
use OfflineAgency\LaravelEmailChef\Tests\TestCase;

class SubscriptionTest extends TestCase
{
    public function test_get_collection()
    {
        $subscriptions = new SubscriptionApi();

        $response = $subscriptions->getCollection();

        $this->assertInstanceOf(SubscriptionEntity::class, $response);
        $this->assertIsString($response->account_id);
        $this->assertIsString($response->type);
        $this->assertIsString($response->simple_send_count);
        $this->assertIsString($response->send_count);
        $this->assertIsString($response->credits_count);
        $this->assertIsString($response->credits_count_ref);
        $this->assertIsString($response->id);
        $this->assertIsString($response->plan_id);
        $this->assertIsString($response->plan_expiration);
        $this->assertIsString($response->c_date);
        $this->assertIsString($response->expired);
        $this->assertIsString($response->last_used);
        $this->assertIsString($response->active);
        $this->assertIsString($response->license_code);
        $this->assertIsString($response->pending_payment);
        $this->assertIsString($response->send_limit);
        $this->assertIsString($response->max_contacts);
        $this->assertIsString($response->plan_name);
        $this->assertIsString($response->limit_interval);
        $this->assertIsString($response->plan_ord);
    }
}
