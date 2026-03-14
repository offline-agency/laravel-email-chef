<?php

declare(strict_types=1);

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;
use OfflineAgency\LaravelEmailChef\Api\Resources\PredefinedFieldsApi;
use OfflineAgency\LaravelEmailChef\Entities\Error;
use OfflineAgency\LaravelEmailChef\Entities\PredefinedFields\PredefinedFieldsEntity;

function predefinedFieldsLoginFake(): array {
    return ['authkey' => 'fake-jwt', 'message' => 'ok'];
}

describe('PredefinedFieldsApi', function (): void {
    it('returns a Collection of PredefinedFieldsEntity for getCollection()', function (): void {
        Http::fake([
            'https://app.emailchef.com/api/login' => Http::response(predefinedFieldsLoginFake(), 200),
            '*'                                   => Http::response([
                [
                    'id'           => '1',
                    'name'         => 'firstname',
                    'type_id'      => '1',
                    'place_holder' => 'First Name',
                    'reference'    => 'firstname',
                    'mandatory'    => '1',
                    'data_type'    => 'string',
                ],
            ], 200),
        ]);

        $result = (new PredefinedFieldsApi())->getCollection();

        expect($result)->toBeInstanceOf(Collection::class)
            ->and($result->first())->toBeInstanceOf(PredefinedFieldsEntity::class)
            ->and($result->first()->name)->toBe('firstname');

        Http::assertSent(static fn ($req) => str_contains($req->url(), 'predefinedfields'));
    });

    it('returns an Error on non-200 response', function (): void {
        Http::fake([
            'https://app.emailchef.com/api/login' => Http::response(predefinedFieldsLoginFake(), 200),
            '*'                                   => Http::response(['error' => ['message' => 'Server error']], 500),
        ]);

        expect((new PredefinedFieldsApi())->getCollection())->toBeInstanceOf(Error::class);
    });
});
