<?php

declare(strict_types=1);

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;
use OfflineAgency\LaravelEmailChef\Api\Resources\AutorespondersApi;
use OfflineAgency\LaravelEmailChef\Entities\Autoresponders\Autoresponder;
use OfflineAgency\LaravelEmailChef\Entities\Autoresponders\AutoresponderActivation;
use OfflineAgency\LaravelEmailChef\Entities\Autoresponders\AutoresponderCollection;
use OfflineAgency\LaravelEmailChef\Entities\Autoresponders\AutoresponderCount;
use OfflineAgency\LaravelEmailChef\Entities\Autoresponders\AutoresponderDeletion;
use OfflineAgency\LaravelEmailChef\Entities\Autoresponders\AutoresponderLinks;
use OfflineAgency\LaravelEmailChef\Entities\Autoresponders\Cloning;
use OfflineAgency\LaravelEmailChef\Entities\Autoresponders\CreateAutoresponder;
use OfflineAgency\LaravelEmailChef\Entities\Autoresponders\SendTestEmail;
use OfflineAgency\LaravelEmailChef\Entities\Autoresponders\UpdateAutoresponder;
use OfflineAgency\LaravelEmailChef\Entities\Error;

function autorespondersLoginFake(): array {
    return ['authkey' => 'fake-jwt', 'message' => 'ok'];
}

function autoresponderInstanceBody(): array {
    return [
        'instance_in' => [
            'id'                     => null,
            'name'                   => 'Welcome Series',
            'type'                   => 'autoresponder',
            'subject'                => 'Welcome!',
            'new_dd'                 => '1',
            'html_body'              => '<p>Welcome</p>',
            'sender_id'              => '1',
            'template_id'            => null,
            'sent_count_cache'       => '0',
            'open_count_cache'       => '0',
            'click_count_cache'      => '0',
            'cache_update_time'      => null,
            'ga_enabled'             => '0',
            'creativity_type'        => 'html',
            'template_source'        => 'custom',
            'template_editor_id'     => '1',
            'default_order_segments' => '0',
            'lists'                  => [
                ['list_id' => '1', 'segment_id' => '0', 'list_name' => 'List', 'segment_name' => 'All'],
            ],
            'autoresponder' => [],
        ],
    ];
}

describe('AutorespondersApi', function (): void {
    it('returns an AutoresponderCount entity for getCount()', function (): void {
        Http::fake([
            'https://app.emailchef.com/api/login' => Http::response(autorespondersLoginFake(), 200),
            '*'                                   => Http::response(['count' => 2], 200),
        ]);

        expect((new AutorespondersApi())->getCount())->toBeInstanceOf(AutoresponderCount::class);

        Http::assertSent(static fn ($req) => str_contains($req->url(), 'autoresponders/count'));
    });

    it('returns a Collection of AutoresponderCollection for getCollection()', function (): void {
        Http::fake([
            'https://app.emailchef.com/api/login' => Http::response(autorespondersLoginFake(), 200),
            '*'                                   => Http::response([['id' => '1', 'name' => 'AR 1']], 200),
        ]);

        $result = (new AutorespondersApi())->getCollection(10, 0, 'name', 'asc');

        expect($result)->toBeInstanceOf(Collection::class)
            ->and($result->first())->toBeInstanceOf(AutoresponderCollection::class);
    });

    it('returns an Autoresponder entity for getInstance()', function (): void {
        Http::fake([
            'https://app.emailchef.com/api/login' => Http::response(autorespondersLoginFake(), 200),
            '*'                                   => Http::response(['id' => '1', 'name' => 'Welcome'], 200),
        ]);

        expect((new AutorespondersApi())->getInstance('1'))->toBeInstanceOf(Autoresponder::class);
    });

    it('returns a CreateAutoresponder entity for createInstance()', function (): void {
        Http::fake([
            'https://app.emailchef.com/api/login' => Http::response(autorespondersLoginFake(), 200),
            '*'                                   => Http::response(['id' => '20'], 200),
        ]);

        $result = (new AutorespondersApi())->createInstance(autoresponderInstanceBody());

        expect($result)->toBeInstanceOf(CreateAutoresponder::class);
    });

    it('returns an UpdateAutoresponder entity for updateInstance()', function (): void {
        Http::fake([
            'https://app.emailchef.com/api/login' => Http::response(autorespondersLoginFake(), 200),
            '*'                                   => Http::response(['id' => '20'], 200),
        ]);

        $result = (new AutorespondersApi())->updateInstance('20', autoresponderInstanceBody());

        expect($result)->toBeInstanceOf(UpdateAutoresponder::class);
    });

    it('returns an AutoresponderDeletion entity for deleteInstance()', function (): void {
        Http::fake([
            'https://app.emailchef.com/api/login' => Http::response(autorespondersLoginFake(), 200),
            '*'                                   => Http::response(['deleted' => true], 200),
        ]);

        expect((new AutorespondersApi())->deleteInstance('20'))->toBeInstanceOf(AutoresponderDeletion::class);
    });

    it('returns a SendTestEmail entity for sendTestEmail()', function (): void {
        Http::fake([
            'https://app.emailchef.com/api/login' => Http::response(autorespondersLoginFake(), 200),
            '*'                                   => Http::response(['sent' => true], 200),
        ]);

        $result = (new AutorespondersApi())->sendTestEmail('20', [
            'instance_in' => ['id' => '20', 'command' => 'test', 'email' => 'test@example.com'],
        ]);

        expect($result)->toBeInstanceOf(SendTestEmail::class);
    });

    it('returns an AutoresponderActivation entity for activate()', function (): void {
        Http::fake([
            'https://app.emailchef.com/api/login' => Http::response(autorespondersLoginFake(), 200),
            '*'                                   => Http::response(['active' => true], 200),
        ]);

        expect((new AutorespondersApi())->activate('20', []))->toBeInstanceOf(AutoresponderActivation::class);
    });

    it('returns an AutoresponderActivation entity for deactivate()', function (): void {
        Http::fake([
            'https://app.emailchef.com/api/login' => Http::response(autorespondersLoginFake(), 200),
            '*'                                   => Http::response(['active' => false], 200),
        ]);

        expect((new AutorespondersApi())->deactivate('20', []))->toBeInstanceOf(AutoresponderActivation::class);
    });

    it('returns a Cloning entity for cloning()', function (): void {
        Http::fake([
            'https://app.emailchef.com/api/login' => Http::response(autorespondersLoginFake(), 200),
            '*'                                   => Http::response(['id' => '21'], 200),
        ]);

        $result = (new AutorespondersApi())->cloning(['instance_in' => ['id' => '20']]);

        expect($result)->toBeInstanceOf(Cloning::class);
    });

    it('returns an AutoresponderLinks entity for getLinksCollection()', function (): void {
        Http::fake([
            'https://app.emailchef.com/api/login' => Http::response(autorespondersLoginFake(), 200),
            '*'                                   => Http::response(['links' => []], 200),
        ]);

        expect((new AutorespondersApi())->getLinksCollection('20'))->toBeInstanceOf(AutoresponderLinks::class);
    });

    it('returns an Error for non-200 responses', function (int $status): void {
        Http::fake([
            'https://app.emailchef.com/api/login' => Http::response(autorespondersLoginFake(), 200),
            '*'                                   => Http::response(['error' => ['message' => 'Server error']], $status),
        ]);

        expect((new AutorespondersApi())->getCount())->toBeInstanceOf(Error::class);
    })->with([401, 404, 500]);
});
