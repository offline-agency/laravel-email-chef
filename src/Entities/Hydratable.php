<?php

declare(strict_types=1);

namespace OfflineAgency\LaravelEmailChef\Entities;

use ReflectionClass;

trait Hydratable
{
    /**
     * Create an instance from an API response object.
     *
     * Maps response properties to constructor parameters by name,
     * ignoring any extra fields not present in the constructor.
     */
    public static function fromResponse(?object $data): static {
        if ($data === null) {
            return new static();
        }

        $values = (array) $data;
        $constructor = (new ReflectionClass(static::class))->getConstructor();

        if ($constructor === null) {
            return new static();
        }

        $args = [];

        foreach ($constructor->getParameters() as $param) {
            $name = $param->getName();

            if (array_key_exists($name, $values)) {
                $args[$name] = $values[$name];
            }
        }

        return new static(...$args);
    }
}
