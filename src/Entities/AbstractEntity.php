<?php

declare(strict_types=1);

namespace OfflineAgency\LaravelEmailChef\Entities;

abstract class AbstractEntity
{
    public function __construct(
        ?object $parameters,
    ) {
        if (is_null($parameters)) {
            return;
        }

        $parameters = get_object_vars($parameters);

        $this->build($parameters);
    }

    /**
     * @param array<string, mixed> $parameters
     */
    private function build(
        array $parameters,
    ): void {
        foreach ($parameters as $property => $value) {
            if (property_exists($this, $property)) {
                $this->$property = $value;
            }
        }
    }
}
