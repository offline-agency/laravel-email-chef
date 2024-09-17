<?php

namespace OfflineAgency\LaravelEmailChef\Tests\Feature\Resources;

use OfflineAgency\LaravelEmailChef\Api\Resources\SMSApi;
use OfflineAgency\LaravelEmailChef\Entities\SMS\Balance;
use OfflineAgency\LaravelEmailChef\Entities\SMS\BulkMessageStatus;
use OfflineAgency\LaravelEmailChef\Entities\SMS\Send;
use OfflineAgency\LaravelEmailChef\Entities\SMS\StatusMessage;
use OfflineAgency\LaravelEmailChef\Tests\TestCase;

class SMSTest extends TestCase
{
    //TODO test
    public function test_send()
    {
        $this->markTestIncomplete();
        $SMS = new SMSApi();

        $response = $SMS->send(
            [
                'instance_in' => [
                    'from' => '39000',
                    'to' => '39001;39002',
                    'bulk_id' => 'bulk_campaign_name',
                    'text' => 'sms text',
                    'notify_url' => '"url for message statuses notification',
                ],
            ]
        );

        $this->assertInstanceOf(Send::class, $response);
    }

    //TODO test
    public function test_get_balance()
    {
        $this->markTestIncomplete();
        $SMS = new SMSApi();

        $response = $SMS->getBalance();

        $this->assertInstanceOf(Balance::class, $response);
    }

    //TODO test
    public function test_get_status_message()
    {
        $this->markTestIncomplete();
        $SMS = new SMSApi();

        $response = $SMS->getStatusMessage(
            '123456'
        );

        $this->assertInstanceOf(StatusMessage::class, $response);
    }

    //TODO test
    public function test_get_bulk_message_status()
    {
        $this->markTestIncomplete();
        $SMS = new SMSApi();

        $response = $SMS->getBulkMessageStatus(
            'bulk id provided'
        );

        $this->assertInstanceOf(BulkMessageStatus::class, $response);
    }
}
