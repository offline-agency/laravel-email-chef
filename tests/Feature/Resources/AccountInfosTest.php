<?php

namespace OfflineAgency\LaravelEmailChef\Tests\Feature\Resources;

use OfflineAgency\LaravelEmailChef\Api\Resources\AccountInfosApi;
use OfflineAgency\LaravelEmailChef\Entities\AccountInfos\GetInstance;
use OfflineAgency\LaravelEmailChef\Tests\TestCase;

class AccountInfosTest extends TestCase
{
    public function test_get_instance()
    {
        $account = new AccountInfosApi();

        $response = $account->getInstance('810136');

        $this->assertInstanceOf(GetInstance::class, $response);
    }

    public function test_update()
    {
        $account = new AccountInfosApi();

        $response = $account->update(
            [
                'firstname' => 'Giacomo',
                'lastname' => 'Fabbian',
                'business' => 'Offline Agency s.r.l.',
                'address_1' => 'Viale del Lavoro, 23',
                'city' => 'Padova',
                'country' => 'IT',
                'phone_number' => '00393407187100',
                'postal_code' => '35020',
                'website' => 'https://offlineagency.com',
            ]
        );

        $this->assertIsObject($response);
    }
}
