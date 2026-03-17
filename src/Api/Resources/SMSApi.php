<?php

declare(strict_types=1);

namespace OfflineAgency\LaravelEmailChef\Api\Resources;

use OfflineAgency\LaravelEmailChef\Api\Api;
use OfflineAgency\LaravelEmailChef\Entities\Error;
use OfflineAgency\LaravelEmailChef\Entities\SMS\Balance;
use OfflineAgency\LaravelEmailChef\Entities\SMS\BulkMessageStatus;
use OfflineAgency\LaravelEmailChef\Entities\SMS\Send;
use OfflineAgency\LaravelEmailChef\Entities\SMS\StatusMessage;

class SMSApi extends Api
{
    /**
     * @param array<string, mixed> $body
     */
    public function send(
        array $body,
    ): mixed {
        $response = $this->post('sms/send', $body);

        if (! $response->success) {
            return new Error($response->data);
        }

        $send = $response->data;

        return new Send($send);
    }

    public function getBalance(): mixed {
        $response = $this->get('sms/balance');

        if (! $response->success) {
            return new Error($response->data);
        }

        $getBalance = $response->data;

        return new Balance($getBalance);
    }

    public function getStatusMessage(
        string $messageId,
    ): mixed {
        $response = $this->get('sms/status/'.$messageId);

        if (! $response->success) {
            return new Error($response->data);
        }

        $getStatusMessage = $response->data;

        return new StatusMessage($getStatusMessage);
    }

    public function getBulkMessageStatus(
        string $bulkId,
    ): mixed {
        $response = $this->get('sms/bulk/status/'.$bulkId);

        if (! $response->success) {
            return new Error($response->data);
        }

        $getBulkMessageStatus = $response->data;

        return new BulkMessageStatus($getBulkMessageStatus);
    }
}
