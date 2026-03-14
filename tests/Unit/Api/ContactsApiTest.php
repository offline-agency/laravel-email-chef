<?php

declare(strict_types=1);

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;
use OfflineAgency\LaravelEmailChef\Api\Resources\ContactsApi;
use OfflineAgency\LaravelEmailChef\Entities\Contacts\CountContactEntity;
use OfflineAgency\LaravelEmailChef\Entities\Contacts\CreatedContactEntity;
use OfflineAgency\LaravelEmailChef\Entities\Contacts\GetCollection;
use OfflineAgency\LaravelEmailChef\Entities\Contacts\GetInstance;
use OfflineAgency\LaravelEmailChef\Entities\Contacts\UpdatedContactEntity;
use OfflineAgency\LaravelEmailChef\Entities\Error;

function contactsLoginFake(): array {
    return ['authkey' => 'fake-jwt', 'message' => 'ok'];
}

function contactItem(): array {
    return [
        'status'              => 'active',
        'email'               => 'john@example.com',
        'firstname'           => 'John',
        'lastname'            => 'Doe',
        'ip'                  => '127.0.0.1',
        'country'             => 'IT',
        'city'                => 'Rome',
        'added_by'            => 'ADMIN',
        'addition_time'       => '2024-01-01 10:00:00',
        'removed_by'          => null,
        'privacy_accepted'    => true,
        'terms_accepted'      => true,
        'newsletter_accepted' => true,
        'blacklisted'         => false,
        'customFields'        => [],
        'rating'              => 5,
    ];
}

describe('ContactsApi', function (): void {
    it('returns a CountContactEntity for count()', function (): void {
        Http::fake([
            'https://app.emailchef.com/api/login' => Http::response(contactsLoginFake(), 200),
            '*'                                   => Http::response(['totalcount' => 42], 200),
        ]);

        $result = (new ContactsApi())->count('97322');

        expect($result)->toBeInstanceOf(CountContactEntity::class);

        Http::assertSent(static fn ($req) => str_contains($req->url(), 'contacts/count'));
    });

    it('returns a Collection of GetCollection for getCollection()', function (): void {
        Http::fake([
            'https://app.emailchef.com/api/login' => Http::response(contactsLoginFake(), 200),
            '*'                                   => Http::response([contactItem()], 200),
        ]);

        $result = (new ContactsApi())->getCollection('active', '97322', 10, 0, null, null);

        expect($result)->toBeInstanceOf(Collection::class)
            ->and($result->first())->toBeInstanceOf(GetCollection::class);

        Http::assertSent(static fn ($req) => $req->method() === 'GET');
    });

    it('returns a GetInstance entity for getInstance()', function (): void {
        Http::fake([
            'https://app.emailchef.com/api/login' => Http::response(contactsLoginFake(), 200),
            '*'                                   => Http::response(contactItem(), 200),
        ]);

        $result = (new ContactsApi())->getInstance('656023', '97322');

        expect($result)->toBeInstanceOf(GetInstance::class)
            ->and($result->email)->toBe('john@example.com');
    });

    it('returns a CreatedContactEntity for create()', function (): void {
        Http::fake([
            'https://app.emailchef.com/api/login' => Http::response(contactsLoginFake(), 200),
            '*'                                   => Http::response(['contact_id' => '999'], 200),
        ]);

        $result = (new ContactsApi())->create([
            'list_id' => '97322',
            'email'   => 'new@example.com',
        ]);

        expect($result)->toBeInstanceOf(CreatedContactEntity::class);

        Http::assertSent(static fn ($req) => $req->method() === 'POST');
    });

    it('returns validation errors for create() with missing required fields', function (): void {
        Http::fake([
            'https://app.emailchef.com/api/login' => Http::response(contactsLoginFake(), 200),
        ]);

        $result = (new ContactsApi())->create([]);

        expect($result)->toBeInstanceOf(Illuminate\Support\MessageBag::class);
    });

    it('returns an UpdatedContactEntity for update()', function (): void {
        Http::fake([
            'https://app.emailchef.com/api/login' => Http::response(contactsLoginFake(), 200),
            '*'                                   => Http::response(['contact_id' => '656023'], 200),
        ]);

        $result = (new ContactsApi())->update('656023', ['firstname' => 'Jane']);

        expect($result)->toBeInstanceOf(UpdatedContactEntity::class);

        Http::assertSent(static fn ($req) => $req->method() === 'PUT' && str_contains($req->url(), 'contacts/656023'));
    });

    it('returns a string message for delete()', function (): void {
        Http::fake([
            'https://app.emailchef.com/api/login' => Http::response(contactsLoginFake(), 200),
            '*'                                   => Http::response('Contact deleted', 200),
        ]);

        $result = (new ContactsApi())->delete('97322', '656023');

        expect($result)->toBeString();

        Http::assertSent(static fn ($req) => $req->method() === 'DELETE' && str_contains($req->url(), 'contacts/656023'));
    });

    it('returns an Error for non-200 responses', function (int $status): void {
        Http::fake([
            'https://app.emailchef.com/api/login' => Http::response(contactsLoginFake(), 200),
            '*'                                   => Http::response(['error' => ['message' => 'Server error']], $status),
        ]);

        expect((new ContactsApi())->count('97322'))->toBeInstanceOf(Error::class);
    })->with([401, 404, 500]);
});
