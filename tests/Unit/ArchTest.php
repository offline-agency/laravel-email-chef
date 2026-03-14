<?php

declare(strict_types=1);

arch('Api resource classes extend the base Api class')
    ->expect('OfflineAgency\LaravelEmailChef\Api\Resources')
    ->toExtend('OfflineAgency\LaravelEmailChef\Api\Api');

arch('no debug calls leak into src')
    ->expect('OfflineAgency\LaravelEmailChef')
    ->not->toUse(['dd', 'dump', 'var_dump', 'print_r', 'ray']);
