<?php

declare(strict_types=1);

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;
use OfflineAgency\LaravelEmailChef\Api\Resources\CustomFieldsApi;
use OfflineAgency\LaravelEmailChef\Entities\CustomFields\CountCustomFieldsEntity;
use OfflineAgency\LaravelEmailChef\Entities\CustomFields\CreatedCustomFieldsEntity;
use OfflineAgency\LaravelEmailChef\Entities\CustomFields\GetCollection;
use OfflineAgency\LaravelEmailChef\Entities\CustomFields\GetInstance;
use OfflineAgency\LaravelEmailChef\Entities\CustomFields\UpdatedCustomFieldsEntity;
use OfflineAgency\LaravelEmailChef\Entities\Error;

function customFieldsLoginFake(): array {
    return ['authkey' => 'fake-jwt', 'message' => 'ok'];
}

function customFieldItem(): array {
    return [
        'id'            => '42',
        'list_id'       => '97322',
        'name'          => 'company',
        'type_id'       => '1',
        'place_holder'  => 'Company',
        'options'       => [],
        'default_value' => '',
        'data_type'     => 'string',
    ];
}

describe('CustomFieldsApi', function (): void {
    it('returns a Collection of GetCollection for getCollection()', function (): void {
        Http::fake([
            'https://app.emailchef.com/api/login' => Http::response(customFieldsLoginFake(), 200),
            '*'                                   => Http::response([customFieldItem()], 200),
        ]);

        $result = (new CustomFieldsApi())->getCollection('97322');

        expect($result)->toBeInstanceOf(Collection::class)
            ->and($result->first())->toBeInstanceOf(GetCollection::class);

        Http::assertSent(static fn ($req) => str_contains($req->url(), 'customfields'));
    });

    it('returns a GetInstance entity for getInstance()', function (): void {
        Http::fake([
            'https://app.emailchef.com/api/login' => Http::response(customFieldsLoginFake(), 200),
            '*'                                   => Http::response(customFieldItem(), 200),
        ]);

        $result = (new CustomFieldsApi())->getInstance('42');

        expect($result)->toBeInstanceOf(GetInstance::class)
            ->and($result->name)->toBe('company');
    });

    it('returns a CountCustomFieldsEntity for count()', function (): void {
        Http::fake([
            'https://app.emailchef.com/api/login' => Http::response(customFieldsLoginFake(), 200),
            '*'                                   => Http::response(['count' => 3], 200),
        ]);

        $result = (new CustomFieldsApi())->count('97322');

        expect($result)->toBeInstanceOf(CountCustomFieldsEntity::class);
    });

    it('returns a CreatedCustomFieldsEntity for create()', function (): void {
        Http::fake([
            'https://app.emailchef.com/api/login' => Http::response(customFieldsLoginFake(), 200),
            '*'                                   => Http::response(['id' => '99'], 200),
        ]);

        $result = (new CustomFieldsApi())->create('97322', [
            'name'         => 'age',
            'data_type'    => 'integer',
            'place_holder' => 'Age',
        ]);

        expect($result)->toBeInstanceOf(CreatedCustomFieldsEntity::class);

        Http::assertSent(static fn ($req) => $req->method() === 'POST');
    });

    it('returns an UpdatedCustomFieldsEntity for update()', function (): void {
        Http::fake([
            'https://app.emailchef.com/api/login' => Http::response(customFieldsLoginFake(), 200),
            '*'                                   => Http::response(['id' => '42'], 200),
        ]);

        $result = (new CustomFieldsApi())->update('42', ['name' => 'company_name']);

        expect($result)->toBeInstanceOf(UpdatedCustomFieldsEntity::class);

        Http::assertSent(static fn ($req) => $req->method() === 'PUT');
    });

    it('returns a string message for delete()', function (): void {
        Http::fake([
            'https://app.emailchef.com/api/login' => Http::response(customFieldsLoginFake(), 200),
            '*'                                   => Http::response('Deleted', 200),
        ]);

        $result = (new CustomFieldsApi())->delete('42');

        expect($result)->toBeString()
            ->and($result)->toContain('42');

        Http::assertSent(static fn ($req) => $req->method() === 'DELETE');
    });

    it('returns an Error for non-200 responses', function (int $status): void {
        Http::fake([
            'https://app.emailchef.com/api/login' => Http::response(customFieldsLoginFake(), 200),
            '*'                                   => Http::response(['error' => ['message' => 'Server error']], $status),
        ]);

        expect((new CustomFieldsApi())->getCollection('97322'))->toBeInstanceOf(Error::class);
    })->with([401, 404, 500]);
});
