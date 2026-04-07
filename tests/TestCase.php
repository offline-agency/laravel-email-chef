<?php

declare(strict_types=1);

namespace Tests;

use OfflineAgency\LaravelEmailChef\LaravelEmailChefFacade;
use OfflineAgency\LaravelEmailChef\LaravelEmailChefServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

abstract class TestCase extends Orchestra
{
    protected function getPackageProviders($app): array {
        return [LaravelEmailChefServiceProvider::class];
    }

    protected function getPackageAliases($app): array {
        return [
            'LaravelEmailChef' => LaravelEmailChefFacade::class,
        ];
    }

    protected function getEnvironmentSetUp($app): void {
        $app['config']->set('email-chef.baseUrl', 'https://app.emailchef.com/apps/api/v1/');
        $app['config']->set('email-chef.login_url', 'https://app.emailchef.com/api/');
        $app['config']->set('email-chef.username', env('EMAIL_CHEF_USERNAME', 'test_user'));
        $app['config']->set('email-chef.password', env('EMAIL_CHEF_PASSWORD', 'test_password'));
    }
}
