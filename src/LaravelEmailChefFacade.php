<?php

declare(strict_types=1);

namespace OfflineAgency\LaravelEmailChef;

use Illuminate\Support\Facades\Facade;

/**
 * @see LaravelEmailChef
 */
class LaravelEmailChefFacade extends Facade
{
    protected static function getFacadeAccessor() {
        return 'laravel-email-chef';
    }
}
