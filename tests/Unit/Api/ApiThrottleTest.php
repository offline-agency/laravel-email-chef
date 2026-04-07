<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Http;
use OfflineAgency\LaravelEmailChef\Api\Resources\AccountApi;
use OfflineAgency\LaravelEmailChef\Entities\Account\AccountEntity;

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
            'https://app.emailchef.com/api/login' => Http::response(throttleLoginFake(), 200),
            '*'                                   => Http::sequence()
                ->push(['error' => 'throttled'], 403)
                ->push(accountSuccessBody(), 200),
        ]);

        $result = (new AccountApi())->getCollection();

        expect($result)->toBeInstanceOf(AccountEntity::class);
    });

    it('retries on 429 for GET requests', function (): void {
        Http::fake([
            'https://app.emailchef.com/api/login' => Http::response(throttleLoginFake(), 200),
            '*'                                   => Http::sequence()
                ->push(['error' => 'rate limited'], 429)
                ->push(accountSuccessBody(), 200),
        ]);

        $result = (new AccountApi())->getCollection();

        expect($result)->toBeInstanceOf(AccountEntity::class);
    });
});
