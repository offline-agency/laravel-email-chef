<?php

declare(strict_types=1);

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;
use OfflineAgency\LaravelEmailChef\Api\Resources\CampaignsApi;
use OfflineAgency\LaravelEmailChef\Entities\Campaigns\Campaign;
use OfflineAgency\LaravelEmailChef\Entities\Campaigns\CampaignArchiving;
use OfflineAgency\LaravelEmailChef\Entities\Campaigns\CampaignCollection;
use OfflineAgency\LaravelEmailChef\Entities\Campaigns\CampaignCount;
use OfflineAgency\LaravelEmailChef\Entities\Campaigns\CampaignDeletion;
use OfflineAgency\LaravelEmailChef\Entities\Campaigns\CancelScheduling;
use OfflineAgency\LaravelEmailChef\Entities\Campaigns\Cloning;
use OfflineAgency\LaravelEmailChef\Entities\Campaigns\CreateCampaign;
use OfflineAgency\LaravelEmailChef\Entities\Campaigns\LinkCollection;
use OfflineAgency\LaravelEmailChef\Entities\Campaigns\Schedule;
use OfflineAgency\LaravelEmailChef\Entities\Campaigns\SendCampaign;
use OfflineAgency\LaravelEmailChef\Entities\Campaigns\SendTestEmail;
use OfflineAgency\LaravelEmailChef\Entities\Campaigns\UpdateCampaign;
use OfflineAgency\LaravelEmailChef\Entities\Error;

function campaignsLoginFake(): array {
    return ['authkey' => 'fake-jwt', 'message' => 'ok'];
}

function campaignInstanceBody(): array {
    return [
        'instance_in' => [
            'id'                     => null,
            'name'                   => 'Summer Sale',
            'type'                   => 'standard',
            'subject'                => null,
            'new_dd'                 => '1',
            'html_body'              => '<p>Hello</p>',
            'sender_id'              => '1',
            'template_id'            => null,
            'sent_count_cache'       => '0',
            'open_count_cache'       => '0',
            'click_count_cache'      => '0',
            'cache_update_time'      => null,
            'ga_enabled'             => '0',
            'lists'                  => [],
            'creativity_type'        => 'html',
            'template_source'        => 'custom',
            'template_editor_id'     => '1',
            'default_order_segments' => '0',
            'campaign'               => [],
        ],
    ];
}

describe('CampaignsApi', function (): void {
    it('returns a CampaignCount entity for getCount()', function (): void {
        Http::fake([
            'https://app.emailchef.com/api/login' => Http::response(campaignsLoginFake(), 200),
            '*'                                   => Http::response(['count' => 5], 200),
        ]);

        expect((new CampaignsApi())->getCount())->toBeInstanceOf(CampaignCount::class);

        Http::assertSent(static fn ($req) => str_contains($req->url(), 'campaigns/count'));
    });

    it('returns a Collection of CampaignCollection for getCollection()', function (): void {
        Http::fake([
            'https://app.emailchef.com/api/login' => Http::response(campaignsLoginFake(), 200),
            '*'                                   => Http::response([
                ['id' => '1', 'name' => 'Campaign 1'],
            ], 200),
        ]);

        $result = (new CampaignsApi())->getCollection('active', 10, 0, 'name', 'asc');

        expect($result)->toBeInstanceOf(Collection::class)
            ->and($result->first())->toBeInstanceOf(CampaignCollection::class);
    });

    it('returns a Campaign entity for getInstance()', function (): void {
        Http::fake([
            'https://app.emailchef.com/api/login' => Http::response(campaignsLoginFake(), 200),
            '*'                                   => Http::response(['id' => '1', 'name' => 'My Campaign'], 200),
        ]);

        expect((new CampaignsApi())->getInstance('1'))->toBeInstanceOf(Campaign::class);
    });

    it('returns a CreateCampaign entity for createInstance()', function (): void {
        Http::fake([
            'https://app.emailchef.com/api/login' => Http::response(campaignsLoginFake(), 200),
            '*'                                   => Http::response(['id' => '10'], 200),
        ]);

        $result = (new CampaignsApi())->createInstance(campaignInstanceBody());

        expect($result)->toBeInstanceOf(CreateCampaign::class);

        Http::assertSent(static fn ($req) => $req->method() === 'POST');
    });

    it('returns an UpdateCampaign entity for updateInstance()', function (): void {
        Http::fake([
            'https://app.emailchef.com/api/login' => Http::response(campaignsLoginFake(), 200),
            '*'                                   => Http::response(['id' => '10'], 200),
        ]);

        $result = (new CampaignsApi())->updateInstance('10', campaignInstanceBody());

        expect($result)->toBeInstanceOf(UpdateCampaign::class);

        Http::assertSent(static fn ($req) => $req->method() === 'PUT');
    });

    it('returns a CampaignDeletion entity for deleteInstance()', function (): void {
        Http::fake([
            'https://app.emailchef.com/api/login' => Http::response(campaignsLoginFake(), 200),
            '*'                                   => Http::response(['deleted' => true], 200),
        ]);

        expect((new CampaignsApi())->deleteInstance('10'))->toBeInstanceOf(CampaignDeletion::class);

        Http::assertSent(static fn ($req) => $req->method() === 'DELETE');
    });

    it('returns a SendTestEmail entity for sendTestEmail()', function (): void {
        Http::fake([
            'https://app.emailchef.com/api/login' => Http::response(campaignsLoginFake(), 200),
            '*'                                   => Http::response(['sent' => true], 200),
        ]);

        $result = (new CampaignsApi())->sendTestEmail('10', [
            'instance_in' => [
                'id'      => '10',
                'command' => 'test',
                'email'   => 'test@example.com',
            ],
        ]);

        expect($result)->toBeInstanceOf(SendTestEmail::class);
    });

    it('returns a SendCampaign entity for sendCampaign()', function (): void {
        Http::fake([
            'https://app.emailchef.com/api/login' => Http::response(campaignsLoginFake(), 200),
            '*'                                   => Http::response(['queued' => true], 200),
        ]);

        expect((new CampaignsApi())->sendCampaign('10', []))->toBeInstanceOf(SendCampaign::class);
    });

    it('returns a Schedule entity for schedule()', function (): void {
        Http::fake([
            'https://app.emailchef.com/api/login' => Http::response(campaignsLoginFake(), 200),
            '*'                                   => Http::response(['scheduled' => true], 200),
        ]);

        expect((new CampaignsApi())->schedule('10', []))->toBeInstanceOf(Schedule::class);
    });

    it('returns a CancelScheduling entity for cancelScheduling()', function (): void {
        Http::fake([
            'https://app.emailchef.com/api/login' => Http::response(campaignsLoginFake(), 200),
            '*'                                   => Http::response(['cancelled' => true], 200),
        ]);

        expect((new CampaignsApi())->cancelScheduling('10'))->toBeInstanceOf(CancelScheduling::class);
    });

    it('returns a CampaignArchiving entity for archive()', function (): void {
        Http::fake([
            'https://app.emailchef.com/api/login' => Http::response(campaignsLoginFake(), 200),
            '*'                                   => Http::response(['archived' => true], 200),
        ]);

        expect((new CampaignsApi())->archive('10'))->toBeInstanceOf(CampaignArchiving::class);
    });

    it('returns a CampaignArchiving entity for unarchive()', function (): void {
        Http::fake([
            'https://app.emailchef.com/api/login' => Http::response(campaignsLoginFake(), 200),
            '*'                                   => Http::response(['archived' => false], 200),
        ]);

        expect((new CampaignsApi())->unarchive('10'))->toBeInstanceOf(CampaignArchiving::class);
    });

    it('returns a Cloning entity for cloning()', function (): void {
        Http::fake([
            'https://app.emailchef.com/api/login' => Http::response(campaignsLoginFake(), 200),
            '*'                                   => Http::response(['id' => '11'], 200),
        ]);

        $result = (new CampaignsApi())->cloning(['instance_in' => ['id' => '10']]);

        expect($result)->toBeInstanceOf(Cloning::class);
    });

    it('returns a LinkCollection entity for getLinkCollection()', function (): void {
        Http::fake([
            'https://app.emailchef.com/api/login' => Http::response(campaignsLoginFake(), 200),
            '*'                                   => Http::response(['links' => []], 200),
        ]);

        expect((new CampaignsApi())->getLinkCollection('10'))->toBeInstanceOf(LinkCollection::class);
    });

    it('returns an Error for non-200 responses', function (int $status): void {
        Http::fake([
            'https://app.emailchef.com/api/login' => Http::response(campaignsLoginFake(), 200),
            '*'                                   => Http::response(['error' => ['message' => 'Server error']], $status),
        ]);

        expect((new CampaignsApi())->getCount())->toBeInstanceOf(Error::class);
    })->with([401, 404, 500]);
});
