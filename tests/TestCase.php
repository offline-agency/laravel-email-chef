<?php

declare(strict_types=1);

namespace OfflineAgency\LaravelEmailChef\Tests;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Foundation\Bootstrap\LoadEnvironmentVariables;
use Illuminate\Support\Facades\Config;
use OfflineAgency\LaravelEmailChef\LaravelEmailChefFacade;
use OfflineAgency\LaravelEmailChef\LaravelEmailChefServiceProvider;
use Orchestra\Testbench\TestCase as BaseTestCase;

class TestCase extends BaseTestCase
{
    protected function setUp(): void {
        parent::setUp();
        Config::set('email-chef.baseUrl', 'https://app.emailchef.com/apps/api/v1/');
        Config::set('email-chef.login_url', 'https://app.emailchef.com/api/');
        Config::set('email-chef.username', env('EMAIL_CHEF_USERNAME'));
        Config::set('email-chef.password', env('EMAIL_CHEF_PASSWORD'));
        Config::set('email-chef.list_id', '97322');

        Factory::guessFactoryNamesUsing(
            static fn (string $modelName) => 'OfflineAgency\\LaravelEmailChef\\Database\\Factories\\'.class_basename($modelName).'Factory',
        );
    }

    protected function getPackageProviders($app) {
        return [
            LaravelEmailChefServiceProvider::class,
        ];
    }

    public function getPackageAliases(
        $app,
    ): array {
        return [
            'LaravelEmailChef' => LaravelEmailChefFacade::class,
        ];
    }

    protected function getEnvironmentSetUp($app) {
        // make sure, our .env file is loaded
        $app->useEnvironmentPath(__DIR__.'/..');
        $app->bootstrapWith([LoadEnvironmentVariables::class]);
        parent::getEnvironmentSetUp($app);
    }
}
