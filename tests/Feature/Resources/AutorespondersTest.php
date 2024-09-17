<?php

namespace OfflineAgency\LaravelEmailChef\Tests\Feature\Resources;

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
use OfflineAgency\LaravelEmailChef\Tests\TestCase;

class AutorespondersTest extends TestCase
{
    //TODO check
    public function test_get_count()
    {
        $autoresponder = new AutorespondersApi();

        $response = $autoresponder->getCount();
        //dd($response);
        $this->assertInstanceOf(AutoresponderCount::class, $response);
        $this->assertIsString($response->totalcount);
    }

    public function test_get_collection()
    {
        $autoresponder = new AutorespondersApi;

        $response = $autoresponder->getCollection(
            null,
            null,
            'n',
            'a'
        );

        $single_autoresponder = $response->first();
        $this->assertInstanceOf(AutoresponderCollection::class, $single_autoresponder);
    }

    public function test_get_instance()
    {
        $autoresponder = new AutorespondersApi;

        $response = $autoresponder->getInstance(
            '404282'
        );

        $this->assertInstanceOf(Autoresponder::class, $response);
    }

    public function test_create_instance()
    {
        $autoresponder = new AutorespondersApi;

        $response = $autoresponder->createInstance([
            'instance_in' => [
                'id' => null,
                'name' => 'test1',
                'type' => 'AUTORESPONDER',
                'subject' => '[[email]]',
                'new_dd' => '1',
                'html_body' => 'html',
                'sender_id' => '40086',
                'template_id' => null,
                'sent_count_cache' => '0',
                'open_count_cache' => '0',
                'click_count_cache' => '0',
                'cache_update_time' => null,
                'ga_enabled' => false,
                'ga_campaign_title' => '',
                'lists' => [
                    [
                        'list_id' => '108094',
                        'segment_id' => '74016',
                        'list_name' => 'Test nsc',
                        'segment_name' => 'final',
                    ],
                ],
                'creativity_type' => 'ready_made',
                'template_source' => '1365',
                'template_editor_id' => '505106',
                'autoresponder' => [
                    'id' => null,
                    'trigger_id' => '1',
                    'active' => 'INACTIVE',
                    'hours_delay' => 0,
                    'campaign_id' => null,
                    'link_id' => null,
                ],
                'default_order_segments' => 'ANY',
            ],
        ]);

        $this->assertInstanceOf(CreateAutoresponder::class, $response);
    }

    public function test_update_instance()
    {
        $autoresponder = new AutorespondersApi;

        $response = $autoresponder->updateInstance(
            '403132',
            [
                'instance_in' => [
                    'id' => null,
                    'name' => 'updated test',
                    'type' => 'AUTORESPONDER',
                    'subject' => '[[email]]',
                    'new_dd' => '1',
                    'html_body' => 'html',
                    'sender_id' => '40086',
                    'template_id' => null,
                    'sent_count_cache' => '0',
                    'open_count_cache' => '0',
                    'click_count_cache' => '0',
                    'cache_update_time' => null,
                    'ga_enabled' => false,
                    'ga_campaign_title' => '',
                    'lists' => [
                        [
                            'list_id' => '108094',
                            'segment_id' => '74016',
                            'list_name' => 'Test nsc',
                            'segment_name' => 'final',
                        ],
                    ],
                    'creativity_type' => 'ready_made',
                    'template_source' => '1365',
                    'template_editor_id' => '505106',
                    'autoresponder' => [
                        'id' => null,
                        'trigger_id' => '1',
                        'active' => 'INACTIVE',
                        'hours_delay' => 0,
                        'campaign_id' => null,
                        'link_id' => null,
                    ],
                    'default_order_segments' => 'ANY',
                ],
            ]
        );

        $this->assertInstanceOf(UpdateAutoresponder::class, $response);
    }

    //TODO check
    public function test_delete_instance()
    {
        $this->markTestIncomplete();
        $autoresponder = new AutorespondersApi;

        $response = $autoresponder->deleteInstance(
            '404334'
        );
        dd($response);
        $this->assertInstanceOf(AutoresponderDeletion::class, $response);
    }

    public function test_send_test_email()
    {
        $autoresponder = new AutorespondersApi;

        $response = $autoresponder->sendTestEmail(
            '403128',
            [
                'instance_in' => [
                    'id' => '403128',
                    'command' => 'send_test',
                    'email' => 'email',
                ],
            ]
        );

        $this->assertInstanceOf(SendTestEmail::class, $response);
    }

    public function test_activate()
    {
        $autoresponder = new AutorespondersApi;

        $response = $autoresponder->activate(
            '404282',
            [
                'instance_in' => [
                    'autoresponder' => [
                        'active' => 'ACTIVE',
                    ],
                ],
            ]
        );

        $this->assertInstanceOf(AutoresponderActivation::class, $response);
    }

    public function test_deactivate()
    {
        $autoresponder = new AutorespondersApi;

        $response = $autoresponder->deactivate(
            '404282',
            [
                'instance_in' => [
                    'autoresponder' => [
                        'active' => 'INACTIVE',
                    ],
                ],
            ]
        );

        $this->assertInstanceOf(AutoresponderActivation::class, $response);
    }

    public function test_cloning()
    {
        $autoresponder = new AutorespondersApi;

        $response = $autoresponder->cloning(
            [
                'instance_in' => [
                    'id' => '404282',
                ],
            ]
        );

        $this->assertInstanceOf(Cloning::class, $response);
    }

    public function test_get_Link_Collection()
    {
        $autoresponder = new AutorespondersApi;

        $response = $autoresponder->getLinksCollection(
            '404282'
        );

        $this->assertInstanceOf(AutoresponderLinks::class, $response);
    }
}
