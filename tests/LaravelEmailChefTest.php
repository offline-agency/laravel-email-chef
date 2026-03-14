<?php

declare(strict_types=1);

namespace OfflineAgency\LaravelEmailChef\Tests;

use OfflineAgency\LaravelEmailChef\LaravelEmailChef;

class LaravelEmailChefTest extends TestCase
{
    /**
     * @throws \Exception
     */
    public function test_login() {
        $laravelEmailChef = new LaravelEmailChef();

        $laravelEmailChef->login();

        $this->assertNotNull($laravelEmailChef->getAuthKey());
    }

    /**
     * @throws \Exception
     */
    public function test_wrong_login() {
        $this->markTestIncomplete();
        $LaravelEmailChef = new LaravelEmailChef();

        $LaravelEmailChef->login();

        $this->assertNull($laravelEmailChef->getAuthKey());
    }
}
