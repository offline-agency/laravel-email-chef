<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Http;
use OfflineAgency\LaravelEmailChef\LaravelEmailChef;

describe('LaravelEmailChef', function (): void {
    it('sets the auth key after a successful login', function (): void {
        Http::fake([
            'https://app.emailchef.com/api/login' => Http::response(
                ['authkey' => 'real-jwt-token', 'message' => 'ok'],
                200,
            ),
        ]);

        $client = new LaravelEmailChef();

        expect($client->getAuthKey())->toBe('real-jwt-token');
    });

    it('throws an Exception when credentials are missing', function (): void {
        config(['email-chef.username' => null]);
        config(['email-chef.password' => null]);

        expect(static fn () => new LaravelEmailChef())->toThrow(
            Exception::class,
            'Missing Credentials',
        );
    });

    it('throws an Exception when credentials are wrong', function (): void {
        Http::fake([
            'https://app.emailchef.com/api/login' => Http::response(
                ['authkey' => null, 'message' => 'error_credential_wrong'],
                200,
            ),
        ]);

        expect(static fn () => new LaravelEmailChef())->toThrow(Exception::class);
    });
});
