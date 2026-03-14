<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Http;
use OfflineAgency\LaravelEmailChef\LaravelEmailChef;

describe('LaravelEmailChefFacade', function (): void {
    it('resolves the facade alias from the service container', function (): void {
        Http::fake([
            'https://app.emailchef.com/api/login' => Http::response(
                ['authkey' => 'fake-jwt', 'message' => 'ok'],
                200,
            ),
        ]);

        $this->app->singleton(
            'laravel-email-chef',
            static fn () => new LaravelEmailChef(),
        );

        expect(\LaravelEmailChef::getAuthKey())->toBeString();
    });
});
