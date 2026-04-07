<?php

declare(strict_types=1);

namespace OfflineAgency\LaravelEmailChef\Api\Resources;

use OfflineAgency\LaravelEmailChef\Api\Api;
use OfflineAgency\LaravelEmailChef\Entities\Error;
use OfflineAgency\LaravelEmailChef\Entities\SendEmail\SendMail;

final class SendEmailApi extends Api
{
    /**
     * @param array<string, mixed> $body
     */
    public function sendMail(
        array $body,
    ): mixed {
        $response = $this->post('sendmail', $body);

        if (! $response->success) {
            return Error::fromResponse($response->data);
        }

        $sendMail = $response->data;

        return SendMail::fromResponse($sendMail);
    }
}
