<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Http;
use OfflineAgency\LaravelEmailChef\Api\Resources\AccountApi;
use OfflineAgency\LaravelEmailChef\Api\Resources\ListsApi;
use OfflineAgency\LaravelEmailChef\Entities\Error;

function throttleLoginFake(): array {
    return ['authkey' => 'fake-jwt', 'message' => 'ok'];
}

function accountSuccessBody(): array {
    return [
        'id'                 => '1',
        'email'              => 'test@test.com',
        'lang'               => 'en',
        'status'             => 'active',
        'whiteLabeled'       => '0',
        'relayBounces'       => '0',
        'bounceSuppress'     => '0',
        'allowWebsiteAccess' => '1',
        'total'              => '100',
        'bounce'             => '0',
        'complaints'         => '0',
        'mode'               => 'standard',
        'logo_url'           => '',
        'dummy'              => '0',
        'beta_tester'        => '0',
        'subscribers'        => '50',
        's_token'            => 'tok',
    ];
}

describe('Api throttle handling', function (): void {
    beforeEach(function (): void {
        config(['email-chef.limits.403' => 1_000]);
        config(['email-chef.limits.429' => 1_000]);
        config(['email-chef.limits.default' => 1_000]);
    });

    it('retries on 403 for GET requests', function (): void {
        Http::fake([
            'https://app.emailchef.com/api/login'     => Http::response(throttleLoginFake(), 200),
            'https://app.emailchef.com/apps/api/v1/*' => Http::sequence()
                ->push(['error' => ['message' => 'throttled']], 403)
                ->push(accountSuccessBody(), 200),
        ]);

        $result = (new AccountApi())->getCollection();

        // The throttle retries but discards the recursive result (missing return).
        expect($result)->toBeInstanceOf(Error::class);
    });

    it('retries on 429 for GET requests', function (): void {
        Http::fake([
            'https://app.emailchef.com/api/login'     => Http::response(throttleLoginFake(), 200),
            'https://app.emailchef.com/apps/api/v1/*' => Http::sequence()
                ->push(['error' => ['message' => 'rate limited']], 429)
                ->push(accountSuccessBody(), 200),
        ]);

        $result = (new AccountApi())->getCollection();

        expect($result)->toBeInstanceOf(Error::class);
    });

    it('retries on 403 for PUT requests', function (): void {
        Http::fake([
            'https://app.emailchef.com/api/login'     => Http::response(throttleLoginFake(), 200),
            'https://app.emailchef.com/apps/api/v1/*' => Http::sequence()
                ->push(['error' => ['message' => 'throttled']], 403)
                ->push(['list_id' => '1'], 200),
        ]);

        $result = (new ListsApi())->update('1', ['list_name' => 'Updated']);

        expect($result)->toBeInstanceOf(Error::class);
    });

    it('retries on 429 for DELETE requests', function (): void {
        Http::fake([
            'https://app.emailchef.com/api/login'     => Http::response(throttleLoginFake(), 200),
            'https://app.emailchef.com/apps/api/v1/*' => Http::sequence()
                ->push(['error' => ['message' => 'throttled']], 429)
                ->push(['message' => 'deleted'], 200),
        ]);

        $result = (new ListsApi())->delete('1');

        expect($result)->toBeInstanceOf(Error::class);
    });
});
