<?php

namespace OfflineAgency\LaravelEmailChef\Tests\Feature\Resources;

use OfflineAgency\LaravelEmailChef\Api\Resources\AccountApi;
use OfflineAgency\LaravelEmailChef\Entities\Account\AccountEntity;
use OfflineAgency\LaravelEmailChef\Tests\TestCase;

class AccountTest extends TestCase
{
    public function test_get_collection()
    {
        $account = new AccountApi();

        $response = $account->getCollection();

        $this->assertInstanceOf(AccountEntity::class, $response);
        $this->assertIsString($response->id);
        $this->assertIsString($response->email);
        $this->assertIsString($response->lang);
        $this->assertIsString($response->status);
        $this->assertIsString($response->whiteLabeled);
        $this->assertIsString($response->relayBounces);
        $this->assertIsString($response->bounceSuppress);
        $this->assertIsString($response->allowWebsiteAccess);
        $this->assertIsString($response->total);
        $this->assertIsString($response->bounce);
        $this->assertIsString($response->complaints);
        $this->assertIsString($response->mode);
        $this->assertIsString($response->logo_url);
        $this->assertIsString($response->dummy);
        $this->assertIsString($response->beta_tester);
        $this->assertIsString($response->subscribers);
        $this->assertIsString($response->s_token);
    }
}
