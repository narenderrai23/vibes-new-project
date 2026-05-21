<?php

/**
 * Livewire Component compatibility stub.
 *
 * Satisfies vendor packages that extend Livewire\Component
 * after livewire/livewire has been removed from the project.
 */

namespace Livewire;

abstract class Component
{
    public function render(): mixed
    {
        return null;
    }

    public function __call(string $method, array $args): mixed
    {
        return null;
    }

    public static function __callStatic(string $method, array $args): mixed
    {
        return null;
    }
}
