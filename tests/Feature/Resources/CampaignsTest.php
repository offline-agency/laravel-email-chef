<?php

namespace OfflineAgency\LaravelEmailChef\Tests\Feature\Resources;

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
use OfflineAgency\LaravelEmailChef\Tests\TestCase;

class CampaignsTest extends TestCase
{
    public function test_get_count()
    {
        $campaign = new CampaignsApi;

        $response = $campaign->getCount();

        $this->assertInstanceOf(CampaignCount::class, $response);
        $this->assertIsString($response->saved_draft_counter);
        $this->assertIsString($response->sent_counter);
        $this->assertIsString($response->scheduled_counter);
        $this->assertIsString($response->archived_counter);
        $this->assertIsString($response->failed_counter);
    }

    public function test_get_collection()
    {
        $campaign = new CampaignsApi;

        $response = $campaign->getCollection(
            'DRAFT',
            null,
            null,
            't',
            'a'
        );

        $single_campaign = $response->first();
        $this->assertInstanceOf(CampaignCollection::class, $single_campaign);
    }

    public function test_get_instance()
    {
        $campaign = new CampaignsApi;

        $response = $campaign->getInstance(
            '404596'
        );

        $this->assertInstanceOf(Campaign::class, $response);
        $this->assertIsString($response->id);
    }

    public function test_create_instance()
    {
        $campaign = new CampaignsApi;

        $response = $campaign->createInstance([

            'instance_in' => [
                'id' => null,
                'name' => 'campaign',
                'type' => 'CAMPAIGN',
                'subject' => null,
                'new_dd' => 1,
                'html_body' => 'html body here',
                'sender_id' => '40086',
                'template_id' => null,
                'sent_count_cache' => '0',
                'open_count_cache' => '0',
                'click_count_cache' => '0',
                'cache_update_time' => null,
                'ga_enabled' => false,
                'ga_campaign_title' => '',
                'lists' => [],
                'creativity_type' => 'ready_made',
                'template_source' => '1365',
                'template_editor_id' => '504778',
                'pre_header' => '',
                'campaign' => [
                    'id' => null,
                    'recipients_count_cache' => '0',
                    'status' => 'DRAFT',
                    'scheduled_time' => null,
                ],
                'default_order_segments' => 'ANY',
            ],
        ]);

        $this->assertInstanceOf(CreateCampaign::class, $response);
    }

    public function test_update_instance()
    {
        $campaign = new CampaignsApi;

        $response = $campaign->updateInstance(
            '402978',
            [
                'instance_in' => [
                    'id' => null,
                    'name' => 'updated campaign',
                    'type' => 'CAMPAIGN',
                    'subject' => null,
                    'new_dd' => 1,
                    'html_body' => 'html body here',
                    'sender_id' => '40086',
                    'template_id' => null,
                    'sent_count_cache' => '0',
                    'open_count_cache' => '0',
                    'click_count_cache' => '0',
                    'cache_update_time' => null,
                    'ga_enabled' => false,
                    'ga_campaign_title' => '',
                    'lists' => [],
                    'creativity_type' => 'ready_made',
                    'template_source' => '1365',
                    'template_editor_id' => '504778',
                    'pre_header' => '',
                    'campaign' => [
                        'id' => null,
                        'recipients_count_cache' => '0',
                        'status' => 'DRAFT',
                        'scheduled_time' => null,
                    ],
                    'default_order_segments' => 'ANY',
                ],
            ]
        );

        $this->assertInstanceOf(UpdateCampaign::class, $response);
    }

    public function test_delete_instance()
    {
        $campaign = new CampaignsApi;

        $response = $campaign->deleteInstance(
            '404594'
        );

        $this->assertInstanceOf(CampaignDeletion::class, $response);
    }

    public function test_send_test_email()
    {
        $campaign = new CampaignsApi;

        $response = $campaign->sendTestEmail(
            '404596',
            [
                'instance_in' => [
                    'id' => '404596',
                    'command' => 'send_test',
                    'email' => 'email',
                ],
            ]
        );

        $this->assertInstanceOf(SendTestEmail::class, $response);
    }

    public function test_send_campaign()
    {
        $campaign = new CampaignsApi;

        $response = $campaign->sendCampaign(
            '404596',
            [
                'instance_in' => [
                    'id' => '404596',
                    'command' => 'send_all',
                ],
            ]
        );

        $this->assertInstanceOf(SendCampaign::class, $response);
    }

    public function test_schedule()
    {
        $campaign = new CampaignsApi;

        $response = $campaign->schedule(
            '404596',
            [
                'instance_in' => [
                    'id' => '404596',
                    'command' => 'schedule',
                ],
            ]
        );

        $this->assertInstanceOf(Schedule::class, $response);
    }

    public function test_cancel_scheduling()
    {
        $campaign = new CampaignsApi;

        $response = $campaign->cancelScheduling(
            '404596'
        );

        $this->assertInstanceOf(CancelScheduling::class, $response);
    }

    public function test_archive()
    {
        $campaign = new CampaignsApi;

        $response = $campaign->archive(
            '404596'
        );

        $this->assertInstanceOf(CampaignArchiving::class, $response);
    }

    public function test_unarchive()
    {
        $campaign = new CampaignsApi;

        $response = $campaign->unarchive(
            '404596'
        );

        $this->assertInstanceOf(CampaignArchiving::class, $response);
    }

    public function test_cloning()
    {
        $campaign = new CampaignsApi;

        $response = $campaign->cloning(
            [
                'instance_in' => [
                    'id' => '404592',
                ],
            ]
        );

        $this->assertInstanceOf(Cloning::class, $response);
    }

    public function test_get_Link_Collection()
    {
        $campaign = new CampaignsApi;

        $response = $campaign->getLinkCollection(
            '404596'
        );

        $this->assertInstanceOf(LinkCollection::class, $response);
    }
}
