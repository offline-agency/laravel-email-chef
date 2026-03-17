<?php

declare(strict_types=1);

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;
use OfflineAgency\LaravelEmailChef\Api\Resources\ImportTasksApi;
use OfflineAgency\LaravelEmailChef\Entities\Error;
use OfflineAgency\LaravelEmailChef\Entities\ImportTasks\CreatedImportTasksEntity;
use OfflineAgency\LaravelEmailChef\Entities\ImportTasks\GetCollection;
use OfflineAgency\LaravelEmailChef\Entities\ImportTasks\GetInstance;

function importTasksLoginFake(): array {
    return ['authkey' => 'fake-jwt', 'message' => 'ok'];
}

function importTaskItem(): array {
    return [
        'id'                 => '10',
        'list_id'            => '97322',
        'creation_time'      => '2024-01-01',
        'imported_success'   => '50',
        'imported_fail'      => '2',
        'imported_updated'   => '3',
        'progress'           => '100',
        'uploaded_file_name' => 'contacts.csv',
        'notification_link'  => '',
    ];
}

describe('ImportTasksApi', function (): void {
    it('returns a Collection of GetCollection for getCollection()', function (): void {
        Http::fake([
            'https://app.emailchef.com/api/login' => Http::response(importTasksLoginFake(), 200),
            '*'                                   => Http::response([importTaskItem()], 200),
        ]);

        $result = (new ImportTasksApi())->getCollection();

        expect($result)->toBeInstanceOf(Collection::class)
            ->and($result->first())->toBeInstanceOf(GetCollection::class);

        Http::assertSent(static fn ($req) => str_contains($req->url(), 'importtasks'));
    });

    it('returns a GetInstance entity for getInstance()', function (): void {
        Http::fake([
            'https://app.emailchef.com/api/login' => Http::response(importTasksLoginFake(), 200),
            '*'                                   => Http::response(importTaskItem(), 200),
        ]);

        $result = (new ImportTasksApi())->getInstance('10');

        expect($result)->toBeInstanceOf(GetInstance::class);
    });

    it('returns a CreatedImportTasksEntity for create()', function (): void {
        Http::fake([
            'https://app.emailchef.com/api/login' => Http::response(importTasksLoginFake(), 200),
            '*'                                   => Http::response(['id' => '11'], 200),
        ]);

        $result = (new ImportTasksApi())->create('97322', [
            'contacts' => [
                ['email' => 'a@example.com', 'firstname' => 'Alice'],
            ],
        ]);

        expect($result)->toBeInstanceOf(CreatedImportTasksEntity::class);

        Http::assertSent(static fn ($req) => $req->method() === 'POST' && str_contains($req->url(), 'import'));
    });

    it('returns validation errors for create() with missing contacts', function (): void {
        Http::fake([
            'https://app.emailchef.com/api/login' => Http::response(importTasksLoginFake(), 200),
        ]);

        $result = (new ImportTasksApi())->create('97322', []);

        expect($result)->toBeInstanceOf(Illuminate\Support\MessageBag::class);
    });

    it('returns an Error for non-200 responses', function (int $status): void {
        Http::fake([
            'https://app.emailchef.com/api/login' => Http::response(importTasksLoginFake(), 200),
            '*'                                   => Http::response(['error' => ['message' => 'Server error']], $status),
        ]);

        expect((new ImportTasksApi())->getCollection())->toBeInstanceOf(Error::class);
    })->with([401, 404, 500]);
});
