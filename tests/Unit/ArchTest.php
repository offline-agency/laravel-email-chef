<?php

declare(strict_types=1);

arch('Api resource classes extend the base Api class')
    ->expect('OfflineAgency\LaravelEmailChef\Api\Resources')
    ->toExtend('OfflineAgency\LaravelEmailChef\Api\Api');

arch('Api resource classes are final')
    ->expect('OfflineAgency\LaravelEmailChef\Api\Resources')
    ->toBeFinal();

arch('Entities are readonly')
    ->expect('OfflineAgency\LaravelEmailChef\Entities')
    ->toBeReadonly()
    ->ignoring('OfflineAgency\LaravelEmailChef\Entities\Hydratable');

arch('no debug calls leak into src')
    ->expect('OfflineAgency\LaravelEmailChef')
    ->not->toUse(['dd', 'dump', 'var_dump', 'print_r', 'ray']);
