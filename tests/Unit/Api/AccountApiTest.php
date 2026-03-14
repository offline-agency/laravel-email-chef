<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Http;
use OfflineAgency\LaravelEmailChef\Api\Resources\AccountApi;
use OfflineAgency\LaravelEmailChef\Entities\Account\AccountEntity;
use OfflineAgency\LaravelEmailChef\Entities\Error;

/** Shared login stub response. */
function accountLoginFake(): array {
    return ['authkey' => 'fake-jwt', 'message' => 'ok'];
}

describe('AccountApi', function (): void {
    it('returns an AccountEntity on success', function (): void {
        Http::fake([
            'https://app.emailchef.com/api/login' => Http::response(accountLoginFake(), 200),
            '*'                                   => Http::response([
                'id'                 => '1',
                'email'              => 'user@example.com',
                'lang'               => 'en',
                'status'             => 'active',
                'whiteLabeled'       => '0',
                'relayBounces'       => '0',
                'bounceSuppress'     => '0',
                'allowWebsiteAccess' => '1',
                'total'              => '100',
                'bounce'             => '5',
                'complaints'         => '0',
                'mode'               => 'standard',
                'logo_url'           => 'https://example.com/logo.png',
                'dummy'              => '0',
                'beta_tester'        => '0',
                'subscribers'        => '95',
                's_token'            => 'abc123',
            ], 200),
        ]);

        $result = (new AccountApi())->getCollection();

        expect($result)->toBeInstanceOf(AccountEntity::class)
            ->and($result->id)->toBe('1')
            ->and($result->email)->toBe('user@example.com');

        Http::assertSent(static fn ($req) => str_ends_with($req->url(), 'accounts/current'));
    });

    it('returns an Error entity on non-200 response', function (): void {
        Http::fake([
            'https://app.emailchef.com/api/login' => Http::response(accountLoginFake(), 200),
            '*'                                   => Http::response(['error' => ['message' => 'Server error']], 500),
        ]);

        expect((new AccountApi())->getCollection())->toBeInstanceOf(Error::class);
    });
});
