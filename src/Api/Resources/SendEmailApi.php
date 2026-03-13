<?php

namespace OfflineAgency\LaravelEmailChef\Api\Resources;

use OfflineAgency\LaravelEmailChef\Api\Api;
use OfflineAgency\LaravelEmailChef\Entities\Error;
use OfflineAgency\LaravelEmailChef\Entities\SendEmail\SendMail;

class SendEmailApi extends Api
{
    public function sendMail(
        array $body
    ) {
        $response = $this->post('sendmail', $body);

        if (! $response->success) {
            return new Error($response->data);
        }

        $sendMail = $response->data;

        return new SendMail($sendMail);
    }
}
