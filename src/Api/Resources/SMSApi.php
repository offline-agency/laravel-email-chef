<?php

declare(strict_types=1);

namespace OfflineAgency\LaravelEmailChef\Api\Resources;

use OfflineAgency\LaravelEmailChef\Api\Api;
use OfflineAgency\LaravelEmailChef\Entities\Error;
use OfflineAgency\LaravelEmailChef\Entities\SMS\Balance;
use OfflineAgency\LaravelEmailChef\Entities\SMS\BulkMessageStatus;
use OfflineAgency\LaravelEmailChef\Entities\SMS\Send;
use OfflineAgency\LaravelEmailChef\Entities\SMS\StatusMessage;

final class SMSApi extends Api
{
    /**
     * @param array<string, mixed> $body
     */
    public function send(
        array $body,
    ): mixed {
        $response = $this->post('sms/send', $body);

        if (! $response->success) {
            return Error::fromResponse($response->data);
        }

        $send = $response->data;

        return Send::fromResponse($send);
    }

    public function getBalance(): mixed {
        $response = $this->get('sms/balance');

        if (! $response->success) {
            return Error::fromResponse($response->data);
        }

        $getBalance = $response->data;

        return Balance::fromResponse($getBalance);
    }

    public function getStatusMessage(
        string $messageId,
    ): mixed {
        $response = $this->get('sms/status/'.$messageId);

        if (! $response->success) {
            return Error::fromResponse($response->data);
        }

        $getStatusMessage = $response->data;

        return StatusMessage::fromResponse($getStatusMessage);
    }

    public function getBulkMessageStatus(
        string $bulkId,
    ): mixed {
        $response = $this->get('sms/bulk/status/'.$bulkId);

        if (! $response->success) {
            return Error::fromResponse($response->data);
        }

        $getBulkMessageStatus = $response->data;

        return BulkMessageStatus::fromResponse($getBulkMessageStatus);
    }
}
