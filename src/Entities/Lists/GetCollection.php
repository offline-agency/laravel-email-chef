<?php

declare(strict_types=1);

namespace OfflineAgency\LaravelEmailChef\Entities\Lists;

use Carbon\Carbon;
use OfflineAgency\LaravelEmailChef\Entities\Hydratable;

final readonly class GetCollection
{
    use Hydratable;

    public function __construct(
        public string $name = '',
        public string $id = '',
        public ?string $description = null,
        public ?Carbon $date = null,
        public mixed $demo = null,
        public string $active = '',
        public string $subscribed = '',
        public string $unsubscribed = '',
        public string $bounced = '',
        public string $reported = '',
        public string $segments = '',
        public int $forms = 0,
    ) {}
}
