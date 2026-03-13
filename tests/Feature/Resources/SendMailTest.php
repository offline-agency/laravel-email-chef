<?php

namespace OfflineAgency\LaravelEmailChef\Tests\Feature\Resources;

use OfflineAgency\LaravelEmailChef\Api\Resources\SendEmailApi;
use OfflineAgency\LaravelEmailChef\Entities\SendEmail\SendMail;
use OfflineAgency\LaravelEmailChef\Tests\TestCase;

class SendMailTest extends TestCase
{
    public function test_send_mail()
    {
        $sendMail = new SendEmailApi();

        $response = $sendMail->sendMail(
            [
                'instance_in' => [
                    'sender_id' => '40086',
                    'to' => [
                        'email' => 'email',
                        'name' => 'John Smith',
                    ],
                    'subject' => 'Subject here',
                    'text_body' => 'Plain text body here',
                    'html_body' => 'Full HTML body here',
                    'reply_to' => '',
                ],
            ]
        );

        $this->assertInstanceOf(SendMail::class, $response);
    }
}
