<?php

declare(strict_types=1);

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;
use OfflineAgency\LaravelEmailChef\Api\Resources\BlockingsApi;
use OfflineAgency\LaravelEmailChef\Entities\Blockings\CountBlockingsEntity;
use OfflineAgency\LaravelEmailChef\Entities\Blockings\CreatedBlockingsEntity;
use OfflineAgency\LaravelEmailChef\Entities\Blockings\GetCollection;
use OfflineAgency\LaravelEmailChef\Entities\Error;

function blockingsLoginFake(): array {
    return ['authkey' => 'fake-jwt', 'message' => 'ok'];
}

describe('BlockingsApi', function (): void {
    it('returns a Collection of GetCollection for getCollection()', function (): void {
        Http::fake([
            'https://app.emailchef.com/api/login' => Http::response(blockingsLoginFake(), 200),
            '*'                                   => Http::response([
                ['email' => 'spam@example.com', 'type' => 'email', 'totalcount' => '1'],
            ], 200),
        ]);

        $result = (new BlockingsApi())->getCollection('spam', 10, 0);

        expect($result)->toBeInstanceOf(Collection::class)
            ->and($result->first())->toBeInstanceOf(GetCollection::class);

        Http::assertSent(static fn ($req) => $req->method() === 'GET' && str_contains($req->url(), 'blockings'));
    });

    it('returns a CountBlockingsEntity for count()', function (): void {
        Http::fake([
            'https://app.emailchef.com/api/login' => Http::response(blockingsLoginFake(), 200),
            '*'                                   => Http::response(['totalcount' => '5'], 200),
        ]);

        $result = (new BlockingsApi())->count('');

        expect($result)->toBeInstanceOf(CountBlockingsEntity::class);
    });

    it('returns a CreatedBlockingsEntity for create()', function (): void {
        Http::fake([
            'https://app.emailchef.com/api/login' => Http::response(blockingsLoginFake(), 200),
            '*'                                   => Http::response(['email' => 'block@example.com'], 200),
        ]);

        $result = (new BlockingsApi())->create('block@example.com', 'email');

        expect($result)->toBeInstanceOf(CreatedBlockingsEntity::class);

        Http::assertSent(static fn ($req) => $req->method() === 'POST');
    });

    it('returns a string message for delete()', function (): void {
        Http::fake([
            'https://app.emailchef.com/api/login' => Http::response(blockingsLoginFake(), 200),
            '*'                                   => Http::response('Blocking deleted', 200),
        ]);

        $result = (new BlockingsApi())->delete('block@example.com');

        expect($result)->toBeString();

        Http::assertSent(static fn ($req) => $req->method() === 'DELETE');
    });

    it('returns an Error for non-200 responses', function (int $status): void {
        Http::fake([
            'https://app.emailchef.com/api/login' => Http::response(blockingsLoginFake(), 200),
            '*'                                   => Http::response(['error' => ['message' => 'Server error']], $status),
        ]);

        expect((new BlockingsApi())->count(''))->toBeInstanceOf(Error::class);
    })->with([401, 404, 500]);
});
