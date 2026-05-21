<?php

/**
 * Livewire compatibility stub.
 *
 * This stub satisfies vendor packages that reference Livewire::component()
 * after livewire/livewire has been removed from the project.
 * All methods are no-ops.
 */

namespace Livewire;

class Livewire
{
    public static function component(string $name, string $class): void
    {
        // No-op: Livewire has been removed from this project.
    }

    public static function __callStatic(string $method, array $args): mixed
    {
        return null;
    }
}
