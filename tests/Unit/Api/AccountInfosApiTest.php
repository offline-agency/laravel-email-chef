<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Http;
use OfflineAgency\LaravelEmailChef\Api\Resources\AccountInfosApi;
use OfflineAgency\LaravelEmailChef\Entities\AccountInfos\GetInstance;
use OfflineAgency\LaravelEmailChef\Entities\Error;

function accountInfosLoginFake(): array {
    return ['authkey' => 'fake-jwt', 'message' => 'ok'];
}

describe('AccountInfosApi', function (): void {
    it('returns a GetInstance entity for getInstance()', function (): void {
        Http::fake([
            'https://app.emailchef.com/api/login' => Http::response(accountInfosLoginFake(), 200),
            '*'                                   => Http::response(['billingInfo' => null], 200),
        ]);

        $result = (new AccountInfosApi())->getInstance('123');

        expect($result)->toBeInstanceOf(GetInstance::class);

        Http::assertSent(static fn ($req) => str_contains($req->url(), 'account_infos/123'));
    });

    it('returns an Error for getInstance() on non-200', function (): void {
        Http::fake([
            'https://app.emailchef.com/api/login' => Http::response(accountInfosLoginFake(), 200),
            '*'                                   => Http::response(['error' => ['message' => 'Server error']], 404),
        ]);

        expect((new AccountInfosApi())->getInstance('123'))->toBeInstanceOf(Error::class);
    });

    it('returns updated data for update()', function (): void {
        Http::fake([
            'https://app.emailchef.com/api/login' => Http::response(accountInfosLoginFake(), 200),
            '*'                                   => Http::response(['success' => true], 200),
        ]);

        $result = (new AccountInfosApi())->update([
            'firstname'    => 'John',
            'lastname'     => 'Doe',
            'business'     => 'Acme',
            'address_1'    => '123 Main St',
            'city'         => 'Rome',
            'country'      => 'IT',
            'phone_number' => '+39 333 123456',
            'postal_code'  => '00100',
            'website'      => 'https://acme.com',
        ]);

        expect($result)->not->toBeNull();

        Http::assertSent(static fn ($req) => $req->method() === 'PUT' && str_contains($req->url(), 'account_infos'));
    });

    it('returns validation errors for update() with missing fields', function (): void {
        Http::fake([
            'https://app.emailchef.com/api/login' => Http::response(accountInfosLoginFake(), 200),
        ]);

        $result = (new AccountInfosApi())->update([]);

        expect($result)->toBeInstanceOf(Illuminate\Support\MessageBag::class);
    });
});
