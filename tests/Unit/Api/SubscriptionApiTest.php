<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Http;
use OfflineAgency\LaravelEmailChef\Api\Resources\SubscriptionApi;
use OfflineAgency\LaravelEmailChef\Entities\Error;
use OfflineAgency\LaravelEmailChef\Entities\Subscription\SubscriptionEntity;

function subscriptionLoginFake(): array {
    return ['authkey' => 'fake-jwt', 'message' => 'ok'];
}

describe('SubscriptionApi', function (): void {
    it('returns a SubscriptionEntity on success', function (): void {
        Http::fake([
            'https://app.emailchef.com/api/login' => Http::response(subscriptionLoginFake(), 200),
            '*'                                   => Http::response([
                'plan'   => 'pro',
                'status' => 'active',
            ], 200),
        ]);

        $result = (new SubscriptionApi())->getCollection();

        expect($result)->toBeInstanceOf(SubscriptionEntity::class);

        Http::assertSent(static fn ($req) => str_contains($req->url(), 'subscriptions/current'));
    });

    it('returns an Error on non-200 response', function (): void {
        Http::fake([
            'https://app.emailchef.com/api/login' => Http::response(subscriptionLoginFake(), 200),
            '*'                                   => Http::response(['error' => ['message' => 'Server error']], 500),
        ]);

        expect((new SubscriptionApi())->getCollection())->toBeInstanceOf(Error::class);
    });
});
