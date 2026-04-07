<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Http;
use OfflineAgency\LaravelEmailChef\Api\Resources\AccountInfosApi;
use OfflineAgency\LaravelEmailChef\Api\Resources\AutorespondersApi;
use OfflineAgency\LaravelEmailChef\Api\Resources\BlockingsApi;
use OfflineAgency\LaravelEmailChef\Api\Resources\CampaignsApi;
use OfflineAgency\LaravelEmailChef\Api\Resources\ContactsApi;
use OfflineAgency\LaravelEmailChef\Api\Resources\SMSApi;
use OfflineAgency\LaravelEmailChef\Entities\Error;
use OfflineAgency\LaravelEmailChef\LaravelEmailChef;

function miscLoginFake(): array {
    return ['authkey' => 'fake-jwt', 'message' => 'ok'];
}

function fakeMiscError(): void {
    Http::fake([
        'https://app.emailchef.com/api/login' => Http::response(miscLoginFake(), 200),
        '*'                                   => Http::response(['error' => ['message' => 'fail']], 500),
    ]);
}

describe('Remaining error response paths', function (): void {
    it('returns Error for AccountInfosApi update on failure', function (): void {
        fakeMiscError();

        expect((new AccountInfosApi())->update([
            'firstname'    => 'John',
            'lastname'     => 'Doe',
            'business'     => 'Acme',
            'address_1'    => '1 Main St',
            'city'         => 'NY',
            'country'      => 'US',
            'phone_number' => '123',
            'postal_code'  => '10001',
            'website'      => 'https://acme.com',
        ]))->toBeInstanceOf(Error::class);
    });

    it('returns Error for AutorespondersApi getCollection on failure', function (): void {
        fakeMiscError();

        expect((new AutorespondersApi())->getCollection(10, 0, 'name', 'asc'))->toBeInstanceOf(Error::class);
    });

    it('returns Error for BlockingsApi getCollection on failure', function (): void {
        fakeMiscError();

        expect((new BlockingsApi())->getCollection('test', 10, 0))->toBeInstanceOf(Error::class);
    });

    it('returns Error for CampaignsApi getCollection on failure', function (): void {
        fakeMiscError();

        expect((new CampaignsApi())->getCollection('active', 10, 0, 'name', 'asc'))->toBeInstanceOf(Error::class);
    });

    it('returns Error for ContactsApi getCollection on failure', function (): void {
        fakeMiscError();

        expect((new ContactsApi())->getCollection('active', '1', 10, 0, 'email', 'asc'))->toBeInstanceOf(Error::class);
    });

    it('returns Error for SMSApi send on failure', function (): void {
        fakeMiscError();

        expect((new SMSApi())->send(['to' => '+1234567890', 'text' => 'test']))->toBeInstanceOf(Error::class);
    });
});

describe('ServiceProvider singleton', function (): void {
    it('resolves LaravelEmailChef from the container', function (): void {
        Http::fake([
            'https://app.emailchef.com/api/login' => Http::response(miscLoginFake(), 200),
        ]);

        $instance = app('laravel-email-chef');

        expect($instance)->toBeInstanceOf(LaravelEmailChef::class);
    });
});

describe('Hydratable null constructor edge case', function (): void {
    it('returns empty instance when class has no constructor', function (): void {
        // Create an anonymous class without a constructor that uses Hydratable
        $class = new class() {
            use OfflineAgency\LaravelEmailChef\Entities\Hydratable;
        };

        $result = $class::fromResponse((object) ['foo' => 'bar']);

        expect($result)->toBeInstanceOf($class::class);
    });
});
