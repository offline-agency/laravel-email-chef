<?php

declare(strict_types=1);

namespace OfflineAgency\LaravelEmailChef\Entities;

final readonly class Error
{
    use Hydratable;

    public function __construct(
        public ?object $error = null,
    ) {}
}
