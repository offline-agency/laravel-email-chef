<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Http;
use OfflineAgency\LaravelEmailChef\Api\Resources\AutorespondersApi;
use OfflineAgency\LaravelEmailChef\Api\Resources\BlockingsApi;
use OfflineAgency\LaravelEmailChef\Api\Resources\CampaignsApi;
use OfflineAgency\LaravelEmailChef\Api\Resources\ContactsApi;
use OfflineAgency\LaravelEmailChef\Api\Resources\CustomFieldsApi;
use OfflineAgency\LaravelEmailChef\Api\Resources\ImportTasksApi;
use OfflineAgency\LaravelEmailChef\Api\Resources\ListsApi;
use OfflineAgency\LaravelEmailChef\Api\Resources\SegmentsApi;
use OfflineAgency\LaravelEmailChef\Api\Resources\SMSApi;
use OfflineAgency\LaravelEmailChef\Entities\Error;

function errorLoginFake(): array {
    return ['authkey' => 'fake-jwt', 'message' => 'ok'];
}

function fakeError(): void {
    Http::fake([
        'https://app.emailchef.com/api/login' => Http::response(errorLoginFake(), 200),
        '*'                                   => Http::response(['error' => ['message' => 'fail']], 500),
    ]);
}

describe('ListsApi error paths', function (): void {
    it('returns Error for getInstance on failure', function (): void {
        fakeError();

        expect((new ListsApi())->getInstance('1'))->toBeInstanceOf(Error::class);
    });

    it('returns Error for getStats on failure', function (): void {
        fakeError();

        expect((new ListsApi())->getStats('1', '2024-01-01', '2024-12-31'))->toBeInstanceOf(Error::class);
    });

    it('returns Error for unsubscribe on failure', function (): void {
        fakeError();

        expect((new ListsApi())->unsubscribe('1', '2'))->toBeInstanceOf(Error::class);
    });

    it('returns Error for create on failure', function (): void {
        fakeError();

        expect((new ListsApi())->create(['list_name' => 'Test']))->toBeInstanceOf(Error::class);
    });

    it('returns validation errors for update with missing list_name', function (): void {
        Http::fake([
            'https://app.emailchef.com/api/login' => Http::response(errorLoginFake(), 200),
        ]);

        $result = (new ListsApi())->update('1', []);

        expect($result)->toBeInstanceOf(Illuminate\Support\MessageBag::class);
    });

    it('returns Error for update on failure', function (): void {
        fakeError();

        expect((new ListsApi())->update('1', ['list_name' => 'Test']))->toBeInstanceOf(Error::class);
    });

    it('returns Error for delete on failure', function (): void {
        fakeError();

        expect((new ListsApi())->delete('1'))->toBeInstanceOf(Error::class);
    });

    it('returns Error for subscribe on failure', function (): void {
        fakeError();

        expect((new ListsApi())->subscribe('1', '2'))->toBeInstanceOf(Error::class);
    });
});

describe('ContactsApi error paths', function (): void {
    it('returns Error for getInstance on failure', function (): void {
        fakeError();

        expect((new ContactsApi())->getInstance('1', '2'))->toBeInstanceOf(Error::class);
    });

    it('returns Error for count on failure', function (): void {
        fakeError();

        expect((new ContactsApi())->count('1'))->toBeInstanceOf(Error::class);
    });

    it('returns Error for create on failure', function (): void {
        fakeError();

        expect((new ContactsApi())->create(['list_id' => '1', 'email' => 'a@b.com']))->toBeInstanceOf(Error::class);
    });

    it('returns Error for update on failure', function (): void {
        fakeError();

        expect((new ContactsApi())->update('1', ['email' => 'a@b.com']))->toBeInstanceOf(Error::class);
    });

    it('returns Error for delete on failure', function (): void {
        fakeError();

        expect((new ContactsApi())->delete('1', '2'))->toBeInstanceOf(Error::class);
    });
});

describe('CustomFieldsApi error paths', function (): void {
    it('returns Error for getInstance on failure', function (): void {
        fakeError();

        expect((new CustomFieldsApi())->getInstance('1'))->toBeInstanceOf(Error::class);
    });

    it('returns Error for count on failure', function (): void {
        fakeError();

        expect((new CustomFieldsApi())->count('1'))->toBeInstanceOf(Error::class);
    });

    it('returns Error for create on failure', function (): void {
        fakeError();

        expect((new CustomFieldsApi())->create('1', ['name' => 'Field', 'type_id' => '1']))->toBeInstanceOf(Error::class);
    });

    it('returns Error for update on failure', function (): void {
        fakeError();

        expect((new CustomFieldsApi())->update('1', ['name' => 'Field']))->toBeInstanceOf(Error::class);
    });

    it('returns Error for delete on failure', function (): void {
        fakeError();

        expect((new CustomFieldsApi())->delete('1'))->toBeInstanceOf(Error::class);
    });
});

describe('BlockingsApi error paths', function (): void {
    it('returns Error for count on failure', function (): void {
        fakeError();

        expect((new BlockingsApi())->count('test'))->toBeInstanceOf(Error::class);
    });

    it('returns Error for create on failure', function (): void {
        fakeError();

        expect((new BlockingsApi())->create('a@b.com', 'email'))->toBeInstanceOf(Error::class);
    });

    it('returns Error for delete on failure', function (): void {
        fakeError();

        expect((new BlockingsApi())->delete('a@b.com'))->toBeInstanceOf(Error::class);
    });
});

describe('ImportTasksApi error paths', function (): void {
    it('returns Error for getInstance on failure', function (): void {
        fakeError();

        expect((new ImportTasksApi())->getInstance('1'))->toBeInstanceOf(Error::class);
    });

    it('returns Error for create on failure', function (): void {
        fakeError();

        expect((new ImportTasksApi())->create('1', ['contacts' => [['email' => 'a@b.com']]]))->toBeInstanceOf(Error::class);
    });
});

describe('SegmentsApi error paths', function (): void {
    it('returns Error for getInstance on failure', function (): void {
        fakeError();

        expect((new SegmentsApi())->getInstance('1'))->toBeInstanceOf(Error::class);
    });

    it('returns Error for getCount on failure', function (): void {
        fakeError();

        expect((new SegmentsApi())->getCount('1'))->toBeInstanceOf(Error::class);
    });

    it('returns Error for getContactsCount on failure', function (): void {
        fakeError();

        expect((new SegmentsApi())->getContactsCount('1'))->toBeInstanceOf(Error::class);
    });

    it('returns Error for createInstance on failure', function (): void {
        fakeError();

        expect((new SegmentsApi())->createInstance(1, [
            'instance_in' => [
                'list_id'          => 1,
                'logic'            => 'and',
                'name'             => 'Seg',
                'condition_groups' => [
                    [
                        'logic'      => 'and',
                        'conditions' => [
                            ['comparable_id' => null, 'comparator_id' => 'eq', 'field_id' => 'email', 'name' => 'Email', 'value' => 'test'],
                        ],
                    ],
                ],
            ],
        ]))->toBeInstanceOf(Error::class);
    });

    it('returns Error for updateInstance on failure', function (): void {
        fakeError();

        expect((new SegmentsApi())->updateInstance('1', '2', [
            'instance_in' => [
                'list_id'          => 1,
                'logic'            => 'and',
                'name'             => 'Seg',
                'condition_groups' => [
                    [
                        'logic'      => 'and',
                        'conditions' => [
                            ['comparable_id' => null, 'comparator_id' => 'eq', 'field_id' => 'email', 'name' => 'Email', 'value' => 'test'],
                        ],
                    ],
                ],
            ],
        ]))->toBeInstanceOf(Error::class);
    });

    it('returns Error for deleteInstance on failure', function (): void {
        fakeError();

        expect((new SegmentsApi())->deleteInstance('1'))->toBeInstanceOf(Error::class);
    });
});

describe('CampaignsApi error paths', function (): void {
    it('returns Error for getInstance on failure', function (): void {
        fakeError();

        expect((new CampaignsApi())->getInstance('1'))->toBeInstanceOf(Error::class);
    });

    it('returns Error for createInstance on failure', function (): void {
        fakeError();

        expect((new CampaignsApi())->createInstance([
            'instance_in' => [
                'name'                   => 'C',
                'type'                   => 'campaign',
                'new_dd'                 => true,
                'html_body'              => '<p>hi</p>',
                'sender_id'              => '1',
                'sent_count_cache'       => 0,
                'open_count_cache'       => 0,
                'click_count_cache'      => 0,
                'ga_enabled'             => false,
                'creativity_type'        => 'html',
                'template_source'        => 'editor',
                'template_editor_id'     => '1',
                'default_order_segments' => 'asc',
            ],
        ]))->toBeInstanceOf(Error::class);
    });

    it('returns Error for updateInstance on failure', function (): void {
        fakeError();

        expect((new CampaignsApi())->updateInstance('1', [
            'instance_in' => [
                'name'                   => 'C',
                'type'                   => 'campaign',
                'new_dd'                 => true,
                'html_body'              => '<p>hi</p>',
                'sender_id'              => '1',
                'sent_count_cache'       => 0,
                'open_count_cache'       => 0,
                'click_count_cache'      => 0,
                'ga_enabled'             => false,
                'creativity_type'        => 'html',
                'template_source'        => 'editor',
                'template_editor_id'     => '1',
                'default_order_segments' => 'asc',
            ],
        ]))->toBeInstanceOf(Error::class);
    });

    it('returns Error for deleteInstance on failure', function (): void {
        fakeError();

        expect((new CampaignsApi())->deleteInstance('1'))->toBeInstanceOf(Error::class);
    });

    it('returns Error for sendTestEmail on failure', function (): void {
        fakeError();

        expect((new CampaignsApi())->sendTestEmail('1', [
            'instance_in' => ['id' => '1', 'command' => 'test', 'email' => 'a@b.com'],
        ]))->toBeInstanceOf(Error::class);
    });

    it('returns Error for sendCampaign on failure', function (): void {
        fakeError();

        expect((new CampaignsApi())->sendCampaign('1', []))->toBeInstanceOf(Error::class);
    });

    it('returns Error for schedule on failure', function (): void {
        fakeError();

        expect((new CampaignsApi())->schedule('1', ['send_time' => '2025-01-01']))->toBeInstanceOf(Error::class);
    });

    it('returns Error for cancelScheduling on failure', function (): void {
        fakeError();

        expect((new CampaignsApi())->cancelScheduling('1'))->toBeInstanceOf(Error::class);
    });

    it('returns Error for archive on failure', function (): void {
        fakeError();

        expect((new CampaignsApi())->archive('1'))->toBeInstanceOf(Error::class);
    });

    it('returns Error for unarchive on failure', function (): void {
        fakeError();

        expect((new CampaignsApi())->unarchive('1'))->toBeInstanceOf(Error::class);
    });

    it('returns Error for cloning on failure', function (): void {
        fakeError();

        expect((new CampaignsApi())->cloning(['instance_in' => ['id' => '1']]))->toBeInstanceOf(Error::class);
    });

    it('returns Error for getLinkCollection on failure', function (): void {
        fakeError();

        expect((new CampaignsApi())->getLinkCollection('1'))->toBeInstanceOf(Error::class);
    });
});

describe('AutorespondersApi error paths', function (): void {
    it('returns Error for getInstance on failure', function (): void {
        fakeError();

        expect((new AutorespondersApi())->getInstance('1'))->toBeInstanceOf(Error::class);
    });

    it('returns Error for createInstance on failure', function (): void {
        fakeError();

        expect((new AutorespondersApi())->createInstance([
            'instance_in' => [
                'name'                   => 'A',
                'type'                   => 'autoresponder',
                'subject'                => 'S',
                'new_dd'                 => true,
                'html_body'              => '<p>hi</p>',
                'sender_id'              => '1',
                'sent_count_cache'       => 0,
                'open_count_cache'       => 0,
                'click_count_cache'      => 0,
                'ga_enabled'             => false,
                'creativity_type'        => 'html',
                'template_source'        => 'editor',
                'template_editor_id'     => '1',
                'default_order_segments' => 'asc',
                'lists'                  => [['list_id' => '1', 'segment_id' => '1', 'list_name' => 'L', 'segment_name' => 'S']],
            ],
        ]))->toBeInstanceOf(Error::class);
    });

    it('returns Error for updateInstance on failure', function (): void {
        fakeError();

        expect((new AutorespondersApi())->updateInstance('1', [
            'instance_in' => [
                'name'                   => 'A',
                'type'                   => 'autoresponder',
                'subject'                => 'S',
                'new_dd'                 => true,
                'html_body'              => '<p>hi</p>',
                'sender_id'              => '1',
                'sent_count_cache'       => 0,
                'open_count_cache'       => 0,
                'click_count_cache'      => 0,
                'ga_enabled'             => false,
                'creativity_type'        => 'html',
                'template_source'        => 'editor',
                'template_editor_id'     => '1',
                'default_order_segments' => 'asc',
                'lists'                  => [['list_id' => '1', 'segment_id' => '1', 'list_name' => 'L', 'segment_name' => 'S']],
            ],
        ]))->toBeInstanceOf(Error::class);
    });

    it('returns Error for deleteInstance on failure', function (): void {
        fakeError();

        expect((new AutorespondersApi())->deleteInstance('1'))->toBeInstanceOf(Error::class);
    });

    it('returns Error for sendTestEmail on failure', function (): void {
        fakeError();

        expect((new AutorespondersApi())->sendTestEmail('1', [
            'instance_in' => ['id' => '1', 'command' => 'test', 'email' => 'a@b.com'],
        ]))->toBeInstanceOf(Error::class);
    });

    it('returns Error for activate on failure', function (): void {
        fakeError();

        expect((new AutorespondersApi())->activate('1', []))->toBeInstanceOf(Error::class);
    });

    it('returns Error for deactivate on failure', function (): void {
        fakeError();

        expect((new AutorespondersApi())->deactivate('1', []))->toBeInstanceOf(Error::class);
    });

    it('returns Error for cloning on failure', function (): void {
        fakeError();

        expect((new AutorespondersApi())->cloning(['instance_in' => ['id' => '1']]))->toBeInstanceOf(Error::class);
    });

    it('returns Error for getLinksCollection on failure', function (): void {
        fakeError();

        expect((new AutorespondersApi())->getLinksCollection('1'))->toBeInstanceOf(Error::class);
    });
});

describe('SMSApi error paths', function (): void {
    it('returns Error for getBalance on failure', function (): void {
        fakeError();

        expect((new SMSApi())->getBalance())->toBeInstanceOf(Error::class);
    });

    it('returns Error for getStatusMessage on failure', function (): void {
        fakeError();

        expect((new SMSApi())->getStatusMessage('1'))->toBeInstanceOf(Error::class);
    });

    it('returns Error for getBulkMessageStatus on failure', function (): void {
        fakeError();

        expect((new SMSApi())->getBulkMessageStatus('1'))->toBeInstanceOf(Error::class);
    });
});
