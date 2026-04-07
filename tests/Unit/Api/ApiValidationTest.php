<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Http;
use Illuminate\Support\MessageBag;
use OfflineAgency\LaravelEmailChef\Api\Resources\AutorespondersApi;
use OfflineAgency\LaravelEmailChef\Api\Resources\CampaignsApi;
use OfflineAgency\LaravelEmailChef\Api\Resources\CustomFieldsApi;
use OfflineAgency\LaravelEmailChef\Api\Resources\SegmentsApi;

function validationLoginFake(): array {
    return ['authkey' => 'fake-jwt', 'message' => 'ok'];
}

describe('AutorespondersApi validation', function (): void {
    beforeEach(function (): void {
        Http::fake([
            'https://app.emailchef.com/api/login' => Http::response(validationLoginFake(), 200),
        ]);
    });

    it('returns validation errors for createInstance with empty data', function (): void {
        expect((new AutorespondersApi())->createInstance([]))->toBeInstanceOf(MessageBag::class);
    });

    it('returns validation errors for updateInstance with empty data', function (): void {
        expect((new AutorespondersApi())->updateInstance('1', []))->toBeInstanceOf(MessageBag::class);
    });

    it('returns validation errors for sendTestEmail with empty data', function (): void {
        expect((new AutorespondersApi())->sendTestEmail('1', []))->toBeInstanceOf(MessageBag::class);
    });

    it('returns validation errors for cloning with empty data', function (): void {
        expect((new AutorespondersApi())->cloning([]))->toBeInstanceOf(MessageBag::class);
    });
});

describe('CampaignsApi validation', function (): void {
    beforeEach(function (): void {
        Http::fake([
            'https://app.emailchef.com/api/login' => Http::response(validationLoginFake(), 200),
        ]);
    });

    it('returns validation errors for createInstance with empty data', function (): void {
        expect((new CampaignsApi())->createInstance([]))->toBeInstanceOf(MessageBag::class);
    });

    it('returns validation errors for updateInstance with empty data', function (): void {
        expect((new CampaignsApi())->updateInstance('1', []))->toBeInstanceOf(MessageBag::class);
    });

    it('returns validation errors for sendTestEmail with empty data', function (): void {
        expect((new CampaignsApi())->sendTestEmail('1', []))->toBeInstanceOf(MessageBag::class);
    });

    it('returns validation errors for cloning with empty data', function (): void {
        expect((new CampaignsApi())->cloning([]))->toBeInstanceOf(MessageBag::class);
    });
});

describe('CustomFieldsApi validation', function (): void {
    beforeEach(function (): void {
        Http::fake([
            'https://app.emailchef.com/api/login' => Http::response(validationLoginFake(), 200),
        ]);
    });

    it('returns validation errors for create with invalid types', function (): void {
        expect((new CustomFieldsApi())->create('1', ['default_value' => 'not-an-integer']))->toBeInstanceOf(MessageBag::class);
    });

    it('returns validation errors for update with invalid types', function (): void {
        expect((new CustomFieldsApi())->update('1', ['name' => ['array-not-string']]))->toBeInstanceOf(MessageBag::class);
    });
});

describe('SegmentsApi validation', function (): void {
    beforeEach(function (): void {
        Http::fake([
            'https://app.emailchef.com/api/login' => Http::response(validationLoginFake(), 200),
        ]);
    });

    it('returns validation errors for createInstance with empty data', function (): void {
        expect((new SegmentsApi())->createInstance(1, []))->toBeInstanceOf(MessageBag::class);
    });

    it('returns validation errors for updateInstance with empty data', function (): void {
        expect((new SegmentsApi())->updateInstance('1', '2', []))->toBeInstanceOf(MessageBag::class);
    });
});
