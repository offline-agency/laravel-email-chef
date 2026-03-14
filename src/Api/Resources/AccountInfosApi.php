<?php

declare(strict_types=1);

namespace OfflineAgency\LaravelEmailChef\Api\Resources;

use Illuminate\Support\Facades\Validator;
use OfflineAgency\LaravelEmailChef\Api\Api;
use OfflineAgency\LaravelEmailChef\Entities\AccountInfos\GetInstance;
use OfflineAgency\LaravelEmailChef\Entities\Error;

class AccountInfosApi extends Api
{
    public function getInstance(
        string $accountId,
    ): mixed {
        $response = $this->get('account_infos/'.$accountId);

        if (! $response->success) {
            return new Error($response->data);
        }

        return new GetInstance($response->data);
    }

    /**
     * @param array<string, mixed> $instance_in
     */
    public function update(
        array $instance_in = [],
    ): mixed {
        $validator = Validator::make($instance_in, [
            'firstname'    => 'required|string',
            'lastname'     => 'required|string',
            'business'     => 'required|string',
            'address_1'    => 'required|string',
            'city'         => 'required|string',
            'country'      => 'required|string',
            'phone_number' => 'required|string',
            'postal_code'  => 'required|string',
            'website'      => 'required|string',
        ]);

        if ($validator->fails()) {
            return $validator->errors();
        }

        $response = $this->put('account_infos', [
            'instance_in' => $instance_in,
        ]);

        if (! $response->success) {
            return new Error($response->data);
        }

        return $response->data;
    }
}
