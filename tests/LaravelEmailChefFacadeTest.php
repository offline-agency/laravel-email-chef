<?php

declare(strict_types=1);

namespace OfflineAgency\LaravelEmailChef\Tests;

use Mockery;
use OfflineAgency\LaravelEmailChef\LaravelEmailChef;

class LaravelEmailChefFacadeTest extends TestCase
{
    /**
     * @test
     */
    public function it_loads_facade_alias() {
        $this->app->singleton(
            'laravel-email-chef',
            static function ($app) {
                return Mockery::mock(LaravelEmailChef::class, static function ($mock) {
                    $mock->shouldReceive('test');
                });
            },
        );

        \LaravelEmailChef::test();

        $this->assertTrue(true);
    }
}
