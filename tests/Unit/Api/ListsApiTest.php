<?php

declare(strict_types=1);

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;
use OfflineAgency\LaravelEmailChef\Api\Resources\ListsApi;
use OfflineAgency\LaravelEmailChef\Entities\Error;
use OfflineAgency\LaravelEmailChef\Entities\Lists\ContactList;
use OfflineAgency\LaravelEmailChef\Entities\Lists\GetCollection;
use OfflineAgency\LaravelEmailChef\Entities\Lists\GetInstance;
use OfflineAgency\LaravelEmailChef\Entities\Lists\GetStats;
use OfflineAgency\LaravelEmailChef\Entities\Lists\UpdateList;

function listsLoginFake(): array {
    return ['authkey' => 'fake-jwt', 'message' => 'ok'];
}

function listItem(): array {
    return [
        'id'           => '97322',
        'name'         => 'My Newsletter',
        'description'  => 'Main list',
        'date'         => '2024-01-01',
        'active'       => '100',
        'subscribed'   => '90',
        'unsubscribed' => '5',
        'bounced'      => '2',
        'reported'     => '1',
        'segments'     => '3',
        'forms'        => 0,
    ];
}

describe('ListsApi', function (): void {
    it('returns a Collection of GetCollection entities for getCollection()', function (): void {
        Http::fake([
            'https://app.emailchef.com/api/login' => Http::response(listsLoginFake(), 200),
            '*'                                   => Http::response([listItem()], 200),
        ]);

        $result = (new ListsApi())->getCollection(10, 0, 'n', 'a');

        expect($result)->toBeInstanceOf(Collection::class)
            ->and($result->first())->toBeInstanceOf(GetCollection::class)
            ->and($result->first()->id)->toBe('97322');

        Http::assertSent(static fn ($req) => $req->method() === 'GET' && str_contains($req->url(), 'lists'));
    });

    it('returns a GetInstance entity for getInstance()', function (): void {
        Http::fake([
            'https://app.emailchef.com/api/login' => Http::response(listsLoginFake(), 200),
            '*'                                   => Http::response(['name' => 'My Newsletter', 'description' => 'Main list'], 200),
        ]);

        $result = (new ListsApi())->getInstance('97322');

        expect($result)->toBeInstanceOf(GetInstance::class)
            ->and($result->name)->toBe('My Newsletter');
    });

    it('returns a GetStats entity for getStats()', function (): void {
        Http::fake([
            'https://app.emailchef.com/api/login' => Http::response(listsLoginFake(), 200),
            '*'                                   => Http::response([
                'total_list'       => [],
                'daily_delta_list' => [],
                'start_date'       => '2024-01-01',
                'last_date'        => '2024-06-01',
            ], 200),
        ]);

        $result = (new ListsApi())->getStats('97322', '2024-01-01', '2024-06-01');

        expect($result)->toBeInstanceOf(GetStats::class)
            ->and($result->start_date)->toBe('2024-01-01');
    });

    it('returns a string message for unsubscribe()', function (): void {
        Http::fake([
            'https://app.emailchef.com/api/login' => Http::response(listsLoginFake(), 200),
            '*'                                   => Http::response('Contact unsubscribed', 200),
        ]);

        $result = (new ListsApi())->unsubscribe('97322', '12345');

        expect($result)->toBeString();
    });

    it('returns a ContactList entity for create()', function (): void {
        Http::fake([
            'https://app.emailchef.com/api/login' => Http::response(listsLoginFake(), 200),
            '*'                                   => Http::response(['list_id' => '111'], 200),
        ]);

        $result = (new ListsApi())->create([
            'list_name'        => 'Test List',
            'list_description' => 'Created via test',
        ]);

        expect($result)->toBeInstanceOf(ContactList::class)
            ->and($result->list_id)->toBe('111');

        Http::assertSent(static fn ($req) => $req->method() === 'POST');
    });

    it('returns validation errors for create() with missing list_name', function (): void {
        Http::fake([
            'https://app.emailchef.com/api/login' => Http::response(listsLoginFake(), 200),
        ]);

        $result = (new ListsApi())->create([]);

        expect($result)->toBeInstanceOf(Illuminate\Support\MessageBag::class);
    });

    it('returns an UpdateList entity for update()', function (): void {
        Http::fake([
            'https://app.emailchef.com/api/login' => Http::response(listsLoginFake(), 200),
            '*'                                   => Http::response(['list_id' => '97322'], 200),
        ]);

        $result = (new ListsApi())->update('97322', [
            'list_name'        => 'Updated List',
            'list_description' => 'Updated',
        ]);

        expect($result)->toBeInstanceOf(UpdateList::class);

        Http::assertSent(static fn ($req) => $req->method() === 'PUT' && str_contains($req->url(), 'lists/97322'));
    });

    it('returns a string message for delete()', function (): void {
        Http::fake([
            'https://app.emailchef.com/api/login' => Http::response(listsLoginFake(), 200),
            '*'                                   => Http::response('List deleted', 200),
        ]);

        $result = (new ListsApi())->delete('97322');

        expect($result)->toBeString();

        Http::assertSent(static fn ($req) => $req->method() === 'DELETE');
    });

    it('returns ContactList or Error for subscribe()', function (): void {
        Http::fake([
            'https://app.emailchef.com/api/login' => Http::response(listsLoginFake(), 200),
            '*'                                   => Http::response(['list_id' => '97322'], 200),
        ]);

        $result = (new ListsApi())->subscribe('97322', '656023');

        expect($result)->toBeInstanceOf(ContactList::class);

        Http::assertSent(static fn ($req) => $req->method() === 'POST' && str_contains($req->url(), 'subscribe'));
    });

    it('returns an Error for non-200 responses', function (int $status): void {
        Http::fake([
            'https://app.emailchef.com/api/login' => Http::response(listsLoginFake(), 200),
            '*'                                   => Http::response(['error' => ['message' => 'Server error']], $status),
        ]);

        expect((new ListsApi())->getCollection(10, 0, 'n', 'a'))->toBeInstanceOf(Error::class);
    })->with([400, 401, 404, 422, 500]);
});
